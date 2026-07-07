<?php
require_once "../functions/database.php";
require_once "../functions/logs.php";


function InsertFacture($numero_facture, $customer_id, $date_creation, $date_echeance, $status, $total_ht, $total_tva, $total_ttc, $created_by, $service, $quantite, $prix, $tva, $montant_ht, $montant_ttc){

    try{

        $pdo = getPDO();

        $pdo->beginTransaction();

        $queryInsert = $pdo->prepare(" INSERT INTO factures ( numero_facture, customer_id, date_creation_facture,date_echeance_facture, status_facture_id, total_ht, total_tva, total_ttc, created_by) VALUES(:numero,:customer,:date_creation,:date_echeance,:status, :ht, :tva, :ttc, :created_by)");

        $queryInsert->bindParam(":numero", $numero_facture);
        $queryInsert->bindParam(":customer", $customer_id);
        $queryInsert->bindParam("d:ate_cretaion", $date_creation);
        $queryInsert->bindParam(":date_echeance",$date_echeance,);
        $queryInsert->bindParam(":status",$status,);
        $queryInsert->bindParam(":ht",$total_ht,);
        $queryInsert->bindParam(":tva",$total_tva,);
        $queryInsert->bindParam(":ttc",$total_ttc,);
        $queryInsert->bindParam(":created_by",$created_by);
       

        $queryInsert->execute();

        $facture_id = $pdo->lastInsertId();

        $queryLine = $pdo->prepare("INSERT INTO ligne_facture (facture_id,service_id,quantite_facture,prix_unitaire,tva,montant_ht,montant_ttc) VALUES( :facture,:service,:quantite,:prix,:tva,:ht,:ttc)");

        foreach($service as $i=>$srv){

            if($srv==""){
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

        InsertHistorique(
            $_SESSION['user_id'],
            "CREATE",
            $_SESSION['first_name']." ".$_SESSION['last_name'] ." a créé la facture n°$numero_facture pour le client Ref : « $customer_id » d'un montant global de ".number_format($montant_ttc,2,","," ")." €."
        );

       header("Location: ../pages/facture.php");
      
        exit();

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

function getAllFacturesDashboard(){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM factures INNER JOIN customers ON factures.customer_id = customers.id_customer INNER JOIN status_facture ON factures.status_facture_id = status_facture.id_status_facture  ORDER BY id_facture DESC  LIMIT 5");
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



function updateFacture($id_facture, $id_ligne, $customer_id,$date_echeance,$status,$total_ht,$total_tva,$total_ttc, $quantite, $montant_ht, $montant_ttc, $numero_facture){

    try{

        $pdo = getPDO();

        $pdo->beginTransaction();

        // Mise à jour de la facture
        $queryFacture = $pdo->prepare("UPDATE factures SET customer_id = :customer, date_echeance_facture = :date_echeance, status_facture_id = :status, total_ht = :ht, total_tva = :tva, total_ttc = :ttc, updated_at_facture = NOW() WHERE id_facture = :id");



        $queryFacture->bindParam(":id", $id_facture);
        $queryFacture->bindParam(":customer", $customer_id);
        $queryFacture->bindParam(":date_echeance",$date_echeance,);
        $queryFacture->bindParam(":status",$status,);
        $queryFacture->bindParam(":ht",$total_ht,);
        $queryFacture->bindParam(":tva",$total_tva,);
        $queryFacture->bindParam(":ttc",$total_ttc,);
 


        $queryFacture->execute();

        // Mise à jour des lignes
        $queryLine = $pdo->prepare(" UPDATE ligne_facture SET quantite_facture = :quantite, montant_ht = :ht, montant_ttc = :ttc, updated_at_ligneFacture = NOW() WHERE id_ligne_facture = :id_ligne");

        foreach($id_ligne as $i => $ligne){

            $queryLine->execute([

                
                "quantite" => $quantite[$i],
                "ht"       => $montant_ht[$i],
                "ttc"      => $montant_ttc[$i],
                "id_ligne" => $ligne

            ]);

        }

        $pdo->commit();

        InsertHistorique(
            $_SESSION['user_id'],
            "UPDATE",
            $_SESSION['first_name']." ".$_SESSION['last_name'] ." a modifié la facture n° $numero_facture."
        );

       header("Location: ../pages/facture.php");
        exit;

    }

    catch(PDOException $e){

        $pdo->rollBack();

        die($e->getMessage());

    }

}


function deleteFacture($id_facture){


    try{

        $queryDelete = getPDO()->prepare("DELETE FROM factures WHERE id_facture = :id");

        $queryDelete->bindParam(":id", $id_facture);

        
        InsertHistorique(
            $_SESSION['user_id'],
            "DELETE_FACTURE",
            $_SESSION['first_name']." ".$_SESSION['last_name'] ." a supprimé la facture Ref : $id_facture."
        );

        $queryDelete->execute();

        header("Location: ../pages/facture.php");
        exit();


     }catch(PDOException $e){
        echo "Erreur lors de la suppression de la facture : " . $e->getMessage();
    }



}



?>