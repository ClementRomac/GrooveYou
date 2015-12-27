<?php
require_once("bdd.php");

require_once("connection.js");

if(isset($_SESSION['username'])){
	$query = $bdd->prepare('SELECT id, username, message, time FROM chat WHERE room = :room ORDER BY id DESC LIMIT 20');
	$query->execute(array('room' => $_SESSION['room']));
	while ($data = $query->fetch()) {
		echo "<p>>>".$data['username']." - ".$data['time']." > ".$data['message']."</p>";
	}
}else{
	header('Location: ../index.php');
}
?>