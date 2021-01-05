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

    $username = strtolower($usernameCS);

    if (checkPassword($username, $password))
    {
        $_SESSION['username'] = $username;
        $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
        header('Location: ../pages/homepage.php');
    }
    else
    {
        ?>
        <script>
            alert("Wrong password!");
            window.location.replace("../pages/login.php");
        </script>
        <?php
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Logged failed!');
    }
?>