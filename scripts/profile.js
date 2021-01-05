"use strict";

function encodeForAjax(data) 
{
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

function sendAjaxRequest(onload, action, header, data)
{
    let request = new XMLHttpRequest();
    request.onload = onload;
    request.open("post",action,true);
    request.setRequestHeader(header[0], header[1]);
    request.send(encodeForAjax(data));
}

let credentialsForm = document.querySelector("form[id=credentialsForm]");
let postRemovalForms = document.querySelectorAll("form.postRemoval");
let proposals = document.querySelectorAll("div.proposalForm");

function clearCredentialsForm()
{
    let newUsernameField, newPasswordField;
    newUsernameField = credentialsForm.querySelector("div > label > input[name=new_username]");
    newUsernameField.value = "";
    
    
    newPasswordField = credentialsForm.querySelector("div > label > input[name=new_password]");
    newPasswordField.value = "";
}

function handleCredentialsUpdate(event)
{
    event.preventDefault();

    let newUsername, newPassword, userID;

    newUsername = credentialsForm.querySelector("div > label > input[name=new_username]").value;
    newPassword = credentialsForm.querySelector("div > label > input[name=new_password]").value;
    userID = credentialsForm.querySelector("input[name=user_id]").value;

    sendAjaxRequest(clearCredentialsForm, "../actions/update_user_credentials.php", ['Content-Type', 'application/x-www-form-urlencoded'],{user_id: userID, new_username: newUsername, new_password: newPassword});
}

function removePost(animal_id, form)
{
    let animalHiddenInput = form.querySelector(`input[name="animal_id"][value="${animal_id}"]`);
    animalHiddenInput.parentNode.parentNode.remove();
}

function removeProposalButtonsAndAddMessage(proposalID, newState, acceptForm, rejectForm)
{
    acceptForm.remove();
    rejectForm.remove();

    let messageContent = "Proposal " + (newState === "aceite" ? "Accepted" : "Rejected");

    let stateMessage = document.createElement("h5");
    stateMessage.innerHTML = messageContent;
    document.querySelector(`div[data-id="${proposalID}"]`).append(stateMessage);
}

credentialsForm.addEventListener("submit", handleCredentialsUpdate);

for (let form of postRemovalForms) {
    form.addEventListener("submit", function(event){
        event.preventDefault();
        let animal_id, user_id;

        animal_id = form.querySelector("input[name=animal_id]").value;
        user_id = form.querySelector("input[name=user_id]").value;

        sendAjaxRequest(removePost.call(null, animal_id, form),"../actions/remove_post.php",['Content-Type', 'application/x-www-form-urlencoded'],{animal_id: animal_id, user_id: user_id});
    });
}

for (let proposal of proposals) 
{
    let acceptProposalForm = proposal.querySelector("form.acceptProposalForm");
    let rejectProposalForm = proposal.querySelector("form.rejectProposalForm");
    if (acceptProposalForm === null || rejectProposalForm === null) continue;

    let proposalID = proposal.getAttribute("data-id");

    acceptProposalForm.addEventListener("submit", function (event) {
        event.preventDefault();
        sendAjaxRequest(removeProposalButtonsAndAddMessage.call(null,proposalID,"aceite",acceptProposalForm,rejectProposalForm),"../actions/update_request_state.php",['Content-Type', 'application/x-www-form-urlencoded'],{request_id: proposalID, new_state: "aceite"});
    });
    rejectProposalForm.addEventListener("submit", function (event) {
        event.preventDefault();
        sendAjaxRequest(removeProposalButtonsAndAddMessage.call(null,proposalID,"rejeitado",acceptProposalForm,rejectProposalForm),"../actions/update_request_state.php",['Content-Type', 'application/x-www-form-urlencoded'],{request_id: proposalID, new_state: "rejeitado"});
    });
}