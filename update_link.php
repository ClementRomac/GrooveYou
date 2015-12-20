<?php
session_start();
if(isset($_POST['username'])){
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=Stream_Audio','root','');
		$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
		$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$bdd->exec("SET NAMES 'utf8'");
	}
	catch(PDOException $e){
		die("Erreur MySQL: ".$e->getMessage());
	}
	$query = $bdd->prepare('UPDATE users SET link = :link WHERE username = :username');
	$query->execute(array('username' => $_POST['username'], 
		'link' => $_POST['link']));
}else{
	header('Location: index.php');
}
?>