<?php

include_once("../common/ui_elements.php");

    function draw_homepageContent() {
    ?>

<!-- Slideshow container -->
<div class="slidershow middle">

  <div class="slides">
    <input type="radio" name="r" id="r1" checked>
    <input type="radio" name="r" id="r2">
    <input type="radio" name="r" id="r3">


    <div class="slide s1">
      <img src="../images/1.jpg" alt="">
    </div>
    <div class="slide s2">
      <img src="../images/2.jpg" alt="">
    </div>
    <div class="slide s3">
      <img src="../images/3.jpg" alt="">
    </div>

    </div>
  </div>

  <div class="navigation">
    <label for="r1" class="bar"></label>
    <label for="r2" class="bar"></label>
    <label for="r3" class="bar"></label>
  </div>

  <?php draw_searchBar(); ?>

  <script>
    var time =3000;
    var iteration = 0;

    setInterval(function(){
      if(iteration==0){
        iteration=2;
      }
      if(iteration==1){
        document.getElementById("r1").checked = true;
        iteration++;
      }
      else if(iteration==2){
        document.getElementById("r2").checked = true;
        iteration++;
      }
      else if(iteration==3){
        document.getElementById("r3").checked = true;
        iteration=1;
      }
    },time)


    //document.getElementById("r2").checked = true;
  </script>


    <?php
    }

    draw_header();
    draw_homepageContent();
    draw_footer();
?>