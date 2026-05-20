<?php
session_start();
if (empty($_SESSION['id'])) {
    header('Location:../../index.php');
    exit;
}

include('connect_db_pdo.php');

$id = $_SESSION['id'];
$nom = htmlspecialchars($_POST['nom']);
$prenom = htmlspecialchars($_POST['prenom']);
$email = htmlspecialchars($_POST['email']);
$adresse = htmlspecialchars($_POST['adresse']);
$username = htmlspecialchars($_POST['username']);
$type_compte = htmlspecialchars($_POST['type_compte']);

$stmt = $bdd->prepare("UPDATE utilisateur SET nom=?, prenom=?, email=?, adresse=?, username=?, type_compte=? WHERE id_utilisateur=?");
$stmt->execute([$nom, $prenom, $email, $adresse, $username, $type_compte, $id]);

session_start();
$_SESSION['profil_modifie'] = true;
header('Location:../../pages/profil.php');
exit();