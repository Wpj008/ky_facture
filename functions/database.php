<?php 


function getPDO() { 
    try{
        $db =  new PDO('mysql:host=localhost;dbname=ky_office', "root", "");
        return $db;
    }
    catch(PDOException $err){
        var_dump($err);
        throw $err;

    }
    
}


function debugPDO(PDO $db){
    var_dump($db);
}

?>