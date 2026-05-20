<?php 
    //CONNEXION PDO A LA BASE DE DONNEES
$bdd = new PDO('mysql:host=localhost;dbname=bi_travel','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
?>