<?php include_once 'header.php'; ?>

<section>
    <div class="section_header"><h2>Sign Up</h2></div>
    <div class="section_main">
        <form action="includes/signup.inc.php" method="post"> <!--"method=post" låter oss använda det som skrivs i fältena-->
            <input type="text" name="name" placeholder="Full Name..."> <!--input taggar ger oss fält som användaren kan skriva in i, denna är för användarens namn-->
            <input type="text" name="email" placeholder="Email.."> <!--email-->
            <input type="text" name="uid" placeholder="Username.."> <!--användarnamn-->
            <input type="password" name="pwd" placeholder="Password.."> <!--lösenord-->
            <input type="password" name="pwdrepeat" placeholder="Repeat Password..."> <!--upprepa lösenord (för att se till att användaren inte skrev fel)-->
            <button type="submit" name="submit"><p>Sign Up</p></button> <!--knapp för att skicka in informationen-->
        </form>

        <?php
            if (isset($_GET["error"])) { //efter att vi kollat efter fel i uppskrivningen så ändras url:en genom en get metod
                if ($_GET["error"] == "emptyinput") { //baserat på dessa förändringar i url:en så får sidan förändringar i formen meddelanden som säger vad som gick fel
                    echo '<p>Fill in all fields</p>';
                }
                else if ($_GET["error"] == "invaliduid") {
                    echo '<p>Invalid username</p>';
                }
                else if ($_GET["error"] == "invalidemail") {
                    echo '<p>Invalid email</p>';
                }
                else if ($_GET["error"] == "differentpasswords") {
                    echo '<p>Passwords do not match</p>';
                }
                else if ($_GET["error"] == "stmtfailed") {
                    echo '<p>Something went wrong</p>';
                }
                else if ($_GET["error"] == "usernametaken") {
                    echo '<p>Username or email is already taken</p>';
                }
                else if ($_GET["error"] == "none") {
                    echo '<p>You have signed up</p>';
                }
            }
        ?>

    </div>
</section>

<?php include_once 'footer.php' ?>