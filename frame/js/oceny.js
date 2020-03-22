
function pobierzKursy(idPrzedmiot) {
    $.ajax({
        url: "http://localhost/frame/get/kursy",
        method: "post",
        responseType: "json",
        data: {
            przedmiot: idPrzedmiot
        },
        success: function (response) { pokazKursy(response, idPrzedmiot) },
        error: function () { alert("cos nie tak"); }
    });
}
function pokazKursy(nazwaPrzedmiotow, idPrzedmiot) {
    console.log(nazwaPrzedmiotow);
    var przedmioty = document.getElementById("container-left").innerHTML;
    sessionStorage.setItem('Przedmioty', przedmioty);
    sessionStorage.setItem('idPrzedmiot', idPrzedmiot);
    var html = "<h3>Wybierz zajecia: </h3>";
    html += "<h4><ul>";
    for (var item of JSON.parse(nazwaPrzedmiotow)) {
        html += "<li> <a href='javascript:pobierzZajecia(" + '"' + item.nazwa + '",' + '"' + item.id_kurs + '"' + ")'" + ">" + item.nazwa + "</a></li>";
    }
    html += "<li><a href='javascript:pokazDodawnieKursu()'>Dodaj nowy kurs</a></li>";
    html += "</h4></ul>";
    document.getElementById("container-left").innerHTML = html;
}
function pobierzZajecia(nazwaPrzedmiot, idKurs) {
    $.ajax({
        url: "http://localhost/frame/get/zajecia",
        method: "post",
        responseType: "json",
        data: {
            id: idKurs
        },
        success: function (response) { pokazZajecia(JSON.parse(response), idKurs) },
        error: function () { console.log("Cos nie tak"); }
    });
}
function pokazZajecia(zajecia, idKurs) {
    var i = 1;
    console.log(zajecia);
    var html = "<h3>Zajecia :</h3><ul>";
    zajecia.forEach(element => {
        html += "<li><a href='javascript:pobierzJedneZajecia(" + element.id_zajecia + "," + idKurs + ")'>" + i + ": " + element.data + "</li>";
        i++;
    });
    
    html += "</ul>"
    $.ajax({
        url: "http://localhost/frame/get/ocenyAll",
        method: "post",
        responseType: "json",
        data: {
            idKurs: idKurs
        },
        success: function (response) { pokazSrednie(response); },
        error: function () { console.log("Cos nie tak"); }
    });
    document.getElementById("container-right").innerHTML = html;
}
function pokazSrednie(response){
    response=JSON.parse(response);
    console.log(response);
    var dodano = false;
    var obiekt = {
        id_uczen : 0,
        imie : '',
        nazwisko : '',
        ilosc : 0,
        ocena : 0
    };
    var uczniowie = [];
    response.forEach(element => {
        for(var i=0;i<uczniowie.length;i++){
            if(element.id_uczen==uczniowie[i].id_uczen && element.ocena != null){
                uczniowie[i].ilosc-=-element.waga;
                uczniowie[i].ocena-=-(element.waga*element.ocena);
                dodano=true;
                break;}
        }
        if(dodano==false && element.ocena != null){
            uczniowie.push({"id_uczen":element.id_uczen,
            "imie" : element.imie,
            "nazwisko" : element.nazwisko,
            "ilosc" : element.waga,
            "ocena" : (element.waga*element.ocena)});}
        dodano=false;
    });
    let html = '<table><tr><th>Imie</th><th>Nazwisko</th><th>Srednia</th></tr>';
    uczniowie.forEach(element => {
        console.log(element);
        html+= "<tr><td>"+element.imie+"</td><td>"+element.nazwisko+"</td><td>"+(element.ocena/element.ilosc)+"</td></tr>"
    });
    html+="</table>";
    document.getElementById('container-right').innerHTML += html;
}
function pobierzJedneZajecia(idZajecia, idKurs) {
    $.ajax({
        url: "http://localhost/frame/get/jednezajecia",
        method: "post",
        responseType: "json",
        data: {
            idKursu: idKurs,
            idZajec: idZajecia
        },
        success: function (response) { pobierzOceny(response, idZajecia) },
        error: function () { console.log("Cos nie tak"); }
    });
}
function pobierzOceny(idUczniowie, idZajecia) {
    console.log('pobieram oceny: ' + idUczniowie);
    var html = "<h4>Oceny:</h4>"
    var html2 = "<select menu='oceny' id='ocenyDoUsuniecia'>"
    html += "<table border='2' >";
    document.getElementById("container-right").innerHTML = "";
    idUczniowie = JSON.parse(idUczniowie);
    html1="</br></br> <table><tr><td> Dane ucznia </td><td> Ocena </td><td> Forma oceny</td><td> Waga </br></tr><tr><td><select menu='uczniowie' id='uczniowie'>";
    $.ajax({
        url: "http://localhost/frame/get/oceny",
        method: "post",
        responseType: "json",
        data: {
            idZajec: idZajecia
        },
        success: function (response) {
            console.log(response);
                response = JSON.parse(response);
                response.forEach(element => {
                    html += "<tr><td>" + element.imie + " " + element.nazwisko + "</td>";
                    if(element.ocena!=null){html+="<td> Forma: " + element.forma + "</td><td> Ocena:" + element.ocena + " </td><td>Waga:" + element.waga + "</td></tr>";}
                    else{html+="<td>Brak ocen</td><td></td><td></td></tr>";}
                    html1+="<option  value='"+element.id_uczen+"'>"+element.imie+" "+element.nazwisko+" </option>";
                    html2+="<option value='"+element.id_oceny+"'>"+element.ocena+" "+element.forma+"</option>";
                });
                html+="</table>";
                html1+="</select></td><td><select menu='oceny' id='oceny'><option value='1'>1</option><option value='2'>1</option><option value='2'>2</option><option value='2'>3</option>";
                html1+="<option value='4'>4</option><option value='5'>5</option><option value='6'>6</option></select></td><td>";
                html1+="<input type='text' id='forma'></input></td><td>";
                html1+="<input type='number' id='waga'></input></td></tr></table>";
                html1+="</select><input type='button' value='Dodaj ocene' onclick='javascript:zaktualizujOceny("+idZajecia+")'></br></br>";
                html2+="</select><input type='button' style='margin-left:5px' value='Usun ocene' onclick='javascript:usunOcene()'>";
                html2+="</select><input type='button' style='margin-left:10px' value='Zmien ocene' onclick='javascript:zmienOcene()'></br>";
                document.getElementById("container-right").innerHTML += html;
                document.getElementById("container-right").innerHTML += html1;
                document.getElementById("container-right").innerHTML += html2;
            
        },
        error: function () { console.log("Cos nie tak"); }
    });

}
function usunOcene(){
    var id_ocena = document.getElementById("ocenyDoUsuniecia");
    id_ocena = id_ocena.options[id_ocena.selectedIndex].value;
    $.ajax({
        url: "http://localhost/frame/del/ocena",
        method: "post",
        responseType: "json",
        data: {
            id_ocena : id_ocena
        },
        success: function (response) { console.log(response);sukces() },
        error: function () { alert("Cos nie tak"); }
    });
}
function zmienOcene(){
    var id_uczen = document.getElementById("uczniowie");
    id_uczen = id_uczen.options[id_uczen.selectedIndex].value;
    var id_ocena = document.getElementById("ocenyDoUsuniecia");
    id_ocena = id_ocena.options[id_ocena.selectedIndex].value
    var forma = document.getElementById("forma").value;
    var waga = document.getElementById("waga").value;
    var ocena = document.getElementById("oceny");
    ocena = ocena.options[ocena.selectedIndex].value;
    console.log(id_uczen+" "+forma+" "+waga+" "+ocena);
        $.ajax({
            url: "http://localhost/frame/update/ocena",
            method: "post",
            responseType: "json",
            data: {
                id_uczen : id_uczen,
                id_ocena : id_ocena,
                forma : forma,
                waga : waga,
                ocena : ocena,
            },
            success: function (response) { console.log(response);sukces() },
            error: function () { alert("Cos nie tak"); }
        });

}
function zaktualizujOceny(idZajecia) {
    var id_uczen = document.getElementById("uczniowie");
    id_uczen = id_uczen.options[id_uczen.selectedIndex].value;
    var forma = document.getElementById("forma").value;
    var waga = document.getElementById("waga").value;
    var ocena = document.getElementById("oceny");
    ocena = ocena.options[ocena.selectedIndex].value;
    console.log(id_uczen+" "+forma+" "+waga+" "+ocena);
        $.ajax({
            url: "http://localhost/frame/set/ocena",
            method: "post",
            responseType: "json",
            data: {
                id_uczen : id_uczen,
                forma : forma,
                waga : waga,
                ocena : ocena,
                id_zajecia : idZajecia
            },
            success: function (response) { console.log(response);sukces() },
            error: function () { alert("Cos nie tak"); }
        });

}
//<a href='javascript:pokazZajecia("+'"'+item.nazwa+'",'+'"'+item.id_kurs+'"'+")'"+">"+item.nazwa+"</a></li>"
function sukces() {
    alert('Udalo sie dokonac zmian.');
}
function pokazDodawnieKursu() {

    document.getElementById("container-left").innerHTML = sessionStorage.getItem('Przedmioty');
    var html = "<h4>Dodawanie kursu: </h4><table><tr><td>Podaj daje rozpoczecia: </td><td><input type='date' id='data' value='2018-07-22'></td></tr>";
    html += "<tr><td>Podaj nazwe kursu: </td><td><input type='text'  id='nazwaKursu'></td></tr></table>";
    html += "<tr><td>Podaj ilosc zajec: </td><td><input type='number'  id='iloscZajec'></td></tr></table>";
    html += "</br><h4>Podaj dane uczniów: </h4>";
    html += "</br>Podaj ilosc uczniów: <input type='number' onchange='pokazTabele()' value='0' id='ilosc'></input></br></br>";
    html += "<div id='uczniowie'></div>";
    html += "</br></br><input type='button' onclick='wyslijKurs()' value='Dodaj'>";
    document.getElementById("container-right").innerHTML = html;
}
function pokazTabele() {
    var ilosc = document.getElementById("ilosc").value;
    var html;
    html = "<table>"
    for (var i = 0; i < ilosc; i++) {
        html += "<tr><td>Imie:</td><td> <input type='text' name='imiona' id='imie" + i + "'></input></td><td>Nazwisko:</td><td> <input type='text' name='nazwiska' id='nazwisko" + i + "'></input></td></tr>"
    }
    html += "</table>";
    document.getElementById("uczniowie").innerHTML = html;
}
function wyslijKurs() {
    $.ajax({
        url: "http://localhost/frame/set/kurs",
        method: "post",
        responseType: "json",
        data: {
            kurs: document.getElementById("nazwaKursu").value,
            idPrzedmiot: sessionStorage.getItem("idPrzedmiot"),
            dataKursu: document.getElementById("data").value,
            iloscZajec: document.getElementById("iloscZajec").value
        },
        success: function (response) { dodajUczniow(JSON.parse(response));sukces(); },
        error: function () { alert("Cos nie tak"); }
    });
}
function dodajUczniow(idKurs) {
    var imiona = document.getElementsByName('imiona');
    var nazwiska = document.getElementsByName('nazwiska');
    idKurs = idKurs[0];
    idKurs = idKurs.id;
    for (var i = 0; i < imiona.length; i++) {
        if (imiona[i] != 0 && nazwiska[i] != 0) {
            $.ajax({
                url: "http://localhost/frame/set/uczen",
                method: "post",
                responseType: "json",
                data: {
                    id: idKurs,
                    imie: imiona[i].value,
                    nazwisko: nazwiska[i].value
                },
                success: function (response) { console.log(response);if(i==0)sukces()},
                error: function () { console.log("Cos nie tak"); }
            });
        }
    }
}
function pokazUczniow(zajecie, uczniowie) {
    document.getElementById("container-left").innerHTML = sessionStorage.getItem('Przedmioty');
    var html = "<h4> Analiza Matematyczna</h4><div id='content'>";
    document.getElementById("container-right").innerHTML = "Witam " + zajecie + "!";
    console.log(uczniowie);
    for (var i = 0; i < uczniowie.length; i++) {
    }


}

function pobierzUczniow(zajecie, idKurs) {
    $.ajax({
        url: "http://localhost/frame/get/uczniowie",
        method: "post",
        responseType: "json",
        data: {
            id: idKurs
        },
        success: function (response) { pokazUczniow(zajecie, response) },
        error: function () { console.log("Cos nie tak"); }
    });
}

