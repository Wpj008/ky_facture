<?php
require_once "../functions/database.php";
require_once "../functions/logs.php";


function InsertCustomer($type, $lastname, $firstname, $entreprise, $adresse, $ville, $code_postal, $phone, $email){

    try{

    $queryInsert = getPDO()->prepare("INSERT INTO customers(type_customer, lastname_customer, firstname_customer, entreprise, adresse_customer, ville_customer, code_postal, phone_customer, email_customer, created_at_customer, updated_at_customer) VALUES(:type, :lastname, :firstname, :entreprise, :adresse, :ville, :code_postal, :phone, :email, NOW(), NOW())");
    $queryInsert->bindParam(":type", $type);
    $queryInsert->bindParam(":lastname", $lastname);
    $queryInsert->bindParam(":firstname", $firstname);
    $queryInsert->bindParam(":entreprise", $entreprise);
    $queryInsert->bindParam(":adresse", $adresse);
    $queryInsert->bindParam(":ville", $ville);
    $queryInsert->bindParam(":code_postal", $code_postal);
    $queryInsert->bindParam(":phone", $phone);
    $queryInsert->bindParam(":email", $email);

    $result = $queryInsert->execute();

    InsertHistorique(
    $_SESSION['user_id'],
    "CREATE",
    $_SESSION['first_name']." ".$_SESSION['last_name'] ." a créé le client «". $firstname ." ". $lastname ."»."
    );

    header("Location: /facturation/pages/dashboard.php");
    exit();


    }catch(PDOException $e){
        echo "Erreur lors de l'insertion du client : " . $e->getMessage();
    }





}


function getAllCustomers(){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM customers");
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération des clients : " . $e->getMessage();
    }
}

function getCustomerById($customerId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM customers WHERE id_customer = :customerId");
        $querySelect->bindParam(":customerId", $customerId);
        $querySelect->execute();
        $result = $querySelect->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération du client : " . $e->getMessage();
    }
}   


?>