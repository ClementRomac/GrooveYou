<?php 
require_once("bdd.php");

if(isset($_SESSION['username'])){
	if(isset($_POST['from_load'])){
		$query = $bdd->prepare('UPDATE users SET ip = :ip, link = :link, room = :room WHERE username = :username');
		$query->execute(array('ip' => $_SERVER['REMOTE_ADDR'],
								'link' => $_SESSION['link'],
								'room' => $_SESSION['room'],
								'username' => $_SESSION['username']));
	}
	else{
		$query = $bdd->prepare("UPDATE users SET link = '', ip='', room = 0 WHERE username = :username");
		$query->execute(array('username' => $_SESSION['username']));
		
		if(!isset($_POST['from_unload'])){
			if($_SESSION['room'] != 0){
			//SUPPRESSION ROOM SI PLUS PERSONNE DEDANS
				$query = $bdd->prepare('SELECT room FROM users WHERE room = :room');
				$query->execute(array('room' => $_SESSION['room']));
				$room_empty = $query->fetch();

				if(empty($room_empty['room'])){
					$query = $bdd->prepare('DELETE FROM rooms WHERE number = :number');
					$query->execute(array('number' => $_SESSION['room']));
				}
			}
			
			$_SESSION = array();
		}
	}
}
header('Location: ../index.php');
