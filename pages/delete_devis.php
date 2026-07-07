<?php
 session_start();


 require_once "../functions/devis.php";
 require_once "../functions/paiements.php";

 require_once "../functions/users.php";

 checkLogin();

if($_GET['id'] != null && isset($_GET['id']) && !empty($_GET['id'])){

    $devis_id = $_GET['id'];


  
    }else{

        echo "Aucun Devis trouvé.";
    }

    $devis = getDevisById($devis_id);

    $lignes_devis = getLignesDevisByDevisId($devis_id);

    $paiement = getPaiementById($devis_id);

?>



<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Supprimer une devis</title>

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

                <h1>Supprimer une devis</h1>

                <p>Confirmez la suppression de cette devis.</p>

            </div>

            <a href="devis.php" class="btn-annuler">

                <i class="bi bi-arrow-left"></i>

                Retour

            </a>

        </div>


        <div class="card delete-card">

            <div class="delete-icon">

                <i class="bi bi-trash3-fill"></i>

            </div>


            <h2>Confirmation</h2>

            <p class="delete-text">

                Cette opération est définitive et ne pourra pas être annulée.

            </p>


            <div class="resume">

                <div class="resume-item">

                    <span>Numéro de devis</span>

                    <strong><?= $devis['numero_devis']; ?></strong>

                </div>

                <div class="resume-item">

                    <span>Client</span>

                    <strong><?= $devis['firstname_customer']; ?> <?= $devis['lastname_customer']; ?></strong>

                </div>

                <div class="resume-item">

                    <span>Montant TTC</span>

                    <strong><?= number_format($devis['total_ttc'],2,',',' '); ?> €</strong>

                </div>

                <div class="resume-item">

                    <span>Date d'échéance</span>

                    <strong><?= date("d/m/Y",  strtotime($devis['date_validite_devis'])); ?></strong>

                </div>

            </div>


            <div class="warning">

                <i class="bi bi-exclamation-triangle-fill"></i>

                <span>

                    La devis ainsi que toutes ses lignes seront supprimées définitivement.

                </span>

            </div>


            <form action="../traitements/traitement_devis.php" method="POST">

                <input type="hidden" name="id_devis" value="<?= $devis['id_devis']; ?>">

                <div class="actions">

                    <a href="devis.php" class="btn-annuler">

                        Annuler

                    </a>

                    <button name="delete_devis" type="submit" class="btn-delete"> <i class="bi bi-trash-fill"></i>

                            Supprimer définitivement

                    </button>

                </div>

            </form>

        </div>

    </main>
    <script src="../assets/js/app.js"></script>
</body>

</html>
