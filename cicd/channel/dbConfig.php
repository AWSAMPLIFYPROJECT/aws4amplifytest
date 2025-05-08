<?php
date_default_timezone_set('Europe/London');

if(!defined('isAccessible') || !defined('isActive') || constant("isActive") !== '1' || constant("isAccessible") !== 'enabled' ) { 
die("
  <center> <h1> Oops! Seems you missed your way</h1> </center>
"); 
}

class dbSetup{

	/**
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname   = "assignment";
	*/

    private $servername = "devops.ct4qa9k3b3s3.us-east-1.rds.amazonaws.com";
    private $username = "admin";
    private $password = "passworded";
    private $dbname   = "assignment";
	
function __construct(){
	@$this->dbConnect();
	@$this->createEnrolmentTable();
	@$this->createStaffTable();
	@$this->createModuleTable();
	@$this->createTimeTable();
	@$this->createMappingTable();
	@$this->createAttendanceTable();
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
function getValidInput($item){
	$con  = $this->dbConnect();
	$input = !empty($item)?strip_tags(trim($item)):0;
	$input = htmlspecialchars($input);
	return $con->real_escape_string($input);
}
function getID(){
		return rand(10000, 99999);
	}
	function qrCodeMaker($code){
		require_once('phpqrcode/qrlib.php');
		$code = isset($code)?$this->getValidInput($code):'invalid';
		return QRcode::png($code, 'images/'.$code.'.png');
	}

function createEnrolmentTable(){
	$msg = 0;
	$con = $this->dbConnect();
	$sql = "CREATE TABLE IF NOT EXISTS enrolment (id int UNIQUE auto_increment NOT NULL, stid varchar(10) NOT NULL PRIMARY KEY,
	        email varchar(256), name varchar(256), course varchar(100), programme varchar (20), session varchar(10) NOT NULL,
	        gender char (1), password varchar(256),
	        regDate timestamp DEFAULT CURRENT_TIMESTAMP);";
	$q = $con->query($sql);
	if($q !== true){ $msg = 0; }else { $msg = 1;}
	$con->close();
	return $msg;
}

function createStaffTable(){
	$msg = 0;
	$con = $this->dbConnect();
	$sql = "CREATE TABLE IF NOT EXISTS staff (id int UNIQUE auto_increment, stfid varchar(10) NOT NULL PRIMARY KEY DEFAULT 0,
	                 email varchar(255), name varchar(255), qualification varchar(100), 
		             specialisation varchar (10), dept varchar (255), rnk varchar (50),
                     password varchar(255),				 
	                 gender char (1), regDate timestamp DEFAULT CURRENT_TIMESTAMP);";
	$q = $con->query($sql);
	if($q !== true){ $msg = 0; }else { $msg = 1;}
	$con->close();
	return $msg;
}
function createModuleTable(){
	$msg = 0;
	$con = $this->dbConnect();
	
	$sql =  "CREATE TABLE IF NOT EXISTS Module (id int UNIQUE auto_increment, 
	        cosCode varchar (10), cosTitle varchar (100), level varchar(5), lecturer varchar(100),
			regDate timestamp DEFAULT CURRENT_TIMESTAMP, stfid varchar(10),
			PRIMARY KEY (id, cosCode),
			FOREIGN KEY (stfid) REFERENCES staff(stfid) ON DELETE CASCADE
			);";
	$q = $con->query($sql);
	if($q !== true){ $msg = 0; }else { $msg = 1;}
	$con->close();
	return $msg;
}

function createTimeTable(){
	$msg = 0;
	$con = $this->dbConnect();
	$sql = "CREATE TABLE IF NOT EXISTS timetable (id int auto_increment primary key,  cosCode varchar(10), 
	        openAt TIME NOT NULL, closeAt TIME NOT NULL, graceAt TIME NOT NULL, stfid varchar(10), 
			regDate timestamp DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (stfid) REFERENCES staff(stfid) ON DELETE CASCADE
			);";
	$q = $con->query($sql);
	if($q !== true){ $msg = 0; }else { $msg = 1;}
	$con->close();
	return $msg;
}

function createMappingTable(){
	$msg = 0;
	$con = $this->dbConnect();
	$sql = "CREATE TABLE IF NOT EXISTS mapping (id int auto_increment primary key,  cosCode varchar(10), 
	        stid varchar(10), cosTitle varchar(100), stfid varchar(10), 
			regDate timestamp DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (stfid) REFERENCES staff(stfid) ON DELETE CASCADE,
			FOREIGN KEY (stid) REFERENCES enrolment(stid) ON DELETE CASCADE
			);";
	$q = $con->query($sql);
	if($q !== true){ $msg = 0; }else { $msg = 1;}
	$con->close();
	return $msg;
}

function createAttendanceTable(){
	$msg = 0;
	$con = $this->dbConnect();
	$sql = "CREATE TABLE IF NOT EXISTS attendance (id int auto_increment primary key, stid varchar(10),  
	        cosCode varchar(10),  takenAt TIME, type varchar(100), 
			regDate timestamp DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (stid) REFERENCES enrolment(stid) ON DELETE CASCADE
			);";
	$q = $con->query($sql);
	if($q !== true){ $msg = 0; }else { $msg = 1;}
	$con->close();
	return $msg;
}
}
$Setup = new dbSetup();
?>
