<?php
require_once "../functions/database.php";
require_once "../functions/logs.php";


function InsertDevis($numero_devis, $customer_id, $date_creation, $date_echeance, $status, $total_ht, $total_tva, $total_ttc, $created_by, $service, $quantite, $prix, $tva, $montant_ht, $montant_ttc){

    try{

        $pdo = getPDO();

        $pdo->beginTransaction();

        $queryInsert = $pdo->prepare(" INSERT INTO devis ( numero_devis, customer_id, date_creation_devis, date_validite_devis, status_devis_id, total_ht, total_tva, total_ttc, created_by) VALUES(:numero,:customer,:date_creation,:date_echeance,:status, :ht, :tva, :ttc, :created_by)");

        $queryInsert->bindParam(":numero", $numero_devis);
        $queryInsert->bindParam(":customer", $customer_id);
        $queryInsert->bindParam(":date_creation", $date_creation);
        $queryInsert->bindParam(":date_echeance",$date_echeance,);
        $queryInsert->bindParam(":status",$status,);
        $queryInsert->bindParam(":ht",$total_ht,);
        $queryInsert->bindParam(":tva",$total_tva,);
        $queryInsert->bindParam(":ttc",$total_ttc,);
        $queryInsert->bindParam(":created_by",$created_by);
       

        $queryInsert->execute();

        $devis_id = $pdo->lastInsertId();

        $queryLine = $pdo->prepare("INSERT INTO ligne_devis (devis_id, service_id, quantite_devis, prix_unitaire, tva,montant_ht, montant_ttc) VALUES( :devis,:service,:quantite,:prix,:tva,:ht,:ttc)");

        foreach($service as $i=>$srv){

            if(trim($srv)==""){
                continue;
            }

            $queryLine->execute([

                "devis"=>$devis_id,
                "service"=>$service[$i] == "" ? null : $service[$i],
                "quantite"=>$quantite[$i],
                "prix"=>$prix[$i],
                "tva"=>$tva[$i],
                "ht"=>$montant_ht[$i],
                "ttc"=>$montant_ttc[$i]

            ]);

        }


        $pdo->commit();

        InsertHistorique(
            $_SESSION['user_id'],
            "CREATE",
            $_SESSION['first_name']." ".$_SESSION['last_name'] ." a créé le devis n° $numero_devis pour le client dont Ref: « $customer_id » d'un montant global de ".number_format($montant_ttc,2,","," ")." €."
         );

        header("Location: ../pages/devis.php");
        exit;

    }

    catch(PDOException $e){

        $pdo->rollBack();

        die($e->getMessage());

    }

}



function getAllDevis(){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM devis INNER JOIN customers ON devis.customer_id = customers.id_customer INNER JOIN status_devis ON devis.status_devis_id = status_devis.id_status_devis");
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }catch(PDOException $e){
        echo "Erreur lors de la récupération des devis : " . $e->getMessage();
    }
}


function getAllDevisDashboard(){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM devis INNER JOIN customers ON devis.customer_id = customers.id_customer INNER JOIN status_devis ON devis.status_devis_id = status_devis.id_status_devis ORDER BY id_devis DESC  LIMIT 5");
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }catch(PDOException $e){
        echo "Erreur lors de la récupération des devis : " . $e->getMessage();
    }
}


function getAllStatusDevis(){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM status_devis");
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }catch(PDOException $e){
        echo "Erreur lors de la récupération des statuts de devis : " . $e->getMessage();
    }
}


function getDevisById($devisId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM devis INNER JOIN customers ON devis.customer_id = customers.id_customer INNER JOIN status_devis ON devis.status_devis_id = status_devis.id_status_devis WHERE id_devis = :devisId");
        $querySelect->bindParam(":devisId", $devisId);
        $querySelect->execute();
        $result = $querySelect->fetch(PDO::FETCH_ASSOC);
        return $result;

    }catch(PDOException $e){
        echo "Erreur lors de la récupération de la devis : " . $e->getMessage();
    }
}

