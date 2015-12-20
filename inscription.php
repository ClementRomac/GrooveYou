<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=stream_audio_dev','root','');
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
	<title>GroovYou</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<body>
<?php
if(empty($_SESSION['username'])){
	echo "<form method='POST' action=''>
			<input type='text' name='username' placeholder='Pseudo'></br>	
			<input type='password' name='password' placeholder='Mot de passe'></br>
			<input type='submit' value=\"S'Inscrire ! \" name='inscription'></br>
		</form><br><br>
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
				echo "Ce pseudo existe déjà !";
			}
		}
		else{
			echo "Veuillez remplir tous les champs !";
		}
	}
}
else{
	header('Location: index.php');
}