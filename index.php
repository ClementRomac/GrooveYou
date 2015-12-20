<?php
try{
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u622336288_1','u622336288_admin','oXJUYg13ib');
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
					$query = $bdd->prepare('UPDATE users SET link = :link, ip = :ip, time = :time WHERE username = :username');
					$query->execute(array('link' => $_POST['link'],
											'ip' => $_SERVER['REMOTE_ADDR'],
											'time' => time(),
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
	echo "<a href='deco.php'>Deconnexion</a><br><br>";

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
			<div id='message_chat_error'></div>
			<div id='deconnect_streamers'></div>";
}
?>
</body>
</html>
<script type="text/javascript">
$(function() {
//LINK
	$('#modif_link').submit(function(e){	
		e.preventDefault();
		var link = $('#link_value').val();
		$.ajax({
		        url : "update_link.php",
		        type : "POST",
		        data : "username=" + <?= '"'.$_SESSION['username'].'"' ?> + "&link=" + link,
		        success : function(code_html, statut){
           			$('#link_value').val(link);
		       },
		       error : function(resultat, statut, erreur){
		       		$("#modif_link").append("Erreur lors de la modification");
		       }
    	});
	});

//STREAMERS
	function actualize_streamers(){
		$('#streamers').load('streamers.php');
		//setTimeout(actualize_streamers, 2000);
	}
	actualize_streamers();

	$("#button_actualize_streamers").click(function(e){
		actualize_streamers();
	})

	$('#streamers').submit(function(e){
		e.preventDefault();
		var link = $('input[name=streamers_tolisten]:checked').val();
		$('#player').html("<audio controls autoplay name='media'><source src='"+ link +"' ></audio>");
	});

//CHAT
	function load_chat_messages(){
		$('#chat_messages').load("chat_messages.php");
		setTimeout(load_chat_messages, 2000);
	}
	load_chat_messages();

	function insert_chat_message(){
		var message = $('#message').val();
		$('#message').val("");
		var date = <?= '"'.date('d/m/Y H:i:s').'"' ?>;
		if(message != "" && message != " "){
		    $.ajax({
		        url : "add_message.php",
		        type : "POST",
		        data : "username=" + <?= '"'.$_SESSION['username'].'"' ?> + "&message=" + message + "&time=" + date,success : function(code_html, statut){
           			load_chat_messages();
           			$('#message_chat_error').text("");
		       },
		       error : function(resultat, statut, erreur){
		       		$('#message_chat_error').text("Erreur lors de l'envoi du message");
		       }
		    });
		}else{
			$('#message_chat_error').text("Veuillez entrer un message non vide");
		}
	}

	$('#new_message').submit(function(e){
		e.preventDefault();
		insert_chat_message();
	});

	//KICK DECONNECTED TOUTES LES MINUTES
	function deconnect_streamers(){
		$('#deconnect_streamers').load("deconnect_streamers.php");
		setTimeout(deconnect_streamers, 60000);
	}
	deconnect_streamers();
});
</script>