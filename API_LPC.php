<?php
try{
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u622336288_lpc','u622336288_root','administrateur');
	$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
	$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'utf8'");
}
catch(PDOException $e){
	die("Erreur MySQL: ".$e->getMessage());
}

if(!empty($_GET['infos_parents'])){
	$query = $bdd->query("SELECT * FROM infos_parents");
	$response = $query->fetch();
	print_r($response);
	header('Content-Type: application/json');
	echo json_encode($response);
}