<?php

try {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $pdo = new PDO('mysql:host=localhost;port=8013;dbname=reserves_crud', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}


$id = $_POST['id'] ?? null;

if (!$id){
    header('Location: resultat.php');
    exit; 
}
$statement = $pdo->prepare('DELETE FROM paiement WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();

