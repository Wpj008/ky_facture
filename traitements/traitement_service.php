<?php

require_once "../functions/database.php";
require_once "../functions/services.php";


if($_SERVER["REQUEST_METHOD"] === "POST"){


    if(isset($_POST['intitule']) && isset($_POST['description']) && isset($_POST['tarif']) && isset($_POST['unite'])){

        if(!empty($_POST['intitule']) && !empty($_POST['description']) && !empty($_POST['tarif']) && !empty($_POST['unite'])){

            $name = htmlspecialchars($_POST['intitule']);
            $description = htmlspecialchars($_POST['description']);
            $price = floatval($_POST['tarif']);
            $unit = htmlspecialchars($_POST['unite']);

            InsertService($name, $description, $price, $unit);
         
        } else{
            echo "Veuillez remplir tous les champs.";
        }
    }

    else{
       header("Location: /facturation/"); 
    }




 
















}










?>