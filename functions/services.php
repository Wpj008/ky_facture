<?php
require_once "../functions/database.php";
require_once "../functions/logs.php";


function InsertService($name, $description, $price, $unit){

    try{

        $queryInsert = getPDO()->prepare(" INSERT INTO services(name_service, description_service, tarif_unitaire, type_tarif, created_at_service, updated_at_service) VALUES(:name, :description, :price, :unit, NOW(), NOW())");
         
        $queryInsert->bindParam(":name", $name);
        $queryInsert->bindParam(":description", $description);
        $queryInsert->bindParam(":price", $price);
        $queryInsert->bindParam(":unit", $unit);
      
        $queryInsert->execute();

        
        InsertHistorique(
            $_SESSION['user_id'],
            "CREATE",
            $_SESSION['first_name']." ".$_SESSION['last_name'] ." a créé le service « $name »."
        );

        header("Location: ../pages/dashboard.php");

    }catch(PDOException $e){
        echo "Erreur lors de l'insertion du service : " . $e->getMessage();
    }

}




function getAllServices(){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM services");
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération des services : " . $e->getMessage();
    }
}

function getServiceById($serviceId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM services WHERE id_service = :serviceId");
        $querySelect->bindParam(":serviceId", $serviceId);
        $querySelect->execute();
        $result = $querySelect->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération du service : " . $e->getMessage();
    }
}


?>