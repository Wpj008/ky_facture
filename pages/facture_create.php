<?php
 session_start();



require_once "../functions/customers.php";
require_once "../functions/services.php";
require_once "../functions/factures.php";

require_once "../functions/users.php";

 checkLogin();

$customers = getAllCustomers();
$services = getAllServices();
$statuts = getAllStatusFacture();


?>






<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nouvelle facture — KY-Facture</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/create.css" rel="stylesheet">
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
    <button class="icon-button sidebar-toggle" data-sidebar-toggle aria-label="Menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="navbar-app__title">
        <h1>Nouvelle facture</h1>
        <small>Brouillon</small>
    </div>

    <div class="navbar-app__actions">
        <a href="facture.php" class="btn btn-ghost btn-sm">Annuler</a>

        <button type="submit" form="formFacture" name="save_invoice" class="btn btn-secondary btn-sm"> <i class="bi bi-send"></i> Enregistrer </button>

        <button type="submit" form="formFacture" name="create_invoice" class="btn btn-primary btn-sm"> <i class="bi bi-send"></i> Émettre </button>
    </div>
</header>

<main class="page">

<form id="formFacture" action="../traitements/traitement_facture.php" method="POST" data-line-items>

<div class="row g-3">

<div class="col-lg-8">

<div class="card-ds mb-3">

<div class="card-ds__head">
<h3 style="font-size:var(--fs-h4)">Informations</h3>
</div>

<div class="row">

<form id="formFacture" action="../traitements/traitement_facture.php" method="POST" data-line-items>

<div class="col-md-6 form-group">
<label class="form-label">Client <span class="req">*</span></label>

<select
class="form-select-ds"
name="customer_id"
required>

<option value="">Sélectionner...</option>

<?php foreach($customers as $customer): ?>
  <option value="<?= $customer['id_customer'] ?>"><?= $customer['firstname_customer'] ?> <?= $customer['lastname_customer'] ?></option>
<?php endforeach; ?>

</select>

</div>

<div class="col-md-6 form-group">

<label class="form-label">Numéro</label>

<input type="text" class="form-control-ds" name="numero_facture" value="FA-<?= date("Ymd-His"); ?>" readonly>

</div>

<div class="col-md-6 form-group">

<label class="form-label">Date d'émission</label>

<input type="date" class="form-control-ds" name="date_creation_facture" value="<?=date('Y-m-d')?>" readonly>

</div>

<div class="col-md-6 form-group">

<label class="form-label">Échéance</label>

<input type="date" class="form-control-ds" name="date_echeance_facture" required>

</div>

<div class="col-md-6 form-group">

<label class="form-label">Statut</label>

<select class="form-select-ds" name="status_facture_id">

<option value="">Sélectionner...</option>

<?php foreach($statuts as $statut): ?>
  <option value="<?= $statut['id_status_facture'] ?>"><?= $statut['name_status_facture'] ?></option>

<?php endforeach; ?>

</select>

</div>

</div>

</div>

<div class="card-ds">

<div class="card-ds__head">

<h3 style="font-size:var(--fs-h4)">Lignes</h3>

<button
type="button"
class="btn btn-secondary btn-sm"
data-add-line>

<i class="bi bi-plus-lg"></i>

Ajouter une ligne

</button>

</div>

<div class="table-wrap" style="box-shadow:none;border-radius:var(--radius-lg)">

<table class="table-ds">

<thead>

<tr>

<th>Service</th>
<th>Qté</th>
<th>PU HT</th>
<th>TVA %</th>
<th>HT</th>
<th>TTC</th>
<th></th>

</tr>

</thead>

<tbody>

<tr data-line>

<td>


<select class="form-select-ds" name="service_id[]" data-service-select required>
<option value="">Sélectionner...</option>

<?php foreach($services as $service): ?>
  <option value="<?= $service['id_service'] ?>"><?= $service['name_service'] ?></option>


  <?php endforeach; ?>
  
</select>

</td>

<td>

<input class="form-control-ds" name="quantite_facture[]" data-qty type="number" min="1" value="1" required>

</td>

<td>


<input class="form-control-ds" name="prix_unitaire[]" data-price type="number" step="0.01" min="0" value="0" required>

</td>

<td>

<input class="form-control-ds" name="tva[]" data-line-vat type="number" step="0.1" value="20" required readonly>

</td>

<td>

<span class="text-mono" data-line-total-ht>0.00 €</span>

<input type="hidden" name="montant_ht[]" data-hidden-ht>

</td>

<td>

<span class="text-mono" data-line-total-ttc>0.00 €</span>

<input type="hidden" name="montant_ttc[]" data-hidden-ttc>

</td>

<td>

<button type="button" class="icon-button" data-remove-line>

<i class="bi bi-trash"></i>

</button>

</td>

</tr>

</tbody>

</table>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card-ds" style="position:sticky;top:calc(var(--navbar-height) + var(--space-6))">

<div class="card-ds__head">

<h3 style="font-size:var(--fs-h4)">Récapitulatif</h3>

</div>

<div class="stack-3">

<div class="cluster-2 justify-content-between">

<span>Total HT</span>

<span class="text-mono fw-medium" data-total-ht> 0,00 € </span>

</div>

<div class="cluster-2 justify-content-between">

<span>TVA</span>

<span class="text-mono fw-medium" data-total-vat> 0,00 € </span>

</div>

<hr>

<div class="cluster-2 justify-content-between">

<strong>Total TTC</strong>

<strong class="text-mono" data-total-ttc> 0,00 € </strong>

</div>

</div>

<hr>

<div class="form-group">

<label class="form-label">

Conditions de règlement

</label>

<textarea class="form-control-ds" name="conditions_reglement"> Paiement à réception par virement bancaire. </textarea>
<br><br>

<a href="facture.php" class="btn btn-ghost btn-sm">Annuler</a>

<button type="submit" form="formFacture" name="save_invoice" class="btn btn-primary btn-sm"> <i class="bi bi-send"></i> Enregistrer </button>

</div>

</div>

</div>

</div>

<input type="hidden" name="total_ht" data-input-total-ht>

<input type="hidden" name="total_tva" data-input-total-vat>

<input type="hidden" name="total_ttc" data-input-total-ttc>


</form>

</main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
<script src="../assets/js/facture.js"></script>
</body>
</html>

