<?php
    include_once("../database/connection.php");
    include_once("../database/people.php");

    $user_id = $_POST["user_id"];

    if ($_SESSION['csrf'] !== $_POST['csrf'])
    {
        die('ERROR: Invalid Request');
        header('Location: ../pages/profile.php?person_id=' . $user_id);
    }

    $new_username = strtolower($_POST["new_username"]);
    $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT, ['cost' => 12]);
    
    updateUserInfo(["username" => $new_username, "password" => $new_password],$user_id);

?>