<?php
require_once("config.php");

class MySQLDatabase {

	private $connection;
	public $last_query;
	private $real_escape_string;
	private $magic_quotes_active;
	public $stmt;
	
	function __construct() {
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string = function_exists( "mysql_real_escape_string" );
	}
	public function open_connection() {
		$this->connection = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if (!$this->connection) {
			die("Database connection failed: ".@mysqli_error());
		} 
	}

	public function close_connection() {
		if (isset($this->connection)) {
			@mysqli_close($this->connection);
			unset($this->connection);
		}
	}
	
	public function query($sql) {
		$this->last_query = $sql;
		$result = @mysqli_query($this->connection, $sql);
		return $result;
	}

	public function escape_value( $value ) {
		if( $this->real_escape_string ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = @mysqli_real_escape_string($this->connection, $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	public function fetch_array($result_set) {
		return @mysqli_fetch_array($result_set);
	}

	public function num_rows($result_set) {
		return @mysqli_num_rows($result_set);
	}

	public function insert_id() {
		return @mysqli_insert_id($this->connection);
	}
	
	public function prepare($str){
		$this->stmt=@mysqli_prepare($this->connection,$str);
	}
	
	public function execute(){
		return @mysqli_stmt_execute($this->stmt);
	}

	
	public function affected_rows() {
		return @mysqli_affected_rows($this->connection);
	}

	public function verify_user($username, $password){
		$sql = 'SELECT username,password ';
		$sql .= 'FROM login ';
		$sql .= 'WHERE username=\''.$username.'\' AND password=\''.$password.'\';';
		$result=$this->query($sql);
		if($this->num_rows($result) == 1){
			return true;
		}else return false;
	}
	
	public function update_cookie_in_database($id, $username){
		$sql = 'UPDATE users ';
		$sql .= 'SET cookie_value=\''.$id.'\' '; 
		$sql .= 'WHERE username=\''.$username.'\';';
		return $this->query($sql);
	}
	
	public function checkCookie($id, $username){
		$sql = '';
		$sql .= 'SELECT cookie_value FROM users WHERE username=\''.$username.'\';';
		$result=$this->query($sql);
		if($this->num_rows($result) == 1){
			$row = @mysqli_fetch_assoc($result);
			if($row['cookie_value'] == $id) {
				return TRUE;
			}
		}
		return false;
	} 
	
	public function getUserInfo($username){
		$sql = "SELECT * FROM users WHERE username='".$username."';";
		$result=$this->query($sql);
		if($this->num_rows($result) == 1){
			return @mysqli_fetch_assoc($result);
		}
		return false;
	}
	
	public function isAccountValid($account_no){
		$sql = "SELECT username FROM users WHERE id=".$account_no.";";
		$result=$this->query($sql);
		if($this->num_rows($result) == 1){
			return true;
		}else return false;
	}
	
	public function executeTransaction($from_id, $to_id, $money_tranfer_sum){
		$query = "INSERT INTO transaction(from_user_id,to_user_id, money) VALUES(?, ?, ?);";
		$this->prepare($query);
		$this->stmt->bind_param("iii", $from_id, $to_id, $money_tranfer_sum);
		return $this->execute();
	}
	
	public function updateRecepient($to_id, $money_tranfer_sum){
		$sql ="UPDATE users SET money=money+".$money_tranfer_sum."  WHERE id=".$to_id.";";
		return $this->query($sql);
	}
	
	public function updateUser($from_id, $money_tranfer_sum){
		$sql = "UPDATE users SET money=money-".$money_tranfer_sum." WHERE id=".$from_id.";";
		return $this->query($sql);
	}
	
	public function getSourceArray($to_file){
		$sql = "SELECT from_file FROM policy WHERE to_file='".$to_file."';";
		$result = $this->query($sql);
		$json = array();
		while($row = @mysqli_fetch_assoc($result)) {
			//$hashed = "";
			//$hashed = md5($row);
			$row["from_file"] = md5("http://localhost:81/csrf_refined/".$row["from_file"].".php");
			array_push($json, $row);
		}
		return $json;
	}
}
$database = new MySQLDatabase();
$db =& $database;

?>