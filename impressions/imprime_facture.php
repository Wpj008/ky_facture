<?php

require_once "../vendor/autoload.php";
require_once "../functions/factures.php";

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['id_facture']) || empty($_GET['id_facture'])) {
    die("Facture introuvable.");
}

$id_facture = (int) $_GET['id_facture'];

$facture = getFactureById($id_facture);
$lignes = getLignesFactureByFactureId($id_facture);

if (!$facture) {
    die("Facture inexistante.");
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
    margin-bottom:15px;
}

.company{
    line-height:1.7;
    font-size:13px;
}

.invoice-info{
    text-align:right;
    line-height:1.8;
    margin-top:25px;
}

.invoice-number{
    font-size:22px;
    font-weight:bold;
    color:#2563eb;
    margin-bottom:25px;
}


.client-card{
    margin:45px 0 35px;
    padding:22px 28px;
    background:#F8FAFC;
    border:1px solid #E2E8F0;
    border-radius:12px;
}

.client-label{
    font-size:11px;
    font-weight:700;
    letter-spacing:1px;
    color:#94A3B8;
    text-transform:uppercase;
    margin-bottom:14px;
}

.client-company{
    font-size:22px;
    font-weight:700;
    color:#1E293B;
    margin-bottom:6px;
}

.client-contact{
    font-size:15px;
    color:#475569;
    margin-bottom:14px;
}

.client-info{
    font-size:14px;
    color:#64748B;
    line-height:1.7;
}

.items{
    margin-top:20px;
}

.items th{
    background:#2563eb;
    color:#fff;
    padding:12px;
    font-size:13px;
    text-align:left;
}

.items td{
    border:1px solid #ddd;
    padding:10px;
}

.items td:last-child,
.items td:nth-child(2),
.items td:nth-child(3){
    text-align:right;
}

.total{
    width:320px;
    margin-top:30px;
    margin-left:auto;
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
    margin-top:50px;
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

<div class="invoice-number">
FACTURE
</div>

<strong>N° '.$facture['numero_facture'].'</strong><br><br>

Date :
'.date('d/m/Y', strtotime($facture['date_creation_facture'])).'<br>

Échéance :
'.date('d/m/Y', strtotime($facture['date_echeance_facture'])).'

</td>

</tr>

</table>

';
$html .= '

<div class="client-card">

    <div class="client-label">
        FACTURÉ À
    </div>';

if (!empty($facture['entreprise'])) {

    $html .= '

    <div class="client-company">
        '.$facture['entreprise'].'
    </div>';

}

$html .= '

    <div class="client-contact">
        Contact : '.$facture['firstname_customer'].' '.$facture['lastname_customer'].'
    </div>

    <div class="client-info">
        '.$facture['adresse_customer'].'
    </div>

    <div class="client-info">
        '.$facture['email_customer'].'
    </div>

</div>


<table class="items">

<thead>

<tr>

<th>Service</th>
<th>Qté</th>
<th>Prix unitaire</th>
<th>Total</th>

</tr>

</thead>

<tbody>';

foreach ($lignes as $ligne) {

$html .= '

<tr>

<td>'.$ligne['name_service'].'</td>

<td>'.$ligne['quantite_facture'].'</td>

<td>'.$ligne['prix_unitaire'].' €</td>

<td>'.$ligne['montant_ht'].' €</td>

</tr>';

}

$html .= '

</tbody>

</table>


<table class="total">

<tr>

<td>Total HT</td>

<td class="text-right">'.$facture['total_ht'].' €</td>

</tr>

<tr>

<td>TVA</td>

<td class="text-right">'.$facture['total_tva'].' €</td>

</tr>

<tr class="grand-total">

<td>Total TTC</td>

<td class="text-right">'.$facture['total_ttc'].' €</td>

</tr>

</table>


<div style="clear:both;"></div>

<div class="footer">

Merci de votre confiance.

</div>

</body>

</html>';


$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream($facture['numero_facture'].".pdf",["Attachment" => true]);


?>