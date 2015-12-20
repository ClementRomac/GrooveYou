<?php 
try{
	$bdd = new PDO('mysql:host=localhost;dbname=stream_audio_dev','root','');
	$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
	$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'utf8'");
}
catch(PDOException $e){
	die("Erreur MySQL: ".$e->getMessage());
}
session_start();
$query = $bdd->prepare("UPDATE users SET link = '', ip='', time='' WHERE username = :username");
$query->execute(array('username' => $_SESSION['username']));
session_destroy();
header('Location: index.php');
