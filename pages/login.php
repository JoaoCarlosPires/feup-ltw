<?php
    include_once('../common/ui_elements.php');
    include_once('../includes/session.php');

    if (isset($_SESSION['username']))
        die(header('Location: homepage.php'));

    function draw_login()
    {
    ?>

        <link href="../css/form.css" rel="stylesheet">

        <section id="login">
            <form method="post" action="../actions/action_login.php">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input type="text" name="username" placeholder="Insert Username" required="required">
                <input type="password" name="password" placeholder="Insert Password" required="required">
                <input type="submit" value="Login">
            </form>

            <div>
                <button id="signup"><a href="signup.php">Signup Instead</a></button>
            </div>
        </section>
    <?php
    }

    draw_header();
    draw_login();
    draw_footer();
?>