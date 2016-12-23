<!DOCTYPE html>
<html>
<head>
	<title>CSRF - Problem</title>
</head>
<body>
<center>
	<?php 
		if($_GET['problem']) {
			echo $_GET['problem'];
		}
	?>
	<br><br>
	<form action="index.php" action="GET"> 
		<input type='submit' value='Back to Homepage'>
	</form>
</center>
</body>
</html>