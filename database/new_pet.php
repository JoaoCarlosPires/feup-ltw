<?php

    include_once("../database/connection.php");
    include_once("../database/people.php");
    include_once("../database/queries.php");

function addPet($new_pet) {
        global $db;

        $image = $new_pet["imagem"];
        $name = $new_pet["name"];
        $breed = $new_pet["breed"];
        $specie = $new_pet["specie"];
        $color = $new_pet["color"];
        $description = $new_pet["description"];

        $user_id = -1;

        if (session_status() == PHP_SESSION_NONE) {
            session_start();  
        } 
        if (isset($_SESSION["username"])) $user_id = getPersonByUsername($_SESSION["username"])["id"];
        else{
            header("Location: ../pages/login.php");
            return;
        } 
        
        try {
            $stmt = $db->prepare('INSERT INTO Animal (nome, especie, raca, cor, descricao, imagem, estado) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute(array($name, $specie, $breed, $color, $description, $image, 'em_espera'));
            $last_insert_id = $db->lastInsertId("id");
            $stmt2 = $db->prepare('INSERT INTO Adocao (pessoa, animal) VALUES (?, ?)');
            $stmt2->execute(array($user_id, $last_insert_id));
            header("Location: ../pages/petlist.php");
        }
        catch (PDOException $e) {
            echo 'Database Error '.$e->getMessage().' in '.$e->getFile().
            ': '.$e->getLine();
            header("Location: ../pages/petlist.php");  
        }

    }
?>