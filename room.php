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
	header('Location: index.php');
}
else{
	$query = $bdd->prepare('SELECT room FROM users WHERE username = :username');
	$query->execute(array('username' => $_SESSION['username']));
	$retour_room_user = $query->fetch();
	$room_user = $retour_room_user['room'];

	if($_SESSION['room'] == 0){
		header('Location: index.php');
	}
	else{
		$query = $bdd->prepare('SELECT name FROM rooms WHERE number = :number');
		$query->execute(array('number' =>$_SESSION['room']));
		$retour_room_infos = $query->fetch();

		echo "<p>SALLE : ".$retour_room_infos['name']."</p><br>";
		echo "<form method='POST' action=''>
				<input type='submit' name='leave_room' value='Quitter'>
			</form><br><br>";
		echo $_SESSION['username'].'<br>';
		echo "<a href='account.php'>Votre Compte</a><br><br>";
		echo "<form id='modif_link'>
				<input type='text' id='link_value' value='".$_SESSION['link']."' style='width:500px;'><input type='submit' value='Modifier'>
			</form> 
			<div id='message_link_error'></div>";

		echo "<a href='utils/connection.php'>Deconnexion</a><br><br>";

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

		if(isset($_POST['leave_room'])){
			//SUPPRESSION ROOM SI PLUS PERSONNE DEDANS
			$query = $bdd->prepare('SELECT room FROM users WHERE room = :room');
			$query->execute(array('room' => $_SESSION['room']));
			$room_empty = $query->fetch();

			if(empty($room_empty['room'])){
				$query = $bdd->prepare('DELETE FROM rooms WHERE number = :number');
				$query->execute(array('number' => $_SESSION['room']));
			}

			//QUIT UTILISATEUR
			$query = $bdd->prepare('UPDATE users SET room = 0 WHERE username = :username');
			$query->execute(array('username' => $_SESSION['username']));
			$_SESSION['room'] = 0;
			header('Location: index.php');
		}

		require_once("utils/script.js");
	}
}
?>
</body>
</html>