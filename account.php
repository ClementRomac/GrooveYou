<?php
	require_once("utils/bdd.php");

	require_once("utils/connection.js");
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
	header('Location: index.php');
}
else{
	echo $_SESSION['username'].'<br>';
	echo "<a href='index.php'>Retour</a><br><br>";
	echo "<form method='POST' action=''>
			<input type='password' name='old_password' placeholder='Mot de passe actuel'></br>	
			<input type='password' name='new_password' placeholder='Nouveau mot de passe'></br>
			<input type='password' name='new_password_2' placeholder='Nouveau mot de passe à nouveau'></br>
			<input type='submit' value='Changer mon mot de passe' name='change_password'></br>
		</form>";

	echo "<form method='POST' action=''><button name='delete_account' onclick=\"return(confirm('Etes-vous sûr de vouloir supprimer votre compte ?'));\">Supprimer le compte</button></form><br>"; 

	if(isset($_POST['change_password'])){
		if(!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['new_password_2'])){
			if($_POST['new_password'] == $_POST['new_password_2']){
				$query = $bdd->prepare('SELECT password FROM users WHERE username = :username');
				$query->execute(array('username' => $_SESSION['username']));
				$old_password = $query->fetch();

				if($old_password['password'] == md5($_POST['old_password'])){
					$query = $bdd->prepare('UPDATE users SET password = :password WHERE username = :username');
					$query->execute(array('username' => $_SESSION['username'], 
						'password' => md5($_POST['new_password'])));
					echo "Votre mot de passe a été changé !";
				}
				else{
					echo "Votre mot de passe actuel est faux";
				}
			}
			else{
				echo "Les nouveaux mots de passe ne correspondent pas !";
			}
		}
		else{
			echo "Veuillez remplir tous les champs !";
		}
	}

	if(isset($_POST['delete_account'])){
		$query = $bdd->prepare('DELETE FROM users WHERE username = :username');
		$query->execute(array('username' => $_SESSION['username']));
		$_SESSION = array();
		header("Location: index.php");
	}
}
?>
</body>
</html>