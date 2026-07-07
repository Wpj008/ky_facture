<?php
require_once "../functions/logs.php";

function logOut(){
    InsertHistorique(
        $_SESSION['user_id'],
        "LOGOUT",
        $_SESSION['first_name']." ".$_SESSION['last_name']." s'est déconnecté de l'application."
    );
session_destroy();
header("Location: ../index.php");
}



?>