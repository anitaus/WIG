
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
    document.getElementById("container-right").innerHTML = html;
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
        success: function (response) { pobierzObecnosci(response, idZajecia) },
        error: function () { console.log("Cos nie tak"); }
    });
}
function pobierzObecnosci(idUczniowie, idZajecia) {
    document.getElementById("container-left").innerHTML = sessionStorage.getItem('Przedmioty');
    console.log('pobieram obecnosci: ' + idUczniowie);
    var html = "<h4>Obecnosci i oceny:</h4>"
    html += "<input type='button' value='Zaktualizuj' onclick='javascript:zaktualizujObecnosci()'<ul>"
    idUczniowie = JSON.parse(idUczniowie);
    idUczniowie.forEach(element => {
        $.ajax({
            url: "http://localhost/frame/get/obecnosc",
            method: "post",
            responseType: "json",
            data: {
                idUczen: element.id_uczen,
                idZajec: idZajecia
            },
            success: function (response) {
                element = JSON.parse(response);
                element = element[0];
                html += "<li>" + element.imie + " " + element.nazwisko;
                console.log(element.obecnosc);
                if (element.obecnosc == "nie") html += "<input type='checkbox' id='" + element.id_obecnosc + "' name='obecnosci'></li>";
                else html += "<input type='checkbox' id='" + element.id_obecnosc + "' name='obecnosci' checked></li>";
                document.getElementById("container-right").innerHTML = html;
            },
            error: function () { console.log("Cos nie tak"); }
        });
    });
}
function zaktualizujObecnosci() {
    checkboxy = document.getElementsByName('obecnosci');
    var i=0;
    checkboxy.forEach(element => {
        console.log(element);
        a = element.id;
        b = element.checked;
        $.ajax({
            url: "http://localhost/frame/set/obecnosc",
            method: "post",
            responseType: "json",
            data: {
                id_obecnosc: a,
                obecnosc: b
            },
            success: function (response) { console.log(response);if(i==0){sukces();i=1;} },
            error: function () { alert("Cos nie tak"); }
        });

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
    html = "<table>";
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
        success: function (response) { dodajUczniow(JSON.parse(response));sukces();  },
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
                success: function (response) { console.log(response); if(i==0)sukces() },
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

