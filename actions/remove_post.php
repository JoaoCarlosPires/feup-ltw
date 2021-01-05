<?php

    include_once("../database/connection.php");

    $user_id = $_POST["user_id"];
    $animal_id = $_POST["animal_id"];

    try
    {
        $db->beginTransaction();

        $stmt = $db->prepare("DELETE FROM Pedido where info_adocao = (SELECT id from Adocao where pessoa=$user_id and animal=$animal_id)");
        $stmt2 = $db->prepare("DELETE FROM Animal where id = $animal_id");
        $stmt3 = $db->prepare("DELETE FROM Adocao where pessoa = $user_id and animal = $animal_id");
        $stmt4 = $db->prepare("DELETE FROM Questao where animal = $animal_id");

        $stmt->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();

        $db->commit();   
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }

    header("Location: ../pages/profile.php?person_id=$user_id");

?>