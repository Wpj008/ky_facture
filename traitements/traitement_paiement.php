<?php

session_start();

require_once "../functions/paiements.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" ) {


    if(isset($_POST['facture_id']) && isset($_POST['numero_facture']) && isset($_POST['montant_paiement']) && isset($_POST['mode_paiement_id']) && isset($_POST['commentaire_paiement']) && isset($_POST['ttc_facture'])){

        if(!empty($_POST['facture_id']) && !empty($_POST['numero_facture']) && !empty($_POST['montant_paiement']) && !empty($_POST['mode_paiement_id']) && !empty($_POST['ttc_facture'])){

            $facture_id = $_POST['facture_id'];
            $facture = htmlspecialchars($_POST['numero_facture']);


            $date = date("Y-m-d");

            $montant = htmlspecialchars($_POST['montant_paiement']);
            $ttc_facture = htmlspecialchars($_POST['ttc_facture']);

            $mode = $_POST['mode_paiement_id'];

            $reference = "PAY-" . date("Ymd-His");

            $commentaire = htmlspecialchars($_POST['commentaire_paiement']);

            if($montant > $ttc_facture) {
                echo "Le montant du paiement ne peut pas être supérieur au montant total de la facture.";
                exit;
            }


            InsertPaiement($facture_id, $facture, $date, $montant, $mode, $reference, $commentaire, $ttc_facture);

        }else{
            echo "Veuillez remplir tous les champs.";

        }
    }else{

        echo "Certains champs sont manquants.";
    }

          var_dump($facture_id, $facture, $date, $montant, $mode, $reference, $commentaire, $ttc_facture);
          

          error_log("Erreur lors de l'enregistrement du paiement : certains champs sont manquants ou vides.");


}

?>