<?php 
	require_once('include/header.php');

	$result = $db->checkCookie( $_COOKIE['id'] , $_COOKIE['username']);
	if($result != TRUE) {
		@mysqli_close();
		header("Location: logout.php");
		exit();
	} else {
		//refresh both the cookies
		setcookie('username', $_COOKIE['username'], time() + (86400*20), "/");
		setcookie('id', $_COOKIE['id'], time() + (86400*20), "/");
		$_SESSSION['username'] = $_COOKIE['username'];
		$_SESSION['id'] = $_COOKIE['id'];
	}

	/////////////////////
	// for Money Transfer 

	if(isset($_GET['submit'])) {
		if(isset($_GET['account_no']) && isset($_GET['money'])) {		
		    $from_id = null;
			$to_id = null;
			$money_tranfer_sum = null;
			$user_money = null;
			$row = $db->getUserInfo($_SESSSION['username']);
			if($row){
				$from_id = $row['id'];
				$user_money = $row['money'];
			}
			
			$account_valid = $db->isAccountValid($_GET['account_no']);
			
			if($account_valid == TRUE ){
				$to_id = $_GET['account_no'];
			} else {
				$_SESSION['problem'] = "Account Number NOT Valid";
			}
			$money_tranfer_sum = (int) $_GET['money'];
			
			if($from_id != null && $to_id != null && $user_money != null && $money_tranfer_sum != null) {

				if($user_money - $money_tranfer_sum > 1000) {
					if($db->executeTransaction($from_id, $to_id, $money_tranfer_sum)){
						if($db->updateRecepient($to_id, $money_tranfer_sum)){
							if($db->updateUser($from_id, $money_tranfer_sum)){
								$_SESSION['money_tranfer'] = 1;
								$_SESSION['problem'] = "Transaction Successfull";
							}else{
								$_SESSION['money_tranfer'] = 2;
							}
						}else{
							$_SESSION['money_tranfer'] = 3;
						}
					}else {

						$_SESSION['money_tranfer'] = 4;
					}
					
				} else {

					$_SESSION['money_tranfer'] = 5;
				}

			} else {

				$_SESSION['money_tranfer'] = 6;
			}

		} else {

			$_SESSION['money_tranfer'] = 7;
		}
	// 	header("Location: home.php");
	// 	exit();
	}


	//////////////////////

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home - CSRF</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="section"></div>
  <main>
    <center>
      <!-- <img class="responsive-img" style="width: 250px;" src="http://i.imgur.com/ax0NCsK.gif" /> -->
      <br/><br/>
      <div class="section"></div>

      <h5 class="indigo-text">Hello, <?php echo $_COOKIE['username'];?></h5>
      <div class="section"></div>

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

          <form class="col s12" action="home.php"  method='GET' >
            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input  type='text'  name="account_no" id="text3" />
                <label for='text3'>Tranfer to Account No.</label>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input type='text' name="money" id="text4"/>
                <label for='text4'>Money to be Transferred</label>
              </div>
              <label style='float: right;'>
					<h6 class='pink-text'><b>Transfer Funds</b></h6>
				</label>
			
            </div>
            <h6><?php 
		if(isset($_SESSION['money_tranfer'])) {
			//echo $_SESSION['money_tranfer'];
			$_SESSION['money_tranfer'] = null;
		}
		?></h6>
		<h6><?php 
		if(isset($_SESSION['problem'])) {
			echo $_SESSION['problem'];
			$_SESSION['problem'] = null;
		}
		?></h6>
            
            <center>
              <div class='row'>
                <button type="submit" value="Transfer" name="submit" class='col s12 btn btn-large waves-effect indigo'>Transfer</button>
              </div>
            </center>
          </form>
        </div>
      </div>
      
    </center>
    <form class="col s12" action="logout.php" method="GET" >
            <center>
            <div class='row'>
                <button type='submit' value='Logout' class='col s2 offset-s5 btn btn-large waves-effect indigo'>Logout</button>
              </div>
              </center>
              </form>
  </main>

  <script type="text/javascript" src="script/jquery.js"></script>
  <script type="text/javascript" src="script/material.js"></script>




</body>
</html>