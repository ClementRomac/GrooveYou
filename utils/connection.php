<?php 
require_once("bdd.php");

if(isset($_SESSION['username'])){
	if(isset($_POST['from_load'])){
		$query = $bdd->prepare('UPDATE users SET ip = :ip WHERE username = :username');
		$query->execute(array('ip' => $_SERVER['REMOTE_ADDR'],
								'username' => $_SESSION['username']));
	}
	else{
		$query = $bdd->prepare("UPDATE users SET link = '', ip='' WHERE username = :username");
		$query->execute(array('username' => $_SESSION['username']));
		if(!isset($_POST['from_unload'])){
			$_SESSION = array();
		}
	}
}
header('Location: ../index.php');
