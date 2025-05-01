<?php

class Setup{
	/**
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname   = "assignment";
	*/
	private $servername = "oesdb2.c58k8mecwnmd.eu-north-1.rds.amazonaws.com";
    private $username = "oesdb2";
    private $password = "passworded";
    private $dbname   = "oesdb2";
	
function __construct(){
	@$this->dbConnect();
	@$this->createSubscriberTable();
	@var_dump($this->enrolSubscriber());
	@$this->getSubscribers();
}

function dbConnect(){
   // Create connection
	$conn = @mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
	// Check connection
		if ($conn->connect_error) {
			// Create database if it does not exist
			$sql = "CREATE DATABASE IF NOT EXISTS $this->dbname";
			if ($conn->query($sql) === TRUE) {
				$conn = $conn;
			} else {
				$conn = $conn;
			}	
			$msg = $conn->connect_error;
		}else { $conn = $conn; }
		return $conn;
}
function createSubscriberTable(){
	$msg = 0;
	$con = $this->dbConnect();
	$sql = "CREATE TABLE IF NOT EXISTS subscribers (id int UNIQUE auto_increment, email varchar(255) NOT NULL PRIMARY KEY DEFAULT 0,
	        regDate timestamp DEFAULT CURRENT_TIMESTAMP);";
	$q = $con->query($sql);
	if($q !== true){ $msg = 0; }else { $msg = 1;}
	$con->close();
	return $msg;
}
function enrolSubscriber(){
	if (isset($_POST['subscribe'])){
		
	
		$email    = (isset($_POST['email']) && !empty($_POST['email']))?htmlspecialchars($_POST['email']):0;
		if(!empty($this->getSubscriberInfo($email))){ $_SESSION['error'] = 'Sorry! Email already exists.'; header("Location: index.html"); exit();}
		try{
		$con = $this->dbConnect();
        $cmd = "INSERT INTO subscribers(email) VALUES(?)";
		$prp = $con->prepare($cmd);
		$bind = $prp->bind_param('s', $email);
		if(!$bind){ $prp->close();  return $err = 'Not a valid email, try again.'; }
		if($prp->execute()){ 
			$prp->close(); $con->close();
			header("Location: oessuccess.html"); exit();
		}
	    } catch (Error $e){ 
			 $con->close();
			return $e->getMessage(); 
		}
		
}
}
function getSubscriberInfo($email){
	
	$email = htmlspecialchars($email);
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM subscribers WHERE email=?";
	$state = ''; 
    $prp = $con->prepare($cmd);	
	    if(!$prp->bind_param('s', $email)){ $con->close(); return $state ;}
		$prp->execute();
		$data = $prp->get_result();
		if($data->num_rows < 0) { $con->close(); return $state; }
		while($row = $data->fetch_array()) {
			$state = htmlspecialchars($row['email']);
		}
		
	} catch (Error $e){ $con->close(); return $state; }
	$con->close();
	return $state;
}
function getSubscribers(){

	
	
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM subscribers";
	$state = ['stid'=>'', 'name'=>'', 'email'=>'', 'course'=>'', 'programme '=>'', 'session '=>'', 'gender'=>'']; 
    $prp = $con->prepare($cmd);	
		$prp->execute();
		$data = $prp->get_result();
		$sn = 0;
		echo "<table><tr><th>SN</th><th>Email</th><th>Sub Date</th></tr>";
		while($row = $data->fetch_array()) {
			$sn++;
			echo "<tr><td>{$sn}</td><td>".htmlentities($row['email'])."</td><td>".htmlentities($row['regDate'])."</td></tr>";
		}
		echo "</table>";
	} catch (Error $e){ $con->close(); return $state; }
	$con->close();
	return $state;
}
}

$db = new Setup();
?>