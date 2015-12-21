<?php
session_start();
if(isset($_SESSION['username'])){
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=Stream_Audio','root','Az3rty');
		$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
		$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$bdd->exec("SET NAMES 'utf8'");
	}
	catch(PDOException $e){
		die("Erreur MySQL: ".$e->getMessage());
	}

	//AFFICHAGE NOMBRE UTILISATEURS CONNECTES
	$retour = $bdd->prepare('SELECT username, link FROM users WHERE username != :username AND ip != ""');
	$retour->execute(array('username' => $_SESSION['username']));
	$donnees = $retour->fetchAll();
	echo "<p> Il y a ". count($donnees);
	echo count($donnees)<= 1 ? " utilisateur connecté</p>" : " utilisateurs connectés</p>";
	
	// RECUPERATION DES STREAMEURS
	foreach ($donnees as $value) {
		if($value['link'] != ""){
			echo "<label><input type='radio' name='streamers_tolisten' value='".$value['link']."'>".$value['username']."</label><br>";
		}
	}
	if(count($donnees)>0)
		echo "<input type='submit' value='Lire'>";
}else{
	header('Location: index.php');
}
?>