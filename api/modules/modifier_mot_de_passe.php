<?php
session_start();
require_once 'connect_db_pdo.php';

if (isset($_POST['id_user'], $_POST['ancien_mot_de_passe'], $_POST['nouveau_mot_de_passe'], $_POST['confirmation_mot_de_passe'])) {
    $id_user = $_POST['id_user'];
    $ancien_mdp = $_POST['ancien_mot_de_passe'];
    $nouveau_mdp = $_POST['nouveau_mot_de_passe'];
    $confirmation_mdp = $_POST['confirmation_mot_de_passe'];

    if ($nouveau_mdp !== $confirmation_mdp) {
        $_SESSION['mdp_err'] = "Les mots de passe ne correspondent pas.";
        header("Location: ../../pages/profil.php");
        exit;
    }

    // Vérifier l'ancien mot de passe
    $stmt = $bdd->prepare("SELECT password FROM utilisateur WHERE id_utilisateur = ?");
    $stmt->execute([$id_user]);
    $user = $stmt->fetch();

    if ($user && password_verify($ancien_mdp, $user['password'])) {
        $nouveau_hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
        $update = $bdd->prepare("UPDATE utilisateur SET password = ? WHERE id_utilisateur = ?");
        $update->execute([$nouveau_hash, $id_user]);

        $_SESSION['mdp_success'] = "Mot de passe modifié avec succès.";
    } else {
        $_SESSION['mdp_err'] = "Ancien mot de passe incorrect.";
    }
} else {
    $_SESSION['mdp_err'] = "Données manquantes.";
}

header("Location: ../../pages/profil.php");
exit;
