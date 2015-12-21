<?php
require_once("bdd.php");

if(isset($_SESSION['username'])){
	$query = $bdd->query('SELECT id, username, message, time FROM chat ORDER BY id DESC');
	while ($data = $query->fetch()) {
		echo "<p>>>".$data['username']." - ".$data['time']." > ".$data['message']."</p>";
	}
}else{
	header('Location: ../index.php');
}
?>