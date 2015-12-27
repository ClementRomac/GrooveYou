<?php
require_once("bdd.php");

require_once("connection.js");

if(isset($_SESSION['username'])){

	//SUPPRESSION ROOM SI PLUS PERSONNE DEDANS
	$retour = $bdd->query('SELECT number FROM rooms ');
	$rooms = $retour->fetchAll();
	foreach ($rooms as $room) {
		$query = $bdd->query('SELECT room FROM users WHERE room = '.$room['number']);
		$room_empty = $query->fetch();

		if(empty($room_empty['room'])){
			$query = $bdd->prepare('DELETE FROM rooms WHERE number = :number');
			$query->execute(array('number' => $room['number']));
		}
	}

	//AFFICHAGE NOMBRE SALONS
	$retour = $bdd->query('SELECT number, name FROM rooms ');
	$donnees = $retour->fetchAll();
	echo "<p> Il y a ". count($donnees);
	echo count($donnees)<= 1 ? " salon</p>" : " salons</p>";
	
	// RECUPERATION DES SALONS
	echo "<form method='POST' action='join_room.php'>
	<table style='border:1px solid black'>";
	foreach ($donnees as $value) {
		echo "<tr><td>".$value['name']."</td><td><button name='join_room' value='".$value['number']."''>Rejoindre</button></form></td></tr>";
	}
	echo "</table></form>";
}else{
	header('Location: ../index.php');
}
?>