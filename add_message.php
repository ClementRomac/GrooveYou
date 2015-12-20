<?php
session_start();
if(isset($_POST['username'])){
	try{
		$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u622336288_1','u622336288_admin','oXJUYg13ib');
		$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
		$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$bdd->exec("SET NAMES 'utf8'");
	}
	catch(PDOException $e){
		die("Erreur MySQL: ".$e->getMessage());
	}
	$query = $bdd->prepare('INSERT INTO chat VALUES ("", :username, :message, :time)');
	$query->execute(array('username' => $_POST['username'], 
		'message' => $_POST['message'], 'time' => $_POST['time']));
}else{
	header('Location: index.php');
}
?>