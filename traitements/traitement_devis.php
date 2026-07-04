<?php

session_start();

require_once "../functions/devis.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" ) {


    $customer_id = htmlspecialchars($_POST['customer_id']);
    $numero_devis = "DV-" . date("Ymd-His");
    $date_creation = date("Y-m-d");
    $date_echeance = htmlspecialchars($_POST['date_echeance_devis']);
    $status = htmlspecialchars($_POST['status_devis_id']);

    $total_ht = htmlspecialchars($_POST['total_ht']);
    $total_tva = htmlspecialchars($_POST['total_tva']);
    $total_ttc = htmlspecialchars($_POST['total_ttc']);

    $created_by = $_SESSION['user_id'];
    $service = $_POST['service_id'];
    $quantite = $_POST['quantite_devis'];
    $prix = $_POST['prix_unitaire'];
    $tva = $_POST['tva'];
    $montant_ht = $_POST['montant_ht'];
    $montant_ttc = $_POST['montant_ttc'];

    InsertDevis($numero_devis,$customer_id,$date_creation,$date_echeance,$status,$total_ht,$total_tva,$total_ttc,$created_by,$service,$quantite,$prix,$tva,$montant_ht,$montant_ttc);

} else {

    header("Location: ../pages/devis.php");
    exit;

}

?>