<?php

session_start();
session_unset();
session_destroy(); //avslutar sessionen

header("location: ../index.php"); //skickar användaren längst upp i index.php