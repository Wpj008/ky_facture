<?php
session_start();
require_once "../functions/factures.php";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_invoice'])) {

    $customer_id = htmlspecialchars($_POST['customer_id']);
    $numero_facture = "FA-" . date("Ymd-His");
    $date_creation = date("Y-m-d");
    $date_echeance = htmlspecialchars($_POST['date_echeance_facture']);
    $status = htmlspecialchars($_POST['status_facture_id']);
    $total_ht = htmlspecialchars($_POST['total_ht']);
    $total_tva = htmlspecialchars($_POST['total_tva']);
    $total_ttc = htmlspecialchars($_POST['total_ttc']);
    $created_by = $_SESSION['user_id'];
    $service = $_POST['service_id'];
    $quantite = $_POST['quantite_facture'];
    $prix = $_POST['prix_unitaire'];
    $tva = $_POST['tva'];
    $montant_ht = $_POST['montant_ht'];
    $montant_ttc = $_POST['montant_ttc'];

    InsertFacture($numero_facture, $customer_id, $date_creation, $date_echeance, $status, $total_ht, $total_tva, $total_ttc, $created_by, $service, $quantite, $prix, $tva, $montant_ht, $montant_ttc);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updating_facture'])) {

    $id_facture = $_POST['id_facture'];
    $id_ligne = $_POST['id_ligne'];
    $customer_id = htmlspecialchars($_POST['customer_id']);
    $date_echeance = htmlspecialchars($_POST['date_echeance_facture']);
    $status = htmlspecialchars($_POST['status_facture_id']);
    $total_ht = htmlspecialchars($_POST['total_ht']);
    $total_tva = htmlspecialchars($_POST['total_tva']);
    $total_ttc = htmlspecialchars($_POST['total_ttc']);
    $quantite = $_POST['quantite'];
    $numero_facture = $_POST['numero_facture'];
    $montant_ht = $_POST['montant_ht'];
    $montant_ttc = $_POST['montant_ttc'];

    updateFacture($id_facture, $id_ligne, $customer_id, $date_echeance, $status, $total_ht, $total_tva, $total_ttc, $quantite, $montant_ht, $montant_ttc,$numero_facture);

} elseif($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_facture'])) {


        $id_facture = $_POST['id_facture'];

        deleteFacture($id_facture);


    }else {
         header("Location: ../pages/dashboard.php");
        exit;
}