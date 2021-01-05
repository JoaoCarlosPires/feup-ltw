<?php
    include_once("../database/connection.php");
    include_once("../database/people.php");
    include_once("../database/animals.php");
    include_once("../database/pets.php");
    include_once("../common/ui_elements.php");
    include_once("../database/adoption_request.php");
    include_once("../database/questions.php");

    $person_id = $_GET["person_id"];

    $person_data = getPersonByID($person_id);

    $person_animals = getAnimalsByPersonID($person_id);

    if (session_status() == PHP_SESSION_NONE) {
        session_start();  
    } 
    if ($_SESSION['username'] != $person_data["username"]){
        header("Location: homepage.php");
    } else {
        draw_header();
        draw_content($person_id, $person_data, $person_animals);
        draw_logout();
        ?>
        </body>
        </html>
        <?php
    }

    function draw_favourites($person_data)
    {
        $favourites = $person_data['favoritos'];
        if ($favourites !== "")
        {
            $favouritesArray = explode(',', $favourites);
            foreach($favouritesArray as $favouriteID)
            {
                $link = "petinfo.php?id=" . $favouriteID;
                $pet = getPet($favouriteID);
                if ($pet)
                {
                    $petName = $pet['nome'];
                    ?>
                        <link href="../css/profile.css" rel="stylesheet">

                        <div id="favourites"><a href=<?=$link?>><?=$petName?></a><div>

                    <?php
                }
                
            }
        }
    }
    
    function draw_requests($person_id)
    {
        $requests = getRequestsByPerson($person_id);

        foreach($requests as $request)
        {
            $petID = $request['animal'];
            $link = "petinfo.php?id=" . $petID;
            $pet = getPet($petID);
            $petName = $pet['nome'];
        ?>
            <link href="../css/profile.css" rel="stylesheet">


            <div id="requests"><a href=<?=$link?>><?=$petName?></a></div>
        <?php
        }
    }

    function draw_animal($animal, $questions, $proposals)
    {
        $link = "petinfo.php?id=" . $animal["id"];
        $petName = $animal["nome"];

    ?>

<link href="../css/profile.css" rel="stylesheet">
        
        <li>
            <h3><a href=<?=$link?>><?=$petName?></a></h3>
    <?php
        if ($questions !== [])
        {
            echo "<div>";
            echo "<h4>Questions: </h4>";
            foreach($questions as $question)
            {   
                if ($question["resposta"] === "")
                {
                ?>
                <h5>Q: <?=$question["texto"]?></h5>
                <form method="post" action="../actions/reply_question.php">
                    <textarea name="answer" cols="10" rows="5" name="answer"></textarea>
                    <input type="hidden" name="question_id" value="<?=$question["id"]?>">
                    <input type="submit" value="Reply">
                </form>
                <?php    
                }
            }
            echo "</div>";
        }
        if ($proposals !== [])
        {
            echo "<div>";
            echo "<h4>Proposals: </h4>";
            foreach($proposals as $proposal)
            {
                $interested_name = getPersonByID($proposal["pessoa_interessada"])["nome"];
                ?>
                <div class="proposalForm" data-id="<?=$proposal["id"]?>">
                <h5><?=$interested_name?></h5>
                <?php
                $state = $proposal["estado"];
                if ($state === "em_espera")
                {
                ?>
                    <form id="accept" class="acceptProposalForm">
                        <input type="submit" value="Accept">
                    </form>
                    <form id="reject" class="rejectProposalForm">
                        <input type="submit" value="Reject">
                    </form>
                <?php  
                }
                else
                {
                    if ($state === "aceite") $english_state = "Accepted";
                    else $english_state = "Rejected";
                    $display_message = "Proposal " . $english_state;
                ?>
                    <h5><?=$display_message?></h5>
                <?php
                }
                ?>

                </div>
                <?php
            }
            echo "</div>";
        }

    }


    function draw_content($person_id, $person_data, $person_animals) {
    ?>
    
        <script src="../scripts/profile.js" defer></script>
        <link href="../css/profile.css" rel="stylesheet">

        <h1><?=$person_data["nome"]?></h1>
        <div><img id="profilePic" src="../database/images/<?=$person_data["imagem"]?>" alt="Uma imagem de <?=$person_data["nome"]?>"></div>
  
<div> 
    <span>
        <h3>Personal info</h3>
        <p>Location: <?=$person_data["localizacao"]?></p>
        <p>Biography: <?=$person_data["biografia"]?></p>
        <p>Age: <?=$person_data["idade"]?></p>
    </span>
    <span>
        <h3>Favourite Pets</h3>
        <?php
            draw_favourites($person_data);
        ?>
    </span>
    <span>
        <h3>Previous Proposals</h3>
        <?php
            draw_requests($person_data['id']);
        ?>
    </span>
        <ul>   
        <h3>My Animals</h3>
            <?php
                foreach($person_animals as $animal)
                {
                    $proposals = getRequestsForAnimal($animal["id"]);
                    $questions = getQuestionsForAnimal($animal["id"]);
                    draw_animal($animal, $questions, $proposals);
                    ?>
                    <form class="postRemoval">
                        <input id="removepost" type="submit" value="Remove post">
                        <input type="hidden" name="animal_id" value="<?=$animal["id"]?>">
                        <input type="hidden" name="user_id" value="<?=$person_id?>">
                    </form>
                    </li>
                    <?php
                }
            ?>
        </ul>
</div>

<div>
    <div id="NewPic">
        <h3>Update Profile Picture<h3>
        <form id="imageForm" action="../actions/update_user_image.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image">
            <div></div>
            <input type="hidden" name="user_id" value="<?=$person_id?>">
            <input type="submit" value="Update profile picture">
        </form>
    </div>
    <div id="UpdateCredentials">
        <h3>Update credentials</h3>
        <!--form action="../actions/update_user_credentials.php" method="post"-->
        <form id="credentialsForm">
            <div><label>Username: <input type="text" name="new_username"></label></div>
            <div><label>Password: <input type="password" name="new_password"></label></div>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
            <input type="hidden" name="user_id" value="<?=$person_id?>">
            <input type="submit" value="Update credentials">
        </form>
    </div>  
</div>

    <?php
    } 
    
    function draw_logout() {
        ?>
                    <link href="../css/profile.css" rel="stylesheet">

<div>
            <a id="logout" href="../actions/action_logout.php">
                <button class="btn">Logout</button>
            </a>
    </div>
        <?php
    }
    ?>
