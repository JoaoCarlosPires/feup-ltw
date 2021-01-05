<?php

    include_once("../database/connection.php");


    function getPersonByID($id)
    {
        return makeSimpleQuery("SELECT * from Pessoa WHERE id = $id", false);
    }

    function getPersonByUsername($username)
    {
        return makeSimpleQuery("SELECT * from Pessoa WHERE username = '$username'", false);
    }

    function getPersonID($username) {
        return makeSimpleQuery("SELECT id from Pessoa WHERE username = '$username'", false);
    }

    function updateUserInfo($new_info, $user_id)
    {
        global $db;

        $stmt_string = "";

        if ($new_info["username"] !== null && $new_info["password"] !== null)
        {
            $new_username = $new_info["username"];
            $new_password = $new_info["password"];

            $stmt_string = "UPDATE Pessoa SET username='$new_username', password='$new_password' WHERE id=$user_id";
        }
        else if ($new_info["imagem"] !== null)
        {
            $image_name = $new_info["imagem"];

            $stmt_string = "UPDATE Pessoa SET imagem='$image_name' WHERE id=$user_id";
        }

        try
        {
            $stmt = $db->prepare($stmt_string);
            $stmt->execute();
            header("Location: ../pages/profile.php?person_id=$user_id");
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
            header("Location: ../pages/profile.php?person_id=$user_id");
        }
    }
?>