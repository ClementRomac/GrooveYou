<?php
require_once("bdd.php");

require_once("connection.js");

if(isset($_POST['username'])){
	$query = $bdd->prepare('INSERT INTO chat VALUES ("", :username, :message, :time, :room)');
	$query->execute(array('username' => $_POST['username'], 
		'message' => $_POST['message'], 
		'time' => $_POST['time'],
		'room' => $_SESSION['room']));
}else{
	header('Location: ../index.php');
}
?>