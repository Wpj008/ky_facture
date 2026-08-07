<?php
session_start();

require_once "../functions/users.php";


 checkLogin();

$logs = getAllLogs();
$actionsToday = getActionsToday();
$actionsWeek  = getActionsWeek();
$actionsMonth = getActionsMonth();
$actionsTotal = getActionsTotal();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique d'activité</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Ton CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/logs.css">
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

<!-- SIDEBAR -->
<?php require_once "../partials/sidebar.php"; ?>

<div class="sidebar-backdrop"></div>

<div class="main">

    <div class="content">

        <!-- Header -->
        <div class="page-header">
            <div>
                <h1>Historique d'activité</h1>
                <p>Suivez toutes les actions effectuées dans l'application.</p>
            </div>

            <button class="btn-primary">
                <i class="bi bi-download"></i>
                Exporter
            </button>
        </div>

        <!-- Statistiques -->
        <div class="stats-grid">

    <div class="stat-card">
        <span>Aujourd'hui</span>
        <h2><?= $actionsToday ?></h2>
        <small>Actions</small>
    </div>

    <div class="stat-card">
        <span>Cette semaine</span>
        <h2><?= $actionsWeek ?></h2>
        <small>Actions</small>
    </div>

    <div class="stat-card">
        <span>Ce mois</span>
        <h2><?= $actionsMonth ?></h2>
        <small>Actions</small>
    </div>

    <div class="stat-card">
        <span>Total</span>
        <h2><?= $actionsTotal ?></h2>
        <small>Actions enregistrées</small>
    </div>

</div>
        </div>

        <!-- Tableau -->
        <div class="card"
             data-paginate="#logsTable"
             data-per-page="8">

            <div class="table-header">

                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        data-table-search="#logsTable"
                        placeholder="Rechercher une activité...">
                </div>

                <div class="table-actions">
                    <select>
                        <option>Toutes les actions</option>
                        <option>Création</option>
                        <option>Modification</option>
                        <option>Suppression</option>
                        <option>Connexion</option>
                    </select>

                    <select>
                        <option>Toutes les périodes</option>
                        <option>Aujourd'hui</option>
                        <option>Cette semaine</option>
                        <option>Ce mois</option>
                    </select>
                </div>

            </div>

            <table class="table-ds" id="logsTable">

                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Utilisateur</th>
                        <th>Action</th>
                        <th>Détails</th>
                        <th>Adresse IP</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach($logs as $log): ?> 

                    <tr>

                        <td>
                            <strong><?= date('d/m/Y', strtotime($log['date_action'])) ?></strong><br>
                            <small><?= date('H:i:s', strtotime($log['date_action'])) ?></small>
                        </td>

                        <td>
                            <div class="user-info">
                                <div class="avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>

                                <span><?= $log['firstname_user'] ?> <?= $log['lastname_user'] ?></span>
                            </div>
                        </td>

                        <td>
                            <span class="badge badge-<?= $log['action_historique'] ?>">
                                <i class="bi bi-pencil-square"></i>
                                <?= $log['action_historique'] ?>
                            </span>
                        </td>

                        <td>
                            <strong><?= $log['description_historique'] ?></strong>
                        </td>

                        <td>192.168.1.10</td>

                    </tr>

                    <?php endforeach ?>

                </tbody>

            </table>

            <div class="empty-state" data-empty-for="logsTable" style="display:none"><span class="empty-state__icon"><i class="bi bi-search"></i></span>
                <h3>Aucun résultat</h3>
                <p>Aucun journal d'activité ne correspond à votre recherche.</p>
            </div>

            <div class="pagination-ds"><span class="pagination-ds__info" data-page-info></span><div class="pagination-ds__pages" data-page-buttons></div>
            </div>

        </div>

    </div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
