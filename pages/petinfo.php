<?php

    include_once('../database/pets.php');
    include_once("../common/ui_elements.php");
    include_once("../database/questions.php");

    function draw_petInfo($petID)
    {

        $pet = getPet($petID);
        $location = getPetLoc($petID);

        ?>
        <!--script src="../scripts/petinfo.js" defer></script-->
        <link rel="second stylesheet" href="../css/petinfo.css">
        <div>
            <h1 id="name"><?=$pet['nome']?></h1>
            <img src="../database/images/<?=$pet['imagem']?>" width="500" height="300">

    <table id="petinfo">
            
            <colgroup>
                <col span="5" style="width: 20%">
            </colgroup>
            
            <tr>
                <th scope="col">Specie</th>
                <th scope="col">Breed</th>
                <th scope="col">Colour</th>
                <th scope="col">Local</th>
                <th scope="col">Description</th>
            </tr><tr>

            <td><?=$pet['especie']?></td>

            <td><?=$pet['raca']?></td>

            <td><?=$pet['cor']?></td>

            <td><?=$location['localizacao']?></td>

            <td><?=$pet['descricao']?><td></tr>
    </table>

    <table align="center">         
        <colgroup>
            <col span="3">
        </colgroup>
        
        <tr>
            <th scope="col">
                <a href="petlist.php">
                    <button class='btn'>Back to PetList</button>
                </a>
            </th>
            <th scope="col">
                <form method="post" action="../actions/action_add_to_favourites.php">
                    <input type="hidden" name="petID" value="<?=$petID?>">
                    <button class='btn'>Add to Favourites</button>
                </form>
            </th>
            <th scope="col">
                <form method="post" action="../actions/action_request.php">
                    <input type="hidden" name="petID" value="<?=$petID?>">
                    <button class='btn'>Request to Adopt</button>
                </form>
            </th>
        </tr>
    </table>

    <h3>If there's something you want to ask about this animal write it below.</h3>
    <form method="post" action="../actions/ask_question.php">
        <textarea name="question" id="" cols="30" rows="10"></textarea>
        <input id="addquestion" type="submit" value="Add question">
        <input type="hidden" name="animal_id" value="<?=$petID?>">
    </form>

    <div id="qa">
    <?php
        $questions = getQuestionsForAnimal($petID);
        if ($questions !== [])
        {
            echo "<h3>Questions & Answers</h3>";
            foreach($questions as $question)
            {
                echo "<div id='singleqa'><h4>Q: " . $question["texto"] . "</h4>";
                $answer = $question["resposta"];
                if ($answer !== "") echo "<h4>A: " . $answer . "</h4>";
                echo "</div>";
            }
        }
    ?>
    </div>  
    </div>  

<?php
    }

    draw_header();
    $id = $_GET['id'];
    draw_petInfo($id);
    
    
?>
 </body>
 </html>