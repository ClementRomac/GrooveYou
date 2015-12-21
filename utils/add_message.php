<?php
require_once("bdd.php");

require_once("connection.js");

if(isset($_POST['username'])){
	$query = $bdd->prepare('INSERT INTO chat VALUES ("", :username, :message, :time)');
	$query->execute(array('username' => $_POST['username'], 
		'message' => $_POST['message'], 'time' => $_POST['time']));
}else{
	header('Location: ../index.php');
}
?>