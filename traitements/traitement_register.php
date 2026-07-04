<?php
session_start(); 
require_once "../functions/database.php";
require_once "../functions/users.php";



if($_SERVER["REQUEST_METHOD"] === "POST"){

    if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['fonction'])){

    if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['fonction'])){

        $firstName = htmlspecialchars($_POST['firstname']);
        $lastName = htmlspecialchars($_POST['lastname']);
        $email = htmlspecialchars($_POST['email']);
        $rule = htmlspecialchars($_POST['fonction']);
      


        register($firstName, $lastName, $email, $rule); 
     
        }
    }
    else{
       header("Location: /facturation/"); 
    }

}
else{
    header("Location: /facturation/");
}

?>