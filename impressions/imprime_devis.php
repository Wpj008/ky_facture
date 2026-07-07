<?php

require_once "../vendor/autoload.php";
require_once "../functions/devis.php";

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['id_devis']) || empty($_GET['id_devis'])) {
    die("Devis introuvable.");
}

$id_devis = (int) $_GET['id_devis'];

$devis = getDevisById($id_devis);
$lignes = getLignesDevisByDevisId($id_devis);

if (!$devis) {
    die("Devis inexistant.");
}

$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);

$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');
$options->setIsRemoteEnabled(true);
$dompdf = new Dompdf($options);

$logo = __DIR__ . '/../assets/img/Logo-11.png';

$type = pathinfo($logo, PATHINFO_EXTENSION);
$data = file_get_contents($logo);

$logoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


$html = '
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<style>

@page{
    margin:35px;
}

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:13px;
    color:#333;
}

table{
    width:100%;
    border-collapse:collapse;
}

.header td{
    border:none;
    vertical-align:top;
}

.logo{
    width:150px;
    height:auto;
    margin-bottom:15px;
}

.company{
    font-size:13px;
    line-height:1.7;
}

.invoice-info{
    text-align:right;
    line-height:1.8;
}

.invoice-title{
    font-size:30px;
    font-weight:bold;
    color:#2563eb;
    margin-bottom:20px;
}

.client-card{
    margin:40px 0;
    padding:22px 28px;
    border:1px solid #E6EDF8;
    border-radius:12px;
    background:#FAFBFD;
}

.client-label{
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:1px;
    color:#8A94A6;
    font-weight:700;
    margin-bottom:12px;
}

.client-company{
    font-size:22px;
    font-weight:700;
    color:#1F2937;
    margin-bottom:8px;
}

.client-contact{
    font-size:15px;
    color:#4B5563;
    margin-bottom:12px;
}

.client-info{
    color:#6B7280;
    line-height:1.7;
}

.items{
    margin-top:15px;
}

.items th{
    background:#2563eb;
    color:#fff;
    padding:12px;
    text-align:left;
}

.items td{
    border:1px solid #ddd;
    padding:10px;
}

.items td:nth-child(2),
.items td:nth-child(3),
.items td:nth-child(4){
    text-align:right;
}

.total{
    width:320px;
    margin-left:auto;
    margin-top:30px;
}

.total td{
    border:none;
    padding:8px 0;
}

.total td:last-child{
    text-align:right;
}

.grand-total td{
    font-size:22px;
    font-weight:bold;
    border-top:2px solid #2563eb;
    padding-top:15px;
}

.footer{
    margin-top:45px;
    border-top:1px solid #ccc;
    padding-top:20px;
    font-size:12px;
    color:#666;
}

</style>

</head>

<body>

<table class="header">

<tr>

<td width="55%">

<img src="'.$logoBase64.'" class="logo">

<div class="company">

<strong>KY-Facture</strong><br>

24 avenue des Champs<br>

75008 Paris<br>

SIRET : 900 123 456 00018

</div>

</td>

<td width="45%" class="invoice-info">

<div class="invoice-title">
DEVIS
</div>

<strong>N° '.$devis['numero_devis'].'</strong><br><br>

Date :
'.date('d/m/Y', strtotime($devis['date_creation_devis'])).'<br>

Valable jusqu\'au :
'.date('d/m/Y', strtotime($devis['date_validite_devis'])).'

</td>

</tr>

</table>
';

$html .= '
<div class="client-card">

    <div class="client-label">
        CLIENT
    </div>';

if (!empty($devis['entreprise'])) {
    $html .= '
    <div class="client-company">
        ' . $devis['entreprise'] . '
    </div>';
}

$html .= '
    <div class="client-contact">
        Contact : ' . $devis['firstname_customer'] . ' ' . $devis['lastname_customer'] . '
    </div>

    <div class="client-info">
        ' . $devis['adresse_customer'] . '
    </div>

    <div class="client-info">
        ' . $devis['email_customer'] . '
    </div>

</div>

';

$html .= '

<table class="items">

<thead>

<tr>

<th>Service</th>
<th>Qté</th>
<th>Prix unitaire</th>
<th>Total HT</th>

</tr>

</thead>

<tbody>

';

foreach ($lignes as $ligne) {

$html .= '

<tr>

<td>'.$ligne['name_service'].'</td>

<td>'.$ligne['quantite_devis'].'</td>

<td>'.number_format($ligne['prix_unitaire'],2,","," ").' €</td>

<td>'.number_format($ligne['montant_ht'],2,","," ").' €</td>

</tr>

';

}

$html .= '

</tbody>

</table>

<table class="total">

<tr>

<td>Total HT</td>

<td>'.number_format($devis['total_ht'],2,","," ").' €</td>

</tr>

<tr>

<td>TVA (20%)</td>

<td>'.number_format($devis['total_tva'],2,","," ").' €</td>

</tr>

<tr class="grand-total">

<td>Total TTC</td>

<td>'.number_format($devis['total_ttc'],2,","," ").' €</td>

</tr>

</table>

<div style="clear:both"></div>

<div class="footer">

Ce devis est valable jusqu\'au
<strong>'.date('d/m/Y', strtotime($devis['date_validite_devis'])).'</strong>.<br><br>

Toute acceptation de ce devis vaut engagement du client et donnera lieu à l\'émission d\'une facture.

</div>

</body>

</html>

';


$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream($devis['numero_devis'].".pdf",["Attachment" => true]);



?>