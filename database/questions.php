<?php

    include_once("../database/connection.php");
    include_once("../database/queries.php");

    function addQuestion(int $animal_id, string $question_text)
    {
        global $db;

        $stmt = $db->prepare("INSERT INTO Questao (animal, texto, resposta) VALUES ($animal_id, '$question_text', '')");

        $stmt->execute();
    }

    function addReply(int $question_id, string $answer)
    {
        global $db;

        $stmt = $db->prepare("UPDATE Questao SET resposta = '$answer' WHERE id = $question_id");
        $stmt->execute();

        $question_data = makeSimpleQuery("SELECT * FROM Questao WHERE id = $question_id", false);
        $animal_id = $question_data["animal"];
        $adoption_data = makeSimpleQuery("SELECT * FROM Adocao WHERE animal = $animal_id", false);
        $person_id = $adoption_data["pessoa"];

        header("Location: ../pages/profile.php?person_id=$person_id");
    }

    function getQuestionsForAnimal(int $animal_id)
    {
        return makeSimpleQuery("SELECT * from Questao WHERE animal = $animal_id", true);
    }
?>