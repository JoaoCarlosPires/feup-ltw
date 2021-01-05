<?php

    $breed = $_POST["b"]; 
    $specie = $_POST["s"];
    $color = $_POST["c"];
    $local = $_POST["l"];
    $name = $_POST["n"];
    $shelter = $_POST["shelter"];

    $name = preg_replace ("/[^a-zA-Z\s]/", '', $name);

    $name = trim(strip_tags($name));

    header("Location: ../pages/petlist.php?&specie=<?=urlencode($specie)?>&local=<?=urlencode($local)?>&color=<?=urlencode($color)?>&name=<?=urlencode($name)?>&breed=<?=urlencode($breed)?>&shelter=<?=urlencode($shelter)?>");

?>