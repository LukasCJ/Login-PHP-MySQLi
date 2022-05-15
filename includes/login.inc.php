<?php

if (isset($_POST["submit"])) { //efter submit-knappen tryckts i login.php
    $username = $_POST["uid"]; //funkar för både email och användarnamn
    $pwd = $_POST["pwd"];

    require_once 'dbh.inc.php'; //samma anledning som i signup.inc.php
    require_once 'functions.inc.php'; //samma

    if (emptyInputLogin($username, $pwd) !== false) { //kollar om något fält är tomt
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $username, $pwd); //loggar in användaren i ett konto med samma användarnamn (eller email om det är vad man skrivit in) och lösenord. om detta inte finns så blir man nekad förstås
}
else {
    header("location: ../login.php");
    exit();
}