<?php 
try{
	$bdd = new PDO('mysql:host=localhost;dbname=Stream_Audio','root','Az3rty');
	$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
	$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'utf8'");
}
catch(PDOException $e){
	die("Erreur MySQL: ".$e->getMessage());
}
session_start();
$query = $bdd->prepare('DELETE FROM users WHERE username = :username');
$query->execute(array('username' => $_SESSION['username']));
session_destroy();
header('Location: index.php');
