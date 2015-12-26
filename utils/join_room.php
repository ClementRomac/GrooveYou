<?php
require_once("bdd.php");

require_once("connection.js");

if(isset($_SESSION['username'])){

	if(isset($_POST['join_room'])){
		$query = $bdd->prepare('SELECT password FROM rooms WHERE number = :number');
		$query->execute(array('number' =>$_POST['join_room']));
		$retour_room_infos = $query->fetch();

		if($retour_room_infos['password'] == ""){
			$query = $bdd->prepare('UPDATE users SET room = :room WHERE username = :username');
			$query->execute(array('room' => $_POST['join_room'],
									'username' => $_SESSION['username']));
			$_SESSION['room'] = $_POST['join_room'];
			header('Location: ../room.php');
		}
		else{
			echo "<form method='POST' action=''>
					<input type='password' name='password' placeholder='Password'>
					<input type='hidden' name='join_room' value='".$_POST['join_room']."'>
					<input type='submit' value='Entrer'>
				</form>
				<a href='../index.php'>Retour</a>";
			if(isset($_POST['password'])){
				if(md5($_POST['password']) == $retour_room_infos['password']){
					$query = $bdd->prepare('UPDATE users SET room = :room WHERE username = :username');
					$query->execute(array('room' => $_POST['join_room'],
											'username' => $_SESSION['username']));
					$_SESSION['room'] = $_POST['join_room'];
					header('Location: ../room.php');
				}else{
					echo "Mauvais mot de passe ! ";
				}
			}
		}
	}else{
		header('Location: ../index.php');
	}
}else{
	header('Location: ../index.php');
}
?>