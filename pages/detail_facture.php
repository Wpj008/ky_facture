<?php
 session_start();


 require_once "../functions/factures.php";
 require_once "../functions/paiements.php";

 require_once "../functions/users.php";

 checkLogin();

if($_GET['id'] != null && isset($_GET['id']) && !empty($_GET['id'])){

    $facture_id = $_GET['id'];


  
    }else{

        echo "Aucune facture trouvée.";
    }

    $facture = getFactureById($facture_id);

    $lignes_facture = getLignesFactureByFactureId($facture_id);

    $paiement = getPaiementById($facture_id);

?>






<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $facture['numero_facture'] ?> — KY-Facture</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/etat.css" rel="stylesheet">
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

    <?php require_once "../partials/sidebar.php" ?>
  <div class="sidebar-backdrop"></div>

  <div class="main">
    <header class="navbar-app">
      <button class="icon-button sidebar-toggle" data-sidebar-toggle aria-label="Menu"><i class="bi bi-list"></i></button>
      <div class="navbar-app__search"><i class="bi bi-search"></i><input type="search" placeholder="Rechercher…"></div>
      <div class="navbar-app__actions"><button class="icon-button" aria-label="Notifications"><i class="bi bi-bell"></i><span class="dot"></span></button><span class="avatar avatar--sm"><i class="bi bi-person-fill"></i></span></div>
    </header>

    <main class="page">
      <nav class="cluster-2 mb-4 text-secondary text-small"><a href="facture.php" class="text-secondary">Factures</a><i class="bi bi-chevron-right text-xs"></i><span class="fw-medium" style="color:var(--color-text)"><?= $facture['numero_facture']; ?></span></span></nav>

      <div class="page-header">
        <div>
          <div class="cluster-2"><h1 class="mb-0"><?= $facture['numero_facture']; ?></h1><span class="badge-ds badge-facture-<?= $facture['id_status_facture']; ?>"><?= $facture['name_status_facture']; ?></span></div>
          <p class="mb-0">Émise le <?= date('d/m/Y', strtotime($facture['date_creation_facture'])); ?> · échéance le <?= date('d/m/Y', strtotime($facture['date_echeance_facture'])); ?></p>
        </div>
        <div class="cluster-2">
          <a href="../impressions/imprime_facture.php?id_facture=<?= $facture_id ?>" class="btn btn-secondary"><i class="bi bi-download"></i> PDF</a>
          <button class="btn btn-secondary"><i class="bi bi-send"></i> Envoyer</button>
          <a href="add_paiement.php?facture_id=<?= $facture['id_facture']; ?>" class="btn btn-success" ><i class="bi bi-check2"></i> effectuer le paiement</a>
        </div>
      </div>

      <div class="row g-3">
        <!-- Aperçu document -->
        <div class="col-lg-8">
          <div class="card-ds" style="padding:var(--space-8)">
            <div class="d-flex justify-content-between flex-wrap gap-4 mb-5">
              <div>
                <div class="sidebar__brand" style="color:var(--color-primary);padding:0"><img src="../assets/img/Logo-11.png" alt="KY-Facture" style="width:150px; margin-bottom:15px;"></div>
                <p class="text-secondary mt-3 mb-0">24 avenue des Champs<br>75008 Paris<br>SIRET 900 123 456 00018</p>
              </div>
              <div class="text-end">
                <h2 class="mb-1">Facture</h2>
                <p class="text-secondary mb-0">N° <?= $facture['numero_facture']; ?><br>Date : <?= date('d/m/Y', strtotime($facture['date_creation_facture'])); ?><br>Échéance : <?= date('d/m/Y', strtotime($facture['date_echeance_facture'])); ?></p>
              </div>
            </div>

            <div class="surface p-4 mb-5" style="background:var(--color-bg);border:0">
              <small class="eyebrow">Facturé à</small>
              <div class="fw-semibold mt-1" style="font-size:var(--fs-h5)"> Nom client : <?= $facture['firstname_customer'] . ' ' . $facture['lastname_customer']; ?></div>
              <p class="text-secondary mb-0"> Entreprise : <?= $facture['entreprise'] ?? 'Non spécifiée' ?></p>
              <p class="text-secondary mb-0"> Adresse : <?= $facture['adresse_customer']; ?><br>Email : <?= $facture['email_customer']; ?></p>
            </div>

            <table class="table-ds" style="border:1px solid var(--color-border);border-radius:var(--radius-lg);overflow:hidden">
              <thead><tr><th>Description</th><th>Qté</th><th>Prix unit.</th><th class="text-end">Total</th></tr></thead>
              <tbody>
                <?php foreach($lignes_facture as $ligne): ?>
                <tr><td class="cell-strong"><?= $ligne['name_service']; ?></td><td><?= (int) $ligne['quantite_facture']; ?></td><td class="text-mono"><?= $ligne['prix_unitaire']; ?> €</td><td class="text-mono text-end"><?= $ligne['montant_ht']; ?> €</td></tr>
                <?php endforeach; ?>
              </tbody>
            </table>

       

            <div class="d-flex justify-content-end mt-4">
              <div style="min-width:280px">
                <div class="cluster-2 justify-content-between py-2"><span class="text-secondary">Total HT</span><span class="text-mono"><?= $facture['total_ht']; ?> €</span></div>
                <div class="cluster-2 justify-content-between py-2"><span class="text-secondary">TVA (20 %)</span><span class="text-mono"><?= $facture['total_tva']; ?> €</span></div>
                <hr class="divider my-2">
                <div class="cluster-2 justify-content-between py-2"><span class="fw-semibold" style="font-size:var(--fs-h5)">Total TTC</span><span class="text-mono fw-bold" style="font-size:var(--fs-h4);color:var(--color-primary)"><?= $facture['total_ttc']; ?> €</span></div>
              </div>
            </div>

            <hr class="divider">
            <small class="text-secondary">Paiement à réception par virement bancaire. IBAN FR76 3000 4000 0500 0012 3456 789. En cas de retard, des pénalités au taux légal seront appliquées.</small>
          </div>
        </div>

        <!-- Panneau latéral -->
        <div class="col-lg-4">
          <div class="card-ds mb-3">
            <div class="card-ds__head"><h3 style="font-size:var(--fs-h4)">Statut du paiement</h3></div>
            <div class="alert-ds badge-devis-<?= $facture['id_status_facture']; ?> mb-4"><i class="bi bi-hourglass-split"></i><div class="alert-ds__body"><strong><?= $facture['name_status_facture']; ?></strong><p>Échéance dans <?= floor((strtotime($facture['date_echeance_facture']) - time()) / 86400); ?>  jours.</p></div></div>
            <div class="stack-3">
              <div class="cluster-2 justify-content-between"><span class="text-secondary">Montant dû</span><span class="text-mono fw-semibold"><?= $facture['total_ttc']; ?> €</span></div>
              <div class="cluster-2 justify-content-between"><span class="text-secondary">Déjà réglé</span><span class="text-mono"><?= $paiement['montant_paiement'] ?? 0.00; ?> €</span></div>
            </div>
          </div>

          <div class="card-ds">
            <div class="card-ds__head"><h3 style="font-size:var(--fs-h4)">Suivi</h3></div>
            <ul class="list-unstyled mb-0 stack-3">
              <li class="d-flex gap-3"><span class="kpi__icon kpi__icon--info" style="width:32px;height:32px"><i class="bi bi-send"></i></span><div>Facture envoyée<div><small class="text-muted-2">28 juin · 14h02</small></div></div></li>
              <li class="d-flex gap-3"><span class="kpi__icon" style="width:32px;height:32px"><i class="bi bi-eye"></i></span><div>Consultée par le client<div><small class="text-muted-2">28 juin · 17h41</small></div></div></li>
              <li class="d-flex gap-3"><span class="kpi__icon kpi__icon--warning" style="width:32px;height:32px"><i class="bi bi-clock-history"></i></span><div>Relance planifiée<div><small class="text-muted-2">8 juil.</small></div></div></li>
            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
