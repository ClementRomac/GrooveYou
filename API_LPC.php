<?php
try{
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u622336288_lpc','u622336288_root','administrateur');
	$bdd->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
	$bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'utf8'");
}
catch(PDOException $e){
	die("Erreur MySQL: ".$e->getMessage());
}

$method = $_SERVER['REQUEST_METHOD'];
if($method['apikey'] == 'test') echo "OK KEY";
print_r($method);
if($method == 'GET'){
	if(!empty($_GET['infos'])){
		switch ($_GET['infos']) {
			case 'infos_parents':
				$query = $bdd->query("SELECT * FROM infos_parents ORDER BY id DESC");
				$response = $query->fetch();
				header('Content-Type: application/json');
				echo json_encode($response);
				break;
			
			default:
				echo "error these infos don't exist";
				break;
		}
	}
	else{
		echo "error infos must not be empty";
	}
}
else if($method == 'PUT'){
	//UPDATE
}
else if($method == 'POST'){
	//INSERT
}
else{
	echo "error the HTTP requested isn't implemented";
}