function getLignesDevisByDevisId($devisId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM ligne_devis INNER JOIN services ON ligne_devis.service_id = services.id_service WHERE devis_id = :devisId");
        $querySelect->bindParam(":devisId", $devisId);
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }catch(PDOException $e){
        echo "Erreur lors de la récupération des lignes de devis : " . $e->getMessage();
    }
}


function getDevisByCustomer($customerId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM devis INNER JOIN customers ON devis.customer_id = customers.id_customer INNER JOIN status_devis ON devis.status_devis_id = status_devis.id_status_devis WHERE customer_id = :customerId");
        $querySelect->bindParam(":customerId", $customerId);
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }catch(PDOException $e){
        echo "Erreur lors de la récupération des devis du client : " . $e->getMessage();
    }
}



function getDevisByUser($userId){

    try{
        $querySelect = getPDO()->prepare("SELECT * FROM devis INNER JOIN users ON devis.created_by = users.id_user INNER JOIN status_devis ON devis.status_devis_id = status_devis.id_status_devis WHERE created_by = :userId");
        $querySelect->bindParam(":userId", $userId);
        $querySelect->execute();
        $result = $querySelect->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }catch(PDOException $e){
        echo "Erreur lors de la récupération des devis du client : " . $e->getMessage();
    }
}



function updateDevis($id_devis, $id_ligne, $customer_id,$date_echeance,$status,$total_ht,$total_tva,$total_ttc, $quantite, $montant_ht, $montant_ttc, $numero_devis){

    try{

        $pdo = getPDO();

        $pdo->beginTransaction();

        // Mise à jour de la devis
        $querydevis = $pdo->prepare("UPDATE devis SET customer_id = :customer, date_validite_devis = :date_echeance, status_devis_id = :status, total_ht = :ht, total_tva = :tva, total_ttc = :ttc, updated_at_devis = NOW() WHERE id_devis = :id");



        $querydevis->bindParam(":id", $id_devis);
        $querydevis->bindParam(":customer", $customer_id);
        $querydevis->bindParam(":date_echeance",$date_echeance,);
        $querydevis->bindParam(":status",$status,);
        $querydevis->bindParam(":ht",$total_ht,);
        $querydevis->bindParam(":tva",$total_tva,);
        $querydevis->bindParam(":ttc",$total_ttc,);
 


        $querydevis->execute();

        // Mise à jour des lignes
        $queryLine = $pdo->prepare(" UPDATE ligne_devis SET quantite_devis = :quantite, montant_ht = :ht, montant_ttc = :ttc, updated_at_lignedevis = NOW() WHERE id_ligne_devis = :id_ligne");

        foreach($id_ligne as $i => $ligne){

            $queryLine->execute([

                
                "quantite" => $quantite[$i],
                "ht"       => $montant_ht[$i],
                "ttc"      => $montant_ttc[$i],
                "id_ligne" => $ligne

            ]);


        }

        $pdo->commit();

        InsertHistorique(
            $_SESSION['user_id'],
            "UPDATE",
            $_SESSION['first_name']." ".$_SESSION['last_name'] ." a modifié le devis n° $numero_devis."
        );
        

       header("Location: ../pages/devis.php");
        exit;

    }

    catch(PDOException $e){

        $pdo->rollBack();

        die($e->getMessage());

    }

}



function deleteDevis($id_devis){


    try{

        $queryDelete = getPDO()->prepare("DELETE FROM devis WHERE id_devis = :id");

        $queryDelete->bindParam(":id", $id_devis);

        InsertHistorique(
            $_SESSION['user_id'],
            "DELETE_DEVIS",
            $_SESSION['first_name']." ".$_SESSION['last_name'] ." a supprimé le devis Ref : $id_devis."
        );

        $queryDelete->execute();

        header("Location: ../pages/devis.php");
        exit();


     }catch(PDOException $e){
        echo "Erreur lors de la suppression de la devis : " . $e->getMessage();
    }



}



?>