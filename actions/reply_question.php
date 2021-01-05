<?php

    include_once("../database/questions.php");

    $answer = $_POST["answer"];
    $question_id = $_POST["question_id"];

    $answer = trim(strip_tags($answer));

    $answer = preg_replace ("/[^a-zA-Z\s]/", '', $answer);

    addReply($question_id, $answer);

?>