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

	//AFFICHAGE NOMBRE UTILISATEURS CONNECTES
	$retour = $bdd->query('SELECT COUNT(*) AS nbre_entrees FROM users WHERE username!="' . $_SESSION['username'] . '"');
	$donnees = $retour->fetch();
	echo "<p> Il y a ". $donnees['nbre_entrees'];
	echo $donnees['nbre_entrees'] <= 1 ? " utilisateur connecté</p>" : " utilisateurs connectés</p>";
	
	// RECUPERATION DES STREAMEURS
	$query = $bdd->prepare('SELECT username, link FROM users WHERE username != :username AND link != ""');
	$query->execute(array('username' => $_SESSION['username']));
	$data = $query->fetchAll();
	foreach ($data as $value) {
		echo "<label><input type='radio' name='streamers_tolisten' value='".$value['link']."'>".$value['username']."</label><br>";
	}
	if(count($data)>0)
		echo "<input type='submit' value='Lire'>";
}else{
	header('Location: index.php');
}
?>