<?php

//Lukas Johansson 2A
//Detta är huvudfilen för projektet skulle jag säga

function emptyInputSignup($name, $email, $username, $pwd, $pwdRe) {
    $result;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRe)) { //empty() kollar om fältet är tomt
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) { //preg_match() kollar så att de angivna tecken för användarnamnet är tillåtna, i detta fall stor eller liten bokstav i det engelska alfabetet eller siffror
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //filter_var() är, med hjälp av "FILTER_VALIDATE_EMAIL" en färdigställd metod för att kolla att emailen ser ut som en riktig email
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRe) {
    $result;
    if ($pwd !== $pwdRe) { //självförklarligt
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) { //främst för att kolla om användarnamnet och emailen är upptagen. hindrar även kod i inputfältena
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;"; //kollar igenom databasens users-table efter användarnamn och email
    $stmt = mysqli_stmt_init($conn); //initialiserar koppling, förbereder statement. tack vare detta så kan inte interaktionen med databasen påverkas av användare; det besökare skriver in i fältena inte skada hemsidan. förklaras 1:10:30 i videon
    if (!mysqli_stmt_prepare($stmt, $sql)) { //kollar efter misstag i sql-koden basically
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $username, $email); //bind parameters. här skickas informationen från användaren in i statementet. argument nummer 2 är typen av information som skickas: "ss" betyder två strings
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt); //sätter in resultatet i en variabel

    if ($row = mysqli_fetch_assoc($resultData)) { //det är här informationen faktiskt samlas ihop och görs till en associativ array. deklarerar variabel samtidigt ("$row =")
        return $row; //vad vi vill få för att logga in användaren: informationen finns i databasen
    }
    else {
        $result = false;
        return $result; //vad vi vill få för att signa up användaren: informationen finns inte i databasen
    }

    mysqli_stmt_close($stmt); //stänger statementet
}

function createUser($conn, $name, $email, $username, $pwd) { //skapa användare
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);"; //för att stoppa in angiven information i databasen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT); //hashar lösenord. denna funktion är inbyggd i php och metoden uppdateras automatiskt vid universellt behov
    
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function emptyInputLogin($username, $pwd) { //kollar om något fält är tomt
    $result;
    if (empty($username) || empty($pwd)) {
        $result = true;
    } 
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) { //loggar in användaren
    $uidExists = uidExists($conn, $username, $username); //variabeln username kan vara antingen email eller användarnamn eftersom vi skrev det på hemsidan, vilket är varför den inkluderas 2 ggr

    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"]; //hämtar det hashade lösenordet i databasen
    $checkPwd = password_verify($pwd, $pwdHashed); //verifierar det angivna lösenordet med det i databasen

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) { //logga in användaren
        session_start(); //startar session
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"]; //associerar session med den lagrade användaren
        header("location: ../index.php");
        exit();
    }
}
