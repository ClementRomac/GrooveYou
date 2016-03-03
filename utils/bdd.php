<?php
try{
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u622336288_1','u622336288_admin','oXJUYg13ib');
	$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
	$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'utf8'");
}
catch(PDOException $e){
	die("Erreur MySQL: ".$e->getMessage());
}
session_start();
?>