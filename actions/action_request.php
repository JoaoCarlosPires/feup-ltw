<?php
    include_once('../database/adoption_request.php');

    include_once('../includes/session.php');

    if (!isset($_SESSION['username']))
    {
        header('Location: ../pages/login.php');
    }
    else
    {
        $petID = $_POST['petID'];

        requestToAdopt($petID, $_SESSION['username']);

        echo "<script>
            alert('Request of adoption made!');
            window.location.replace('../pages/petinfo.php?id=" . $petID . "');
        </script>";
    }
?>