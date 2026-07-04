<?php

require_once "../functions/database.php";
require_once "../functions/users.php";


if($_SERVER["REQUEST_METHOD"] === "POST"){

    if(isset($_POST['email']) && isset($_POST['password']) ){

        if(!empty($_POST['email']) && !empty($_POST['password'])){
             

    $email = $_POST["email"];
    $password = $_POST["password"];


       connexion($email, $password);
     
       
        }else{
            echo "Veuillez remplir tous les champs.";
        }
    }
    else{
       header("Location: /facture/"); 
    }

}
else{
    header("Location: /facture/");
}