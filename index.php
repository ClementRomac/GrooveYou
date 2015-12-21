<?php
	require_once("utils/bdd.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>GroovYou</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<meta charset='UTF-8'>
</head>
<body>
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
					$query = $bdd->prepare('UPDATE users SET link = :link, ip = :ip WHERE username = :username');
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
	echo $_SESSION['username'].'<br>';
	echo "<form id='modif_link'>
			<input type='text' id='link_value' value='".$_SESSION['link']."' style='width:500px;'><input type='submit' value='Modifier'>
		</form> ";
	echo "<a href='utils/deco.php'>Deconnexion</a><br><br>";

	echo "<button id='button_actualize_streamers'>Actualiser</button><br>"; 
	echo "<form id='streamers'></form>";
	echo "<div id='player'>	
		</div><br><br><br><br>";
	echo "<div id='chat'>
			<div id='chat_messages' style='overflow:auto;border:1px solid black;width:50%;height:300px;'></div><br>
			<form id='new_message'>
				<textarea placeholder='Message' id='message'></textarea>
				<input type='submit' value='Envoyer'>
			</form>
			<div id='message_chat_error'></div>";

	require_once("utils/script.js");
}
?>
</body>
</html>