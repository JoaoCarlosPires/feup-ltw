<?php

    include_once('../database/pets.php');
    include_once("../common/ui_elements.php");

    function draw_addpet() { ?>      
    
        <link href="../css/form.css" rel="stylesheet">

        <form id="addpetForm" action="../actions/add_pet.php" method="post" enctype="multipart/form-data">  
            <input type="text" name="name" placeholder="Insert Pet Name" required="required"/>
            <input type="text" name="specie" placeholder="Insert Specie" required="required"/>
            <input type="text" name="breed" placeholder="Insert Breed" required="required"/>
            <input type="text" name="color" placeholder="Insert Color" required="required"/>
            <textarea name="description" rows="4" cols="50" placeholder="Insert Description" required="required"></textarea>
            <label>
            Picture
            </label>
            <input type="file" name="image" required="required">
            <input type="submit" value="Add Pet">
        </form>
        </form>
          
    <?php
    }

    draw_header();
    draw_addpet();
   

?>
 </body>
 </html>