"use strict";

function encodeForAjax(data) 
{
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

function clearTextarea()
{
    document.querySelector("textarea").value = "";
}

let form = document.querySelector("form");
form.addEventListener("submit", function (event) {
    //event.preventDefault();
    let questionText, animalID;

    questionText = form.querySelector("textarea").value;
    animalID = form.querySelector("input[name=animal_id]").value;

    let request = new XMLHttpRequest();
    request.onload = clearTextarea;
    request.open("post", "../actions/ask_question.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({animal_id: animalID, question: questionText}));
});