<?php

include_once("../database/connection.php");
include_once("../database/queries.php");

    function getAllPets($breed, $specie, $color, $local, $name, $shelter) { 
        $query = "SELECT DISTINCT Animal.nome as nome, cor, Animal.id  as id, especie, Animal.imagem as imagem, raca FROM Animal, Adocao, Pessoa WHERE Animal.id = Adocao.animal and Adocao.pessoa = Pessoa.id";     

        if ($breed !== "") $query = $query . " and Animal.raca = '$breed'";
        if ($specie !== "") $query = $query . " and Animal.especie = '$specie'";
        if ($color !== "") $query = $query . " and Animal.cor = '$color'";
        if ($local !== "") $query = $query . " and Pessoa.localizacao = '$local'";
        if ($name !== "") $query = $query . " and Animal.nome LIKE '%".$name."%'";
        if ($shelter !== "") $query = $query . " and Pessoa.abrigo = '$shelter'";
        
        return makeSimpleQuery($query, true);
    }

    function getPet($petID) { 
        global $db;
        $stmt = $db->prepare("SELECT * FROM Animal WHERE id = ?");
        $stmt->execute(array($petID));
        $pet = $stmt->fetch();
        return $pet;
    }

    function getPetLoc($petID) { 
        global $db;
        $stmt = $db->prepare("SELECT Pessoa.localizacao FROM Adocao, Pessoa WHERE Pessoa.id = Adocao.pessoa and Adocao.animal = ? ");
        $stmt->execute(array($petID));
        $location = $stmt->fetch();
        return $location;
    }

    function getAllSpecies() {
        return makeSimpleQuery("SELECT DISTINCT especie FROM Animal", true);
    }

    function getAllBreeds() {
        return makeSimpleQuery("SELECT DISTINCT raca FROM Animal", true);
    }

    function getAllLocals() {
        return makeSimpleQuery("SELECT DISTINCT Pessoa.localizacao as localizacao FROM Adocao, Pessoa WHERE Pessoa.id = Adocao.pessoa", true);
    }

    function getAllColors() {   
        return makeSimpleQuery("SELECT DISTINCT cor FROM Animal", true);    
    }

    function getAllShelters() {
        return makeSimpleQuery("SELECT DISTINCT abrigo FROM Pessoa WHERE abrigo NOT LIKE ''", true);
    }

    function updatePetState(int $pet_id, string $new_state)
    {
        global $db;
        $stmt = $db->prepare("UPDATE Animal SET estado = '$new_state' WHERE id = $pet_id");
        $stmt->execute();
    }

    function getAdoptionByPetID(int $petID)
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM Adocao WHERE animal = ?");
        $stmt->execute(array($petID));

        $adoption = $stmt->fetch();

        return $adoption;
    }
    
    function getPetShelter(int $animal_id)
    {
        $query_result = makeSimpleQuery("SELECT abrigo from Animal, Adocao, Pessoa WHERE Animal.id = Adocao.animal and Adocao.Pessoa = Pessoa.id and Animal.id = $animal_id" ,false);
        if ($query_result['abrigo'] === "") return "None";
        else return $query_result['abrigo'];
    }
?>
