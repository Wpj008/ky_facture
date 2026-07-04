<?php
session_start(); 


require_once "../functions/database.php";
require_once "../functions/customers.php";



if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['create_customer'])){

   if(isset($_POST['type_customer']) && isset($_POST['firstname_customer']) && isset($_POST['lastname_customer']) && isset($_POST['email_customer']) && isset($_POST['phone_customer'])  && isset($_POST['entreprise']) && isset($_POST['adresse_customer']) && isset($_POST['ville_customer']) && isset($_POST['code_postal'])){

    if(!empty($_POST['type_customer'])  &&!empty($_POST['firstname_customer']) && !empty($_POST['lastname_customer']) && !empty($_POST['email_customer']) && !empty($_POST['phone_customer']) && !empty($_POST['entreprise']) && !empty($_POST['adresse_customer']) && !empty($_POST['ville_customer']) && !empty($_POST['code_postal'])){

        $type = htmlspecialchars($_POST['type_customer']);
        $firstName = htmlspecialchars($_POST['firstname_customer']);
        $lastName = htmlspecialchars($_POST['lastname_customer']);
        $email = htmlspecialchars($_POST['email_customer']);
        $phone = htmlspecialchars($_POST['phone_customer']);
      
        $entreprise = htmlspecialchars($_POST['entreprise']);
        $adresse = htmlspecialchars($_POST['adresse_customer']);
        $ville = htmlspecialchars($_POST['ville_customer']);
        $codePostal = htmlspecialchars($_POST['code_postal']);


        InsertCustomer($type, $lastName, $firstName, $entreprise, $adresse, $ville, $codePostal, $phone, $email);
     
        } else{
            echo "Veuillez remplir tous les champs.";
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