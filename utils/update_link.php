<?php
require_once("bdd.php");

if(isset($_POST['username'])){
	$query = $bdd->prepare('UPDATE users SET link = :link WHERE username = :username');
	$query->execute(array('username' => $_POST['username'], 
		'link' => $_POST['link']));
}else{
	header('Location: ../index.php');
}
?>