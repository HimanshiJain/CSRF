<?php 
	include_once("include/header.php");
	header('Content-type: application/json');
	if(isset($_GET['to_file']) && $_GET['to_file'] == "csrf") {
		header("Location: logout.php");
		exit();
	}
	if(!isset($_SESSION['policy'])) {
		
		if(!isset($_GET['to_file'])) {
			unset($_SESSION['policy']);
			header("Location: index.php");
			exit();
		}
		
		$json = $db->getSourceArray($_GET['to_file']);

		$jsonstring = json_encode($json);
		echo $jsonstring;
		
	}

?>


