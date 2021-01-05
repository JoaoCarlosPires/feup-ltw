<?php
    include_once('../database/user.php');

    include_once('../includes/session.php');

    if (!isset($_SESSION['username']))
    {
        header('Location: ../pages/login.php');
    }
    else
    {        
        $petID = $_POST['petID'];

        addToFavourites($petID);

        echo "<script>
            alert('Added to favourites list!');
            window.location.replace('../pages/petinfo.php?id=" . $petID . "');
        </script>";
        
    }
?>