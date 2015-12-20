<?php
session_start();
if(isset($_SESSION['username'])){
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=stream_audio_dev','root','');
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
	$bdd->query("UPDATE users SET link = '', ip = '', time = '' WHERE time < " . $timestamp_5m);


}else{
	header('Location: index.php');
}
?>