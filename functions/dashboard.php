<?php

require_once "../functions/database.php";
require_once "../functions/logs.php";

function getChiffreAffaire()
{
    $query = getPDO()->prepare("SELECT SUM(total_ttc) AS total
                                FROM factures
                                WHERE status_facture_id = 4");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"] ?? 0;
}

function getPaiementsRecus()
{
    $query = getPDO()->prepare("SELECT SUM(montant_paiement) AS total
                                FROM paiements");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"] ?? 0;
}

function getMontantAttente()
{
    $query = getPDO()->prepare("SELECT SUM(total_ttc) AS total
                                FROM factures
                                WHERE status_facture_id = 1");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"] ?? 0;
}

function getNombreAttente()
{
    $query = getPDO()->prepare("SELECT COUNT(*) AS total
                                FROM factures
                                WHERE status_facture_id = 1");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"];
}

function getMontantRetard()
{
    $query = getPDO()->prepare("SELECT SUM(total_ttc) AS total
                                FROM factures
                                WHERE status_facture_id = 3");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"] ?? 0;
}

function getNombreRetard()
{
    $query = getPDO()->prepare("SELECT COUNT(*) AS total
                                FROM factures
                                WHERE status_facture_id = 3");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"];
}

function getNombreFacture()
{
    $query = getPDO()->prepare("SELECT COUNT(*) AS total
                                FROM factures");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"];
}

function getNombreDevis()
{
    $query = getPDO()->prepare("SELECT COUNT(*) AS total
                                FROM devis");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"];
}

function getNombreClient()
{
    $query = getPDO()->prepare("SELECT COUNT(*) AS total
                                FROM customers");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"];
}

function getSoldeDisponible()
{
    $query = getPDO()->prepare("SELECT SUM(montant_paiement) AS total
                                FROM paiements");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"] ?? 0;
}

function getCA10DerniersJours()
{
    $query = getPDO()->prepare("
        SELECT
            DATE(date_creation_facture) AS jour,
            SUM(total_ttc) AS total
        FROM factures
        WHERE status_facture_id = 4
          AND date_creation_facture >= DATE_SUB(CURDATE(), INTERVAL 9 DAY)
        GROUP BY DATE(date_creation_facture)
        ORDER BY DATE(date_creation_facture)
    ");

    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function getNombrePaye()
{
    $query = getPDO()->prepare("
        SELECT COUNT(*) AS total
        FROM factures
        WHERE status_facture_id = 4
    ");

    $query->execute();

    $data = $query->fetch(PDO::FETCH_ASSOC);

    return $data["total"];
}


function getPourcentagePaye()
{
    $total = getNombreFacture();

    if($total == 0)
    {
        return 0;
    }

    $paye = getNombrePaye();

    return ($paye * 100) / $total;
}