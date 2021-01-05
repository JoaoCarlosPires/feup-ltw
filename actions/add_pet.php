<?php

    include_once("../database/connection.php");
    include_once("../database/new_pet.php");

    $name = $_POST["name"];
    $specie = $_POST["specie"];
    $breed = $_POST["breed"];
    $color = $_POST["color"];
    $description = $_POST["description"];

    $image = $_FILES["image"]["name"];

    move_uploaded_file($_FILES['image']['tmp_name'], "../database/images/$image");

    addPet(["imagem" => $image, "name" => $name, "breed" => $breed, "specie" => $specie, "color" => $color, "description" => $description]);

?>