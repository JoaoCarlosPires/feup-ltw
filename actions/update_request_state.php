<?php
    include_once("../database/adoption_request.php");

    $request_id = $_POST["request_id"];
    $new_state = $_POST["new_state"];

    updateRequestState($request_id, $new_state);
?>