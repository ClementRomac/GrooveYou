<?php
session_start();
if(isset($_SESSION['username'])){
	try{
		$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u622336288_1','u622336288_admin','oXJUYg13ib');
		$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
		$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$bdd->exec("SET NAMES 'utf8'");
	}
	catch(PDOException $e){
		die("Erreur MySQL: ".$e->getMessage());
	}

	//Mise à jour time du streamer
	$bdd->query('UPDATE users SET time=' . time() . '  where ip="' . $_SERVER['REMOTE_ADDR'] . '"');

	//SUPPRESSION DES UTILISATEURS ABSENTS DEPUIS PLUS DE 5m
	$timestamp_5m = time() - (5*60);
	echo $timestamp_5m;
	$bdd->query("UPDATE users SET link = '', ip = '', time = '' WHERE time < " . $timestamp_5m);


}else{
	header('Location: index.php');
}
?>