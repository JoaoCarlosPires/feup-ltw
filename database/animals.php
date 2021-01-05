<?php
    include_once("../database/connection.php");
    include_once("../database/queries.php");

    function getAnimalsByPersonID($id)
    {
        return makeSimpleQuery("SELECT distinct Animal.id as id, Animal.nome as nome,Animal.especie as especie,Animal.raca as raca, Animal.cor as cor from Adocao,Pessoa,Animal WHERE Adocao.pessoa = $id and Adocao.animal = Animal.id", true);
    }
?>

