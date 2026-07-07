<?php
require_once "../functions/database.php";
require_once "../functions/logs.php";

function InsertPaiement($facture_id, $facture, $date, $montant, $mode, $reference, $commentaire, $ttc_facture){
    $pdo = getPDO();

    try {

        $queryInsert = $pdo->prepare("INSERT INTO paiements (facture_id, reference_facture, date_paiement, montant_paiement, mode_paiement_id, reference_paiement, commentaire_paiement, created_at_paiement, updated_at_paiement) VALUES (:facture_id, :facture, :date, :montant, :mode, :reference, :commentaire, NOW(), NOW())");
        $queryInsert->bindParam(":facture_id", $facture_id);
        $queryInsert->bindParam(":facture", $facture);
        $queryInsert->bindParam(":date", $date);
        $queryInsert->bindParam(":montant", $montant);
        $queryInsert->bindParam(":mode", $mode);
        $queryInsert->bindParam(":reference", $reference);
        $queryInsert->bindParam(":commentaire", $commentaire);

        $queryInsert->execute();

        InsertHistorique(
            $_SESSION['user_id'],
            "CREATE",
            $_SESSION['first_name']." ".$_SESSION['last_name'] ." a enregistré un paiement de ".number_format($montant,2,","," ")." € sur la facture n° $facture." 
        );

    
        if($ttc_facture > $montant){
            $queryUpdateFacture = $pdo->prepare("UPDATE factures SET status_facture_id = 2 WHERE id_facture = :facture");
            $queryUpdateFacture->bindParam(":facture", $facture_id);
            $queryUpdateFacture->execute();

        } else if ($ttc_facture == $montant){
            $queryUpdateFacture = $pdo->prepare("UPDATE factures SET status_facture_id = 4 WHERE id_facture = :facture");
            $queryUpdateFacture->bindParam(":facture", $facture_id);
            $queryUpdateFacture->execute();
        } 
            
        header("Location: ../pages/paiement.php");

    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion du paiement : " . $e->getMessage();

    }

}


function getAllPaiements(){
    $pdo = getPDO();
    $query = $pdo->prepare("SELECT * FROM paiements INNER JOIN factures ON paiements.facture_id = factures.id_facture INNER JOIN mode_paiement ON paiements.mode_paiement_id = mode_paiement.id_mode_paiement INNER JOIN customers ON factures.customer_id = customers.id_customer");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}



function getAllPaiementsDashboard(){
    $pdo = getPDO();
    $query = $pdo->prepare("SELECT * FROM paiements INNER JOIN factures ON paiements.facture_id = factures.id_facture INNER JOIN mode_paiement ON paiements.mode_paiement_id = mode_paiement.id_mode_paiement INNER JOIN customers ON factures.customer_id = customers.id_customer ORDER BY id_paiement DESC  LIMIT 5");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function getPaiementById($facture_id){
    $pdo = getPDO();
    $query = $pdo->prepare("SELECT * FROM paiements INNER JOIN factures ON paiements.facture_id = factures.id_facture WHERE paiements.facture_id = :factureId");
    $query->bindParam(":factureId", $facture_id);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}


function getAllModePaiements(){
    $pdo = getPDO();
    $query = $pdo->prepare("SELECT * FROM mode_paiement");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


?>