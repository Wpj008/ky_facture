<?php
session_start();

require_once "../functions/users.php";
require_once "../functions/customers.php";
require_once "../functions/factures.php";

checkLogin();

if($_GET['id'] != null && isset($_GET['id']) && !empty($_GET['id'])){

    $facture_id = $_GET['id'];


  
    }else{

        echo "Aucune facture trouvée.";
    }

    $facture = getFactureById($facture_id);
    $customers = getAllCustomers();
    $lignes_facture = getLignesFactureByFactureId($facture_id);
    $statuts = getAllStatusFacture();
?>

<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Modifier une facture</title>

<link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/updating.css">
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


<div class="container">


<div class="app-shell">

<?php require_once "../partials/sidebar.php" ?>

<div class="page-header">

<div>

<h1>Modifier la facture</h1>

<p>Modifiez les informations de cette facture.</p>

</div>


</div>


<form action="../traitements/traitement_facture.php" method="POST">

            <input type="hidden" name="id_facture" value="<?= $facture['id_facture']; ?>">


            <!-- Informations générales -->

            <div class="card">

            <h3>Informations générales</h3>

            <div class="grid">

            <div class="form-group">

            <label>Numéro de facture</label>

            <input type="text" name="numero_facture" value="<?= $facture['numero_facture']; ?>" readonly>

            </div>


            <div class="form-group">

            <label>Client</label>

            <select name="customer_id">

            <?php foreach($customers as $customer): ?>

            <option
            value="<?= $customer['id_customer']; ?>"
            <?= $customer['id_customer']==$facture['customer_id'] ? 'selected':''; ?>>

            <?= $customer['firstname_customer']." ".$customer['lastname_customer']; ?>

            </option>

            <?php endforeach; ?>

            </select>

            </div>


            <div class="form-group">

            <label>Devis associé</label>




            <input  name="devis_id" type="text" value="<?= $facture['devis_id'] ?? 'Aucun devis existant' ?>" readonly>

            </div>



            <div class="form-group">

            <label>Statut</label>

            <select name="status_facture_id">

            <?php foreach($statuts as $status): ?>

                <option
                value="<?= $status['id_status_facture']; ?>"
                <?= $status['id_status_facture']==$facture['status_facture_id'] ? 'selected':''; ?>>
                
                <?= $status['name_status_facture'] ?>
                
                </option>
                
                <?php endforeach; ?>

            </select>

            </div>

            </div>

            </div>


            <!-- Dates -->

            <div class="card">

            <h3>Dates</h3>

            <div class="grid">

            <div class="form-group">

            <label>Date de création</label>

            <input type="date" name="date_creation_facture" value="<?= $facture['date_creation_facture']; ?>" readonly>

            </div>


            <div class="form-group">

            <label>Date d'échéance</label>

            <input type="date" name="date_echeance_facture" value="<?= $facture['date_echeance_facture']; ?>">

            </div>

            </div>

            </div>


            <div class="card">

            <h3>Prestations</h3>

            <table class="table-ds" style="border:1px solid var(--color-border);border-radius:var(--radius-lg);overflow:hidden">

                <thead>
                    <tr>
                        <th>Service</th>
                        <th style="width:120px">Qté</th>
                        <th style="width:180px">Prix unit. (€)</th>
                        <th class="text-end" style="width:180px">Total HT</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach($lignes_facture as $i => $ligne): ?>

                    <tr>
                            
                            
                    <input type="hidden" name="id_ligne[]" value="<?= $ligne['id_ligne_facture']; ?>">
                    <input type="hidden" name="service[]" value="<?= $ligne['service_id']; ?>">

                        <td class="cell-strong">
                            <?= ($ligne['name_service']); ?>
                        </td>

                        <td>

                            <input type="number" min="1" class="qte" name="quantite[]" value="<?= (int) $ligne['quantite_facture']; ?>">

                        </td>

                        <td class="price-group">

                            <input type="number" step="0.01" class="prix" name="prix[]" value="<?= $ligne['prix_unitaire']; ?>" readonly> <span class="price-unit">  /<?= $ligne['type_tarif']; ?></span>

                        </td>

                        <td>
                <div class="total-wrapper">
                    <input name="montant_ht[]" type="text" class="ligneTotal" readonly value="<?= number_format($ligne['montant_ht'],2,'.',''); ?>"> <span>€</span>
                    <input type="hidden" class="ligneTVA" value="<?= number_format($ligne['tva'],2,'.',''); ?>">
                    
                    <input type="hidden" class="ligneTTC" name="montant_ttc[]" value="<?= number_format($ligne['montant_ttc'],2,'.',''); ?>">

                </div>
            </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

            </div>



            <!-- Montants -->

            <div class="card">

            <h3>Montants</h3>

            <div class="stats-grid">

                <div class="amount-card">

                    <span>Total HT (€)</span>

                    <input type="text" id="ht" name="total_ht" readonly><small> Hors taxes</small>

                </div>

                <div class="amount-card">

                    <span>TVA (%)</span>

                    <input name="tva[]" class="taux" type="number" id="taux" value="<?= (int) $ligne['tva']; ?>" readonly>


                </div>

                <div class="amount-card">

                    <span>Total TVA (€)</span>

                    <input name="total_tva" type="text" id="tva" readonly>
                    
                    <small>TVA calculée</small>

                </div>

                <div class="amount-card success">

                    <span>Total TTC (€)</span>

                    <input name="total_ttc" type="text" id="ttc"  readonly>

                    <small>Montant final</small>

                </div>

            </div>

            </div>

            <div class="actions">

            <a href="facture.php" class="btn-annuler">Annuler</a>

            <button type="submit" name="updating_facture" class="btn-save"><i class="bi bi-check-lg"></i>Enregistrer</button>

            </div>

</form>

</div>
<script src="../assets/js/app.js"></script>
<script src="../assets/js/updating.js"></script>

</body>

</html>