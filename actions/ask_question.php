<?php

    include_once("../database/connection.php");
    include_once("../database/questions.php");

    $animal_id = $_POST["animal_id"];
    $question_text = $_POST["question"];

    $question_text = trim(strip_tags($question_text));

    $question_text = preg_replace ("/[^a-zA-Z\s]/", '', $question_text);

    addQuestion($animal_id, $question_text);

    header("Location: ../pages/petinfo.php?id=$animal_id");
?>