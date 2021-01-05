

<?php

include_once('../database/pets.php');
include_once('../database/people.php');

    function draw_footer() {
    ?>
        <link href="../css/footer.css" rel="stylesheet">  
        <footer>
            <div>LTW 2020 - G40</div>
        </footer>
        </body>
        </html>
    <?php
    }

    function draw_header() { ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Adopt a pet!</title>
    </head>
    <body>
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Muli" />

    <header>
    <a href="homepage.php">
    <img id="logo" src="../images/logotipo.png" alt="logo_button" width="160" height="auto">
    </a>

    <?php
        $profile_link = "login.php";
        $photo = "../images/profile.png";
        if (session_status() == PHP_SESSION_NONE) {
            session_start();  
        } 

        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $user_id = getPersonID($username)['id'];
            $profile_link = "profile.php?person_id=$user_id";
            $photo = "../images/profile_check.png";
        }

    ?>
    <div class="profile">
      <a href="<?=$profile_link?>" class="botao_perfil">
      <img id="profile" src="<?=$photo?>" alt="profile_button" width="80" height="auto">
      </a>
    </div>

  </header>

  <div class="meio">
    <h1>Find the animal you're looking for!</h1>
  </div>

    <div class="button_cont" align="center">
        <a href="addpet.php" class="button_add">Add new animal</a>
    </div>

    <?php
    }

    function draw_searchBar() {
    ?>
    <link href="../css/search.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="../scripts/search.js" defer></script>
    <form>
   
    <div class="rectangle">
        <div class="wrap">
            <div class="search">
                <input type="text" name="name" class="searchTerm" placeholder="What's the name of the pet?">
            </div>
        </div>
    </div>

    <div class="barra">
        <ul class="menu-bar">
            <li> 
                    Specie
                    <?php 
                    
                        echo '<select name="specie">';
                        echo '<option value="">All</option>';
                        
                        $species = getAllSpecies();
                    
                        foreach ($species as $specie) {
                        echo '<option value="' .$specie['especie']. '">' .$specie['especie']. '</option>';
                        }

                        echo '</select>';  
?>   
                    </li>
                    <li>
                        Breed
                        <?php
                            echo '<select name="breed">';
                            echo '<option value="">All</option>';
                            $breeds = getAllBreeds();
                        
                            foreach ($breeds as $breed) {
                            echo '<option value="' .$breed['raca']. '">' .$breed['raca']. '</option>';
                            }

                            echo '</select>'; 
                            
                        ?>
                    </li>
                    <li>Local
                        <?php
                            echo '<select name="local">';
                            echo '<option value="">All</option>';
                            $locals = getAllLocals();
                        
                            foreach ($locals as $local) {
                            echo '<option value="' .$local['localizacao']. '">' .$local['localizacao']. '</option>';
                            }

                            echo '</select>'; 
                            
                        ?>
                    </li>
                    <li>Color
                        <?php
                            echo '<select name="color">';
                            echo '<option value="">All</option>';
                            $colors = getAllColors();
                        
                            foreach ($colors as $color) {
                            echo '<option value="' .$color['cor']. '">' .$color['cor']. '</option>';
                            }

                            echo '</select>'; 
                            
                        ?>
                    </li>
                    <li>
                        Shelter
                        <?php
                            echo '<select name="shelter">';
                            echo '<option value="">All</option>';
                            $shelters = getAllShelters();
                        
                            foreach ($shelters as $shelter) {
                            echo '<option value="' .$shelter['abrigo']. '">' .$shelter['abrigo']. '</option>';
                            }

                            echo '</select>'; 
                            
                        ?>
                    </li>
                    <li><input id="search_button" type="submit" value="SEARCH"></li>
                </ul>
            </div>
            </form>

    <?php
    }
?>
