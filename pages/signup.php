<?php
    include_once('../common/ui_elements.php');
    include_once('../includes/session.php');

    if (isset($_SESSION['username']))
        die(header('Location: homepage.php'));

    function draw_signup()
    {
    ?>

        <link href="../css/form.css" rel="stylesheet">
        
        <section id="signup">
            <form method="post" action="../actions/action_signup.php">
                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                <input type="text" name="username" placeholder="Insert Username" required="required">
                <input type="password" name="password" placeholder="Insert Password" required="required">
                <input type="text" name="name" placeholder="Insert Full Name" required="required">
                <input type="number" name="age" value="18" min="18" max="100" required="required">
                <input type="text" name="location" placeholder="Insert Location" required="required">
                <input type="text" name="shelter" placeholder="If you're connected to a shelter insert its name here, otherwise leave empty">
                <textarea name="bio" cols="25" rows="3" placeholder="Insert your biography here!" required="required"></textarea>
                <input type="submit" value="Signup">
            </form>

            <footer>
                <a href="login.php">Login Instead</a>
            </footer>
        </section>
    <?php
    }

    draw_header();
    draw_signup();
    draw_footer();
?>