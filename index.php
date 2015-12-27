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
	echo "<form action'#' method='POST'>
			<input type='text' name='username' placeholder='Pseudo'></br>	
			<input type='password' name='password' placeholder='Mot de passe'></br>
			<input type='text' name='link' placeholder='Lien Stream'><span>  Vous pourrez modifier votre lien plus tard</span></br>
			<input type='submit' value='Se Connecter' name='connection'></br>
		</form><br><br>
		<a href='inscription.php'> S'inscrire ! </a><br><br>";

	if(isset($_POST['connection'])){
		if(!empty($_POST['username']) && !empty($_POST['password'])){
			$query = $bdd->prepare('SELECT username, password, ip FROM users WHERE username = :username');
			$query->execute(array('username' => $_POST['username']));
			$retour = $query->fetch();
			if(md5($_POST['password']) == $retour['password']){
				if($retour['ip'] == ''){
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['link'] = $_POST['link'];
					$_SESSION['room'] = 0;
					$query = $bdd->prepare('UPDATE users SET link = :link, ip = :ip, room = 0 WHERE username = :username');
					$query->execute(array('link' => $_POST['link'],
											'ip' => $_SERVER['REMOTE_ADDR'],
											'username' => $_SESSION['username']));
					header('Location: index.php');
				}
				else{
					echo "Cet utilisateur est déjà connecté !";
				}
			}
			else{
				echo "Mauvaise combinaison";
			}
		}else{
			echo "Tous les champs doivent être remplis";
		
		}
	}
}
else{
	if($_SESSION['room'] == 0){
		echo "<p>Accueil !</p><br>";
		echo $_SESSION['username'].'<br>';
		echo "<a href='account.php'>Votre Compte</a><br><br>";
		echo "<form id='modif_link'>
				<input type='text' id='link_value' value='".$_SESSION['link']."' style='width:500px;'><input type='submit' value='Modifier'>
			</form> 
			<div id='message_link_error'></div>";

		echo "<a href='utils/connection.php'>Deconnexion</a><br><br>";

		echo "<a href='create_room.php'>Créer un salon</a><br><br>";

		//echo "<button id='button_actualize_rooms'>Actualiser</button><br>"; 
		echo "<div id='rooms_table'></div><br>";
		echo "<div id='chat'>
				<div id='chat_messages' style='overflow:auto;border:1px solid black;width:50%;height:300px;'></div><br>
				<form id='new_message'>
					<textarea placeholder='Message' id='message'></textarea>
					<input type='submit' value='Envoyer'>
				</form>
				<div id='message_chat_error'></div>";

		require_once("utils/script.js");
	}
	else{
		header('Location: room.php');
	}
}
?>
</body>
</html>