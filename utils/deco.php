<?php 
require_once("bdd.php");
if(isset($_SESSION['username'])){
	$query = $bdd->prepare("UPDATE users SET link = '', ip='' WHERE username = :username");
	$query->execute(array('username' => $_SESSION['username']));
	$_SESSION = array();
}
header('Location: ../index.php');
