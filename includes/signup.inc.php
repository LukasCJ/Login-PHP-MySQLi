<?php //php taggen bör inte stängas om ingen html-kod ska inkluderas

if (isset($_POST["submit"])) { //"submit" är typen av knapp vi använde i form-taggen i signup.php. vi tar alltså emot informationen här genom form-taggens post-metod för att behandla den. form-taggen vet att detta är rätt fil med hjälp av action-attributen
    
    $name = $_POST["name"]; //för in det användaren skrev under input-fältet med namnet "name"
    $email = $_POST["email"]; //samma för "email"
    $username = $_POST["uid"]; //osv...
    $pwd = $_POST["pwd"];
    $pwdRe = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php'; //variabler som deklareras i dbh.inc.php kommer behövas och därför anknyter vi denna såhär
    require_once 'functions.inc.php'; //hur alla funktioner vi använder fungerar skrivs i functions.inc.php. i signup.inc.php så matar vi bara in vår information

    if (emptyInputSignup($name, $email, $username, $pwd, $pwdRe) !== false) { //tar in informationen hos alla fältena för att ta reda på om något av dem är tomma
        header("location: ../signup.php?error=emptyinput"); //om något fält är tomt så förhindras signup
        exit(); //går ut ur if-satsen utanför denna, dvs if-satsen med argumentet "isset($_POST["submit"])"
    }
    if (invalidUid($username) !== false) { //kollar om användarnamnet är giltigt
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) { //kollar om emailen är giltig
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if (pwdMatch($pwd, $pwdRe) !== false) { //kollar om lösenorden matchar
        header("location: ../signup.php?error=differentpasswords");
        exit();
    }
    if (uidExists($conn, $username, $email) !== false) { //kollar om användarnamnet redan används
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $email, $username, $pwd); //om ingen av if-satserna ovan körts så når vi denna funktion. här skapas användaren

}
else {
    header("location: ../signup.php");
    exit();
}