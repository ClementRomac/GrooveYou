<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=Stream_Audio','root','Az3rty');
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
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<meta charset='UTF-8'>
</head>
<body>
<div class="inscription">
<?php
if(empty($_SESSION['username'])){
	echo "<p>Inscription</p>
	<form method='POST' action=''>
			<input type='text' name='username' placeholder='Pseudo'></br>	
			<input type='password' name='password' placeholder='Mot de passe'></br>
			<input type='submit' value=\"S'Inscrire ! \" name='inscription'></br>
		</form>
		</div>
	<a href='index.php'>Retour</a>";
	if(isset($_POST['inscription'])){
		if(!empty($_POST['username']) && !empty($_POST['password'])){
			$query = $bdd->prepare('SELECT username FROM users WHERE username = :username');
			$query->execute(array('username' => $_POST['username']));
			$is_already_connected = $query->fetch();
			if(empty($is_already_connected['username'])){
				$query = $bdd->prepare("INSERT INTO users SET username = :username, password = :password, link = '', ip = '', time = ''");
				$query->execute(array('username' => $_POST['username'],
										'password' => md5($_POST['password'])));
				header('Location: index.php');
			}
			else{
				echo "<p>Ce pseudo existe déjà !</p>";
			}
		}
		else{
			echo "<p>Veuillez remplir tous les champs !</p>";
		}
	}
}
else{
	header('Location: index.php');
}