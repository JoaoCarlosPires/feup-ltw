<?php

    include_once("../database/connection.php");
    include_once("../database/people.php");

    $user_id = $_POST["user_id"];

    $image_name = $_FILES["image"]["name"];

    move_uploaded_file($_FILES['image']['tmp_name'], "../database/images/$image_name");

    updateUserInfo(["imagem" => $image_name],$user_id);

?>
