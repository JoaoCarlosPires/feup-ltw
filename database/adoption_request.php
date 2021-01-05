<?php

    include_once("../database/connection.php");
    include_once("../database/queries.php");
    include_once("../database/pets.php");
    include_once("../database/people.php");

    function getRequestByID(int $pedido_id)
    {
        return makeSimpleQuery("SELECT * from Pedido where id = $pedido_id", false);
    }

    function getRequestsForAnimal(int $animal_id)
    {
        return makeSimpleQuery("SELECT Pedido.id as id, pessoa_interessada, estado from Adocao, Pedido where Pedido.info_adocao = Adocao.id AND Adocao.animal = $animal_id", true);
    }

    function getRequestForAnimalByPerson(int $animal_id,int $person_id)
    {
        return makeSimpleQuery("SELECT Pedido.id as id, pessoa_interessada, Pedido.estado as estado from Adocao, Pedido where pessoa_interessada = $person_id and info_adocao = Adocao.id and Adocao.animal = $animal_id",false);
    }

    function getRequestsByPerson(int $person_id)
    {
        return makeSimpleQuery("SELECT Pedido.id as id, pessoa_interessada, Pedido.estado as estado, Adocao.animal as animal from Adocao, Pedido where pessoa_interessada = $person_id and info_adocao = Adocao.id",true);
    }

    function updateRequestState(int $request_id, string $new_state)
    {
        global $db;

        $stmt = $db->prepare("UPDATE Pedido SET estado = '$new_state' WHERE id = $request_id");
        $stmt->execute();
    }

    function requestToAdopt(int $petID, string $username)
    {
        global $db;

        $adoption = getAdoptionByPetID($petID);

        $adoptionID = $adoption['id'];

        $person = getPersonByUsername($username);

        $personID = $person['id'];

        try
        {
            $db->beginTransaction();

            $stmt = $db->prepare("INSERT INTO Pedido (pessoa_interessada, info_adocao, estado) VALUES (?, ?, 'em_espera')");
            $stmt->execute(array($personID, $adoptionID));

            $db->commit();   
        }
        catch(PDOException $e){}
    }
?>