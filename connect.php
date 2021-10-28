
<?php
try{
    // Connexion à la bdd
    $conn = new PDO('pgsql:host=127.0.0.1; port=5432; dbname=identification sslmode=require', 'postgres','password');
    $conn->exec('SET NAMES "UTF8"');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die();
}

?>