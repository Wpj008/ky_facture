<?php

function logOut(){

session_destroy();
header("Location: ../index.php");
}



?>