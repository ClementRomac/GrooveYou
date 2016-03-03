<!DOCTYPE html>
<html>
<head>
	<title>GroovYou</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<meta charset='UTF-8'>
</head>
<body>
<?php
	require_once("utils/bdd.php");

	require_once("utils/connection.js");
?>
<?php
if(empty($_SESSION['username'])){
	echo "<form method='POST' action=''>
			<input type='text' name='username' placeholder='Pseudo'></br>	
			<input type='password' name='password' placeholder='Mot de passe'></br>
			<input type='password' name='password_2' placeholder='Mot de passe à nouveau'></br>
			<input type='password' name='password_trick' placeholder='Mot de passe de la mort qui tue'></br>
			<input type='submit' value=\"S'Inscrire ! \" name='inscription'></br>
		</form><br><br>
	<a href='index.php'>Retour</a>";
	if(isset($_POST['inscription'])){
		if($_POST['password_trick'] == "tractopelledu24"){
			if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['password_2'])){
				$query = $bdd->prepare('SELECT username FROM users WHERE username = :username');
				$query->execute(array('username' => $_POST['username']));
				$is_already_connected = $query->fetch();
				if(empty($is_already_connected['username'])){
					if($_POST['password'] == $_POST['password_2']){
						$query = $bdd->prepare("INSERT INTO users SET username = :username, password = :password, link = '', ip = ''");
						$query->execute(array('username' => $_POST['username'],
												'password' => md5($_POST['password'])));
						header('Location: index.php');
					}
					else{
						echo "Les mots de passe ne correspondent pas !";
					}
				}
				else{
					echo "Ce pseudo existe déjà !";
				}
			}
			else{
				echo "Veuillez remplir tous les champs !";
			}
		}else{
			echo "T'as pas le droit de t'inscrire !";
		}
	}
}
else{
	header('Location: index.php');
}