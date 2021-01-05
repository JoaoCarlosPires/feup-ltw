"use strict";

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

function handleSearch(event) {
    event.preventDefault();

    let breed, specie, color, local, name, shelter;

    name = forms[0].querySelector("div > div > div > input[name=name]").value;
    specie = forms[0][1].value;
    breed = forms[0][2].value;
    local = forms[0][3].value;
    color = forms[0][4].value;
    shelter = forms[0][5].value;


    let request = new XMLHttpRequest();
    request.open("post", "../actions/get_search.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({n: name, s: specie, b: breed, l: local, c: color, shelter: shelter}));

    window.location.replace(`../pages/petlist.php?&specie=${specie}&local=${local}&color=${color}&name=${name}&breed=${breed}&shelter=${shelter}`);
}

let forms = document.querySelectorAll("form");
forms[0].addEventListener("submit", handleSearch);