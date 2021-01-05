<?php
    include_once('../database/user.php');

    include_once('../includes/session.php');

    if ($_SESSION['csrf'] !== $_POST['csrf'])
    {
        die('ERROR: Invalid Request');
        header('Location: ../pages/signup.php');
    }

    $usernameCS = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $bio = $_POST['bio'];
    $shelter = $_POST['shelter'];

    $username = strtolower($usernameCS);

    try
    {
        insertUser($username, $password, $name, $age, $bio, $location, $shelter);
        $_SESSION['username'] = $username;
        header('Location: ../pages/homepage.php');
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
        header('Location: ../pages/signup.php');
    }
?>