<?php
    include_once("../database/connection.php");

    function checkPassword($username, $password)
    {
        global $db;

        $stmt = $db->prepare('SELECT * FROM Pessoa WHERE username = ?');
        $stmt->execute(array($username));

        $user = $stmt->fetch();

        return ($user !== false && password_verify($password, $user['password']));
    }

    function insertUser($username, $password, $name, $age, $bio, $location, $shelter)
    {
        global $db;

        $options = ['cost' => 12];
        $stmt = $db->prepare('INSERT INTO Pessoa (username, password, nome, idade, biografia, localizacao, imagem, abrigo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT, $options), $name, $age, $bio, $location,"default_profile_image.png",$shelter));
    }

    function addToFavourites($pet_id)
    {
        global $db;

        $stmt = $db->prepare('SELECT favoritos FROM Pessoa WHERE username = ?');
        $stmt->execute(array($_SESSION['username']));

        $fetch = $stmt->fetch();

        $favourites = $fetch['favoritos'];

        $favouritesArray = explode(',', $favourites);

        if (!array_search($pet_id , $favouritesArray) && $favouritesArray[0] !== $pet_id)
        {
            if ($favourites === null || $favourites === false || $favourites === [])
                $newFavourites = $pet_id;
            else
                $newFavourites = $favourites . ',' . $pet_id;

            try
            {
                $db->beginTransaction();

                $stmt = $db->prepare('UPDATE Pessoa SET favoritos = ? WHERE username = ?');
                $stmt->execute(array($newFavourites, $_SESSION['username']));

                $db->commit();   
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
    }
?>
