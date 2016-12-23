<!DOCTYPE html>
<?php
	include_once("include/header.php");
	
	//if the username and password are verified and cookies are set
	if(isset($_COOKIE['id']) || isset($_COOKIE['username'])) {
		$_SESSION['username'] = $_COOKIE['username'];
		header("Location: home.php");
		exit();
	}
	
	if(isset($_POST['submit'])){
		if(isset($_POST['username']) && isset($_POST['password'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
			$result = $db->verify_user($username, $password);
			if($result==true){
				$_SESSION['wrong'] = ""; //for test only
					$_SESSION['username'] = $_GET['username'];

					// login successfull
					$id = md5(rand(0,999999999999999));
				setcookie('username', $username, time() + (86400*20), "/");
				setcookie('id', $id, time() + (86400*20), "/");
				$cookie_set = $db->update_cookie_in_database($id, $username);
				if(!$cookie_set){
					$_SESSION['wrong'] = "Cookie couldn't be set.";
					header("Location: index.php");
					exit();
				}
				header("Location: home.php");
				exit();
			}else{
				$_SESSION['wrong'] = "Wrong Username and Password";
				header("Location: index.php");
				exit();
			}	
		}else{
			$_SESSION['wrong'] = "Please specify username and password";
			header("Location: index.php");
			exit();
		}
	}
?>




</html>

<html>
<head>
	<title>CSRF</title>
	
  	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<!-- <form action="index.php" method="post" style="margin-top: 150px;">
	<center>
		<h3> Username</h3>
		<input type="text" placeholder="username" name="username">
		<h3> Password</h3>
		<input type="text" placeholder="password" name="password">
		<br><br>
		<input type="submit" value="Login" name="submit">
		<br><br>
		<h3><?php 
		//If the session is not created due to incorrect username or password
		//if(isset($_SESSION['wrong'])) {
		//	echo $_SESSION['wrong'];
		//	$_SESSION['wrong'] = null;
		//}
		?></h3>
	</center>
	</form> -->
	<div class="section"></div>
  <main>
    <center>
      <!-- <img class="responsive-img" style="width: 250px;" src="http://i.imgur.com/ax0NCsK.gif" /> -->
      <br/><br/>
      <div class="section"></div>

      <h5 class="indigo-text">Please, login into your account</h5>
      <div class="section"></div>

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

          <form class="col s12" action="index.php" method="post" >
            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input  type='text' name="username" id='text' />
                <label for='text'>Enter your Username</label>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input type='password' name="password" id='password' />
                <label for='password'>Enter your Password</label>
              </div>
              <label style='float: right;'>
					<a class='pink-text' href='#!'><b>Forgot Password?</b></a>
				</label>
			
            </div>

            <br />
            <center>
              <div class='row'>
                <button type='submit' class='col s12 btn btn-large waves-effect indigo' name="submit" value="Login">Login</button>
              </div>
            </center>
          </form>
        </div>
      </div>
      <h6><?php 
		//If the session is not created due to incorrect username or password
		if(isset($_SESSION['wrong'])) {
			echo $_SESSION['wrong'];
			$_SESSION['wrong'] = null;
		}
		?></h6>
    </center>

    <div class="section"></div>
    <div class="section"></div>
  </main>

  <script type="text/javascript" src="script/jquery.js"></script>
  <script type="text/javascript" src="script/material.js"></script>
</body>
</html>
