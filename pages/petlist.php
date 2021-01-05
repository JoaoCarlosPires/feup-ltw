<?php

    include_once('../database/pets.php');
    include_once("../common/ui_elements.php");

    draw_header();

    function draw_petlist() { ?>      
    
        <link href="../css/table.css" rel="stylesheet">
        
            <?php draw_searchBar(); ?>
            
            <table id="petlist" style="text-align: center; vertical-align: middle">
            
            <colgroup>
                <col span="6" style="width: 10%">
            </colgroup>
            
            <?php
            
                if (isset($_GET["breed"])) $breed = $_GET["breed"];
                else $breed = "";
                if (isset($_GET["specie"])) $specie = $_GET["specie"];
                else $specie = "";
                if (isset($_GET["color"])) $color = $_GET["color"];
                else $color = "";
                if (isset($_GET["local"])) $local = $_GET["local"];
                else $local = "";
                if (isset($_GET["name"])) $name = $_GET["name"];            
                else $name = "";
                if (isset($_GET["shelter"])) $shelter = $_GET["shelter"];
                else $shelter = "";

                $pets = getAllPets($breed, $specie, $color, $local, $name, $shelter);

                if ($pets != null) {    
                    ?> 
                    <tr><th scope="col"></th><th scope="col">Name</th><th scope="col">Specie</th><th scope="col">Breed</th><th scope="col">Color</th><th scope="col">Local</th><th scope="col">Shelter</th><th scope="col"></th></tr>
                    <?php
                    foreach ($pets as $pet) {
                        $location = getPetLoc($pet['id']);
                        $shelter = getPetShelter($pet['id']);

                        echo "<tr><td><img src='../database/images/" . $pet['imagem'] . "' width='300' height='200'>" .
                        "</td><td>" . $pet['nome'] . 
                        "</td><td>" . $pet['especie'] . 
                        "</td><td>" . $pet['raca'] . 
                        "</td><td>" . $pet['cor'] . 
                        "</td><td>" . $location['localizacao'] .
                        "</td><td>" . $shelter .
                        "</td><td><a href='petinfo.php?id=" . $pet['id'] . "'><button type='button'>+Info</button></a>" .
                        "</td></tr>";
                    } 
                    echo "</table>"; 
                } else {
                    echo "</table><h2>No results found...</h2>";
                }
            
                
              ?>  
    <?php
    }

    draw_petlist();
?>
 </body>
 </html>
