<?php
require_once "../functions/database.php";


function InsertFacture($numero_facture, $customer_id, $date_creation, $date_echeance, $status, $total_ht, $total_tva, $total_ttc, $created_by, $service, $quantite, $prix, $tva, $montant_ht, $montant_ttc){

    try{

        $pdo = getPDO();

        $pdo->beginTransaction();

        $queryInsert = $pdo->prepare(" INSERT INTO factures ( numero_facture, customer_id, date_creation_facture,date_echeance_facture, status_facture_id, total_ht, total_tva, total_ttc, created_by) VALUES(:numero,:customer,:date_creation,:date_echeance,:status, :ht, :tva, :ttc, :created_by)");

        $queryInsert->bindParam(":numero", $numero_facture);
        $queryInsert->bindParam(":customer", $customer_id);
        $queryInsert->bindParam("date_cretaion", $date_creation);
        $queryInsert->bindParam("date_echeance",$date_echeance,);
        $queryInsert->bindParam("status",$status,);
        $queryInsert->bindParam("ht",$total_ht,);
        $queryInsert->bindParam("tva",$total_tva,);
        $queryInsert->bindParam("ttc",$total_ttc,);
        $queryInsert->bindParam("created_by",$created_by);
       

        $queryInsert->execute();

        $facture_id = $pdo->lastInsertId();

        $queryLine = $pdo->prepare("INSERT INTO ligne_facture (facture_id,service_id,quantite_facture,prix_unitaire,tva,montant_ht,montant_ttc) VALUES( :facture,:service,:quantite,:prix,:tva,:ht,:ttc)");

        foreach($service as $i=>$srv){

            if(trim($srv)==""){
                continue;
            }

            $queryLine->execute([

                "facture"=>$facture_id,
                "service"=>$service[$i] == "" ? null : $service[$i],
                "quantite"=>$quantite[$i],
                "prix"=>$prix[$i],
                "tva"=>$tva[$i],
                "ht"=>$montant_ht[$i],
                "ttc"=>$montant_ttc[$i]

            ]);

        }

        $pdo->commit();

        header("Location: ../pages/facture.php");
        exit;

    }

    catch(PDOException $e){

        $pdo->rollBack();

        die($e->getMessage());

    }

}



function getAllFactures(){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM factures INNER JOIN customers ON factures.customer_id = customers.id_customer INNER JOIN status_facture ON factures.status_facture_id = status_facture.id_status_facture");
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération des factures : " . $e->getMessage();
    }
}


function getAllStatusFacture(){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM status_facture");
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération des statuts de facture : " . $e->getMessage();
    }
}


function getFactureById($factureId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM factures INNER JOIN customers ON factures.customer_id = customers.id_customer INNER JOIN status_facture ON factures.status_facture_id = status_facture.id_status_facture WHERE id_facture = :factureId");
        $querySelect->bindParam(":factureId", $factureId);
        $querySelect->execute();
        $result = $querySelect->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération de la facture : " . $e->getMessage();
    }
}

function getLignesFactureByFactureId($factureId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM ligne_facture INNER JOIN services ON ligne_facture.service_id = services.id_service WHERE facture_id = :factureId");
        $querySelect->bindParam(":factureId", $factureId);
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération des lignes de facture : " . $e->getMessage();
    }
}


function getFacturesByCustomer($customerId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM factures INNER JOIN customers ON factures.customer_id = customers.id_customer INNER JOIN status_facture ON factures.status_facture_id = status_facture.id_status_facture WHERE customer_id = :customerId");
        $querySelect->bindParam(":customerId", $customerId);
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération des factures du client : " . $e->getMessage();
    }
}



function getFacturesByUser($userId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM factures INNER JOIN users ON factures.created_by = users.id_user INNER JOIN status_facture ON factures.status_facture_id = status_facture.id_status_facture WHERE created_by = :userId");
        $querySelect->bindParam(":userId", $userId);
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération des factures du client : " . $e->getMessage();
    }
}



?>