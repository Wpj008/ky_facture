<?php
session_start();

require_once "../functions/users.php";


 checkLogin();

$logs = getLogs();

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
                    <h2>18</h2>
                    <small>Actions</small>
                </div>

                <div class="stat-card">
                    <span>Cette semaine</span>
                    <h2>73</h2>
                    <small>Actions</small>
                </div>

                <div class="stat-card">
                    <span>Ce mois</span>
                    <h2>246</h2>
                    <small>Actions</small>
                </div>

                <div class="stat-card">
                    <span>Total</span>
                    <h2>1 284</h2>
                    <small>Actions enregistrées</small>
                </div>

            </div>

            <!-- Tableau -->
            <div class="card">

                <div class="table-header">

                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Rechercher une activité...">
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

                <table class="table-ds">

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

                        <!-- Ligne 1 -->

                        <?php foreach($logs as $log): ?> 
                        <tr>
                            <td>
                                <strong><?= date('d/m/Y', strtotime($log['date_action']))?></strong><br>
                                    <small><?= date('H:i:s', strtotime($log['date_action']))?></small>
                            </td>

                            <td>
                                <div class="user-info">
                                    <div class="avatar"><i class="bi bi-person-fill"></i></div>
                                    <span><?= $log['firstname_user'] ?>  <?= $log['lastname_user'] ?></span>
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

                        <!-- Ligne 2 -->
                        <tr>
                            <td>
                                <strong>15/07/2026</strong><br>
                                <small>11:03</small>
                            </td>

                            <td>
                                <div class="user-info">
                                    <div class="avatar"><i class="bi bi-person-fill"></i></div>
                                    <span>Admin</span>
                                </div>
                            </td>

                            <td>
                                <span class="badge badge-create">
                                    <i class="bi bi-plus-circle-fill"></i>
                                    Création
                                </span>
                            </td>

                            <td>Client</td>

                            <td>
                                Création du client
                                <strong>Jean Dupont</strong>
                            </td>

                            <td>192.168.1.12</td>
                        </tr>

                        <!-- Ligne 3 -->
                        <tr>
                            <td>
                                <strong>14/07/2026</strong><br>
                                <small>18:40</small>
                            </td>

                            <td>
                                <div class="user-info">
                                    <div class="avatar"><i class="bi bi-person-fill"></i></div>
                                    <span>Paul Paolo</span>
                                </div>
                            </td>

                            <td>
                                <span class="badge badge-delete">
                                    <i class="bi bi-trash-fill"></i>
                                    Suppression
                                </span>
                            </td>

                            <td>Service</td>

                            <td>
                                Suppression du service
                                <strong>Maintenance</strong>
                            </td>

                            <td>192.168.1.18</td>
                        </tr>

                        <!-- Ligne 4 -->
                        <tr>
                            <td>
                                <strong>14/07/2026</strong><br>
                                <small>08:12</small>
                            </td>

                            <td>
                                <div class="user-info">
                                    <div class="avatar"><i class="bi bi-person-fill"></i></div>
                                    <span>Administrateur</span>
                                </div>
                            </td>

                            <td>
                                <span class="badge badge-login">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    Connexion
                                </span>
                            </td>

                            <td>Système</td>

                            <td>
                                Connexion à l'application
                            </td>

                            <td>192.168.1.20</td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            <div class="pagination">

                <button class="page-btn"><i class="bi bi-chevron-left"></i></button>

                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>

                <span class="dots">...</span>

                <button class="page-btn">8</button>

                <button class="page-btn"><i class="bi bi-chevron-right"></i></button>

            </div>

        </div>

    </div>

</div>
<script src="../assets/js/app.js"></script>
</body>
</html>
