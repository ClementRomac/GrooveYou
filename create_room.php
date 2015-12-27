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
if(empty($_SESSION['username']) || $_SESSION['room'] != 0){
	header('Location: index.php');
}
else{
	echo "<form action'' method='POST'>
			<input type='text' name='room_name' placeholder='Nom de la salle'></br>	
			<input type='password' name='password' placeholder='Mot de passe'></br><label>Laissez vide pour ne pas en mettre</label>
			<input type='submit' value='Créer' name='create'></br>
		</form><br><br>
		<a href='index.php'> Retour </a><br><br>";

		if(isset($_POST['create'])){
			if(!empty($_POST['room_name'])){
				$query = $bdd->prepare('SELECT name FROM rooms WHERE name = :name');
				$query->execute(array('name' => $_POST['room_name']));
				$is_already_taken = $query->fetch();
				if(empty($is_already_taken['name'])){
					if(empty($_POST['password']))
						$password = "";
					else
						$password = md5($_POST['password']);

					//CREATION SALLE
					$query = $bdd->prepare("INSERT INTO rooms SET name = :name, password = :password");
					$query->execute(array('name' => $_POST['room_name'],
											'password' => $password));
					
					//ON REJOINT LA SALLE	
					$query = $bdd->prepare('SELECT number FROM rooms WHERE name = :name');
					$query->execute(array('name' => $_POST['room_name']));
					$nb_room = $query->fetch();

					$query = $bdd->prepare('UPDATE users SET room = :room WHERE username = :username');
					$query->execute(array('room' => $nb_room['number'],
											'username' => $_SESSION['username']));
					$_SESSION['room'] = $nb_room['number'];
					header('Location: room.php');
				}
				else{
					echo "Ce salon existe déjà !";
				}
			}
			else{
				echo "Veuillez renseigner le nom du salon !";
			}
		}
	}
?>