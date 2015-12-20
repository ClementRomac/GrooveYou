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

	//AFFICHAGE NOMBRE UTILISATEURS CONNECTES
	$retour = $bdd->prepare('SELECT username, link FROM users WHERE username != :username AND link != "" AND ip != "0"');
	$retour->execute(array('username' => $_SESSION['username']));
	$donnees = $retour->fetchAll();
	echo "<p> Il y a ". count($donnees);
	echo count($donnees)<= 1 ? " utilisateur connecté</p>" : " utilisateurs connectés</p>";
	
	// RECUPERATION DES STREAMEURS
	foreach ($donnees as $value) {
		echo "<label><input type='radio' name='streamers_tolisten' value='".$value['link']."'>".$value['username']."</label><br>";
	}
	if(count($donnees)>0)
		echo "<input type='submit' value='Lire'>";
}else{
	header('Location: index.php');
}
?>