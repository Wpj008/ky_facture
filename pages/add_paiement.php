<?php
session_start();

require_once "../functions/factures.php";
require_once "../functions/paiements.php";

require_once "../functions/users.php";

 checkLogin();

$mode_paiements = getAllModePaiements();

if(isset($_GET['facture_id'])) {
    $facture_id = $_GET['facture_id'];
   
} else {
   echo "Aucune facture sélectionnée.";
   exit;
}

$facture = getFactureById($facture_id);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un paiement</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">
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


<div class="app-shell">

    <?php require_once "../partials/sidebar.php"; ?>

    <div class="sidebar-backdrop"></div>

    <div class="main">

        <header class="navbar-app">

            <button class="icon-button sidebar-toggle">
                <i class="bi bi-list"></i>
            </button>

            <div class="navbar-app__search">
                <i class="bi bi-search"></i>
                <input type="search" placeholder="Rechercher...">
            </div>

            <div class="navbar-app__actions">
                <button class="icon-button">
                    <i class="bi bi-bell"></i>
                </button>

                <span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span>
            </div>

        </header>

        <main class="page">

            <div class="page-header">

                <div>
                    <h1>Nouveau paiement</h1>
                    <p>Enregistrer un paiement reçu.</p>
                </div>

                <a href="paiement.php" class="btn btn-outline-secondary">
                    Retour
                </a>

            </div>

            <form action="../traitements/traitement_paiement.php" method="POST">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <div class="row g-4">

                            <!-- Facture -->
                            <div class="col-md-6">
                                <label class="form-label">Ref-Facture</label>
                                <input class="form-control" name="numero_facture" readonly value="<?= $facture['numero_facture'] ?>"/>
                                <input type="hidden" name="facture_id" value="<?= $facture['id_facture'] ?>">
                            </div>

                            <!-- Date -->
                            <div class="col-md-6">
                                <label class="form-label">Date du paiement</label>
                                <input type="date" class="form-control" name="date_paiement" required value="<?= date('Y-m-d'); ?>">
                            </div>

                            <!-- Montant -->
                            <div class="col-md-6">
                                <label class="form-label">Montant</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="montant_paiement" placeholder="0.00" required>
                                    <input type="hidden" name="ttc_facture" value="<?= $facture['total_ttc'] ?>">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>

                            <!-- Mode -->
                            <div class="col-md-6">
                                <label class="form-label">Mode de paiement</label>
                                <select class="form-select" name="mode_paiement_id" required>

                                <option value="">Sélectionner</option>

                                <?php foreach($mode_paiements as $mode): ?>
                                    <option value="<?= $mode['id_mode_paiement'] ?>"><?= $mode['name_mode_paiement'] ?></option>
                                <?php endforeach; ?>
                                   
                                  
                                </select>
                            </div>

                            <!-- Référence -->
                            <div class="col-md-6">
                                <label class="form-label">Référence du paiement</label>
                                <input type="text" class="form-control" name="reference_paiement" readonly value="<?= 'PAY-' . date('Ymd-His'); ?>">
                            </div>

                            <!-- Commentaire -->
                            <div class="col-12">
                                <label class="form-label">Commentaire</label>
                                <textarea class="form-control" name="commentaire_paiement" rows="5" placeholder="Ajouter un commentaire..." required></textarea>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer bg-white">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="paiement.php" class="btn btn-light">Annuler</a>
                            <button name="submit" type="submit" class="btn btn-primary"> <i class="bi bi-check-lg"></i> Enregistrer le paiement </button>
                        </div>

                    </div>

                </div>

            </form>

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap"></script>
<script src="../assets/js/app.js"></script>

</body>


</html>