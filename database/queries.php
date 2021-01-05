<?php

    function makeSimpleQuery(string $stmt_string, bool $all)
    {
        try
        {
            global $db;

            $stmt = $db->prepare($stmt_string);
            $stmt->execute();

            if ($all) return $stmt->fetchAll();
            else return $stmt->fetch();
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }


?>