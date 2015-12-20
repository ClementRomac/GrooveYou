<?php
session_start();
if(isset($_SESSION['username'])){
	try{
		$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u622336288_1','u622336288_admin','oXJUYg13ib');
		$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
		$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$bdd->exec("SET NAMES 'utf8'");
	}
	catch(PDOException $e){
		die("Erreur MySQL: ".$e->getMessage());
	}
	$query = $bdd->query('SELECT id, username, message, time FROM chat ORDER BY id DESC');
	while ($data = $query->fetch()) {
		echo "<p>>>".$data['username']." - ".$data['time']." > ".$data['message']."</p>";
	}
}else{
	header('Location: index.php');
}
?>