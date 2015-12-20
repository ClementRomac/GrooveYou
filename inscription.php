<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=Stream_Audio','root','');
	$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
	$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'utf8'");
}
catch(PDOException $e){
	die("Erreur MySQL: ".$e->getMessage());
}
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Stream Audio de malade !</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>
<?php
if(empty($_SESSION['username'])){
	echo "<form></form><br><br>
	<a href='index.php'>Retour</a>";
}
else{
	header('Location: index.php');
}