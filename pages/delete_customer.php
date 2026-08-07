<?php
session_start();

require_once "../functions/users.php";
require_once "../functions/customers.php";
require_once "../functions/factures.php";

checkLogin();

if($_GET['id'] != null && isset($_GET['id']) && !empty($_GET['id'])){

    $customer_id = $_GET['id'];


  
    }else{

        echo "Aucun utilisateur trouvée.";
    }

    $customer = getCustomerDeleteInfos($customer_id);
    $customers = getAllCustomers();
    $lignes_facture = getLignesFactureByFactureId($customer_id);
    $statuts = getAllStatusFacture();
?>



<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Supprimer un client</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="../assets/css/delete.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<style>

.sidebar-backdrop {
  position: fixed;
  inset: 0;
  z-index: 1200 !important;
  background: var(--color-overlay);
  opacity: 0;
  visibility: hidden;
  transition: opacity var(--duration-base) var(--ease-standard), visibility var(--duration-base);
}


.sidebar {
  position: fixed;
  top: 0; left: 0; bottom: 0;
  width: var(--sidebar-width);
  z-index:1300 !important;
  display: flex;
  flex-direction: column;
  padding: var(--space-6) var(--space-5);
  background: var(--color-primary);
  color: var(--color-on-primary);
  border-top-right-radius: var(--radius-xl);
  border-bottom-right-radius: var(--radius-xl);
  transition: transform var(--duration-slow) var(--ease-out);
}
</style>


    <?php require_once "../partials/sidebar.php"; ?>

 


    <main class="content">

        <div class="page-header">

            <div>

            <h1>Supprimer un client</h1>

            <p>Confirmez la suppression de ce client.</p>

            </div>

            <a href="facture.php" class="btn-annuler">

                <i class="bi bi-arrow-left"></i>

                Retour

            </a>

        </div>


        <div class="card delete-card">

            <div class="delete-icon">
                <i class="bi bi-trash3-fill"></i>
            </div>

            <h2>Supprimer ce client ?</h2>

            <p class="delete-text">
                Cette opération est définitive.
                Toutes les informations liées à ce client ne pourront plus être récupérées.
            </p>

            <div class="resume">

                <div class="resume-item">
                    <span>Nom</span>
                    <strong><?= $customer['firstname_customer']; ?> <?= $customer['lastname_customer']; ?></strong>
                </div>

                <div class="resume-item">
                    <span>Email</span>
                    <strong><?= $customer['email_customer']; ?></strong>
                </div>

                <div class="resume-item">
                    <span>Téléphone</span>
                    <strong><?= $customer['phone_customer']; ?></strong>
                </div>

                <div class="resume-item">
                    <span>Ville</span>
                    <strong><?= $customer['ville_customer']; ?></strong>
                </div>

                <div class="resume-item">
                    <span>Nombre de devis</span>
                    <strong><?= $customer['nb_devis']; ?></strong>
                </div>

                <div class="resume-item">
                    <span>Montant des devis</span>
                    <strong><?= number_format($customer['total_devis']); ?> €</strong>
                </div>

                <div class="resume-item">
                    <span>Nombre de factures</span>
                    <strong><?= $customer['nb_factures']; ?></strong>
                </div>

                <div class="resume-item">
                    <span>Total facturé</span>
                    <strong><?= number_format($customer['total_factures']); ?> €</strong>
                </div>

                <div class="resume-item">
                    <span>Paiements reçus</span>
                    <strong><?= $customer['nb_paiements']; ?></strong>
                </div>

                <div class="resume-item">
                    <span>Total encaissé</span>
                    <strong><?= number_format($customer['total_paiements']); ?> €</strong>
                </div>

                <div class="resume-item">
                    <span>Première facture</span>
                    <strong>
                        <?= $customer['premiere_facture'] ? date('d/m/Y',strtotime($customer['premiere_facture'])) : "Aucune"; ?>
                    </strong>
                </div>

                <div class="resume-item">
                    <span>Dernière facture</span>
                    <strong>
                        <?= $customer['derniere_facture'] ? date('d/m/Y',strtotime($customer['derniere_facture'])) : "Aucune"; ?>
                    </strong>
                </div>

            </div>

            <div class="warning">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <span>
                    La suppression de ce client peut également impacter ses devis,
                    ses factures, ses paiements ainsi que les historiques associés.
                    Vérifiez qu'aucune donnée importante ne doit être conservée.
                </span>

            </div>

            <form action="../traitements/traitement_customer.php" method="POST">

                <input type="hidden" name="id_customer" value="<?= $customer['id_customer']; ?>">

                <div class="actions">

                    <a href="customer.php" class="btn-annuler">
                        Annuler
                    </a>

                    <button type="submit" name="delete_customer" class="btn-delete">

                        <i class="bi bi-trash-fill"></i>

                        Supprimer définitivement

                    </button>

                </div>

            </form>

            </div>
    </main>
    <script src="../assets/js/app.js"></script>
</body>

</html>
