<?php
//Here we optimised codes against operational cost because it is a mini project.
date_default_timezone_set('Europe/London');
define('isActive', '1');
define('isAccessible','enabled');
include_once('dbconfig.php');

class QRCodeManager extends dbSetup{
	
function __construct(){ 
	//$this->enrolStudent(); 
	//$this->enrolStaff();
	//$this->captureModule();
	//$this->captureTimetable();
	//$this->mapStudentToModule();
	//$this->captureAttendance();
}
function studentSignIn($stid, $password){

	
	$stid = $this->getValidInput($stid);
	$pwd  = $this->getValidInput($password);
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM enrolment WHERE (stid=? OR email=?) AND password =?";
	$state =''; 
    $prp = $con->prepare($cmd);	
	    if(!$prp->bind_param('sss', $stid, $stid, $pwd)){ $con->close(); return $state = 'Either password or eamil or student ID mistmatched.';}
		$prp->execute();
		$data = $prp->get_result();
		if($data->num_rows < 1) { $con->close();  return $state = 'Sorry! No record found.'; }
		return $state = 1;

	} catch (Error $e){ $con->close(); return $state = $e->getMessage(); }
	$con->close();
	return $state = 'Something went wrong. Try again.';
}
function staffSignIn(){

	$pwd      = (isset($_POST['password']) && !empty($_POST['password']))?$this->getValidInput($_POST['password']):0;
	$stfid    = (isset($_POST['stfid']) && !empty($_POST['stfid']))?$this->getValidInput($_POST['stfid']):0;
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM staff WHERE (stfid=? OR email=?) AND password =?";
	$state =''; 
    $prp = $con->prepare($cmd);	
	    if(!$prp->bind_param('sss', $stfid, $stfid, $pwd)){ $con->close(); return $state = 'Either password or eamil or student ID mistmatched.';}
		$prp->execute();
		$data = $prp->get_result();
		if($data->num_rows < 1) { $con->close();  return $state = 'Sorry! Email, ID or Password is Incorrect.'; }
		return $state = 1;

	} catch (Error $e){ $con->close(); return $state = $e->getMessage(); }
	$con->close();
	return $state = 'Something went wrong. Try again.';
}
function getStudentInfo($stid){

	
	$stid = $this->getValidInput($stid);
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM enrolment WHERE stid=? OR email=?";
	$state = ['stid'=>'', 'name'=>'', 'email'=>'', 'course'=>'', 'programme '=>'', 'session '=>'', 'gender'=>'']; 
    $prp = $con->prepare($cmd);	
	    if(!$prp->bind_param('ss', $stid, $stid)){ $con->close(); return $state ;}
		$prp->execute();
		$data = $prp->get_result();
		if($data->num_rows < 0) { $con->close(); return $state; }
		while($row = $data->fetch_array()) {
			$state = ['stid'=>$this->getValidInput($row['stid']), 'name'=>$this->getValidInput($row['name']), 
			          'email'=>$this->getValidInput($row['email']), 'course'=>$this->getValidInput($row['course']), 
					  'programme '=>$this->getValidInput($row['programme']), 'session '=>$this->getValidInput($row['session']), 
					  'gender'=>$this->getValidInput($row['gender'])]; 
		}
		
	} catch (Error $e){ $con->close(); return $state; }
	$con->close();
	return $state;
}


function getStaffInfo($stfid){
	
	$stfid = $this->getValidInput($stfid);
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM staff WHERE stfid=? OR email=?";
	$state = ['stfid'=>'', 'name'=>'', 'email'=>'', 'qualification'=>'', 'specialisation '=>'', 'rank '=>'', 'department'=>'']; 
    $prp = $con->prepare($cmd);	
	    if(!$prp->bind_param('ss', $stfid,$stfid)){ $con->close(); return $state ;}
		$prp->execute();
		$data = $prp->get_result();
		if($data->num_rows < 0) { $con->close(); return $state; }
		while($row = $data->fetch_array()) {
			$state = ['stfid'=>$this->getValidInput($row['stfid']), 'name'=>$this->getValidInput($row['name']), 
			          'email'=>$this->getValidInput($row['email']), 'qualification'=>$this->getValidInput($row['qualification']), 
					  'specialisation '=>$this->getValidInput($row['specialisation']), 'rank '=>$this->getValidInput($row['rnk']), 
					  'department'=>$this->getValidInput($row['dept'])]; 
		}
		
	} catch (Error $e){ $con->close(); return $state; }
	$con->close();
	return $state;
}

function getModuleInfo($stfid, $cosCode){
	
	$stfid   = $this->getValidInput($stfid);
	$cosCode = $this->getValidInput($cosCode);
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM module WHERE stfid=? OR  cosCode =?";
	$state = ['stfid'=>'', 'cosCode'=>'', 'cosTitle'=>'', 'level'=>'', 'lecturer '=>'', 'id'=>'']; 
    $prp = $con->prepare($cmd);	
	    if(!$prp->bind_param('ss', $stfid, $cosCode)){ $con->close(); return $state ;}
		$prp->execute();
		$data = $prp->get_result();
		if($data->num_rows < 0) { $con->close(); return $state; }
		while($row = $data->fetch_array()) {
			$state = ['stfid'=>$this->getValidInput($row['stfid']), 'cosCode'=>$this->getValidInput($row['cosCode']), 
			          'cosTitle'=>$this->getValidInput($row['cosTitle']), 'level'=>$this->getValidInput($row['level']), 
					  'lecturer '=>$this->getValidInput($row['lecturer']), 'id '=>$this->getValidInput($row['id'])]; 
		}
		
	} catch (Error $e){ $con->close(); return $state; }
	$con->close();
	return $state;
}
function getTimetableInfo($stfid, $cosCode){
	
	$stfid   = $this->getValidInput($stfid);
	$cosCode = $this->getValidInput($cosCode);
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM timetable WHERE stfid=? OR  cosCode =?";
	$state = ['stfid'=>'', 'cosCode'=>'', 'openAt'=>'', 'closeAt'=>'', 'graceAt'=>'', 'id'=>'']; 
    $prp = $con->prepare($cmd);	
	    if(!$prp->bind_param('ss', $stfid, $cosCode)){ $con->close(); return $state ;}
		$prp->execute();
		$data = $prp->get_result();
		if($data->num_rows < 0) { $con->close(); return $state; }
		while($row = $data->fetch_array()) {
			$state = ['stfid'=>$this->getValidInput($row['stfid']), 'cosCode'=>$this->getValidInput($row['cosCode']), 
			          'openAt'=>$this->getValidInput($row['openAt']), 'closeAt'=>$this->getValidInput($row['closeAt']), 
					  'graceAt'=>$this->getValidInput($row['graceAt']), 'id '=>$this->getValidInput($row['id'])]; 
		}
		
	} catch (Error $e){ $con->close(); return $state; }
	$con->close();
	return $state;
}
function getMappingInfo($stid, $cosCode){
	
	$stid   = $this->getValidInput($stid);
	$cosCode = $this->getValidInput($cosCode);
	try {
	$con = $this->dbConnect();		
	$cmd = "SELECT * FROM mapping WHERE stid=? OR  cosCode =?";
	$state = ['stid'=>'', 'cosCode'=>'', 'cosTitle'=>'', 'stfid'=>'']; 
    $prp = $con->prepare($cmd);	
	    if(!$prp->bind_param('ss', $stid, $cosCode)){ $con->close(); return $state ;}
		$prp->execute();
		$data = $prp->get_result();
		if($data->num_rows < 0) { $con->close(); return $state; }
		while($row = $data->fetch_array()) {
			$state = ['stid'=>$this->getValidInput($row['stid']), 'cosCode'=>$this->getValidInput($row['cosCode']), 
			          'cosTitle'=>$this->getValidInput($row['cosTitle']), 'stfid'=>$this->getValidInput($row['stfid'])]; 
		}
		
	} catch (Error $e){ $con->close(); return $state; }
	$con->close();
	return $state;
}
function enrolStudent(){

	 $err =  '';
	if (isset($_POST['register'])){
		
	    $stid    = 'STD'.$this->getID();
		$fname    = (isset($_POST['firstname']) && !empty($_POST['firstname']))?$this->getValidInput($_POST['firstname']):0;
		$lname    = (isset($_POST['lastname']) && !empty($_POST['lastname']))?$this->getValidInput($_POST['lastname']):0;
		$email    = (isset($_POST['email']) && !empty($_POST['email']))?$this->getValidInput($_POST['email']):0;
		$cos      = (isset($_POST['course']) && !empty($_POST['course']))?$this->getValidInput($_POST['course']):0;
		$prg      = (isset($_POST['programme']) && !empty($_POST['programme']))?$this->getValidInput($_POST['programme']):0;
		$sex      = (isset($_POST['gender']) && !empty($_POST['gender']))?$this->getValidInput($_POST['gender']):0;
        $sexn     = (isset($_POST['session']) && !empty($_POST['session']))?$this->getValidInput($_POST['session']):0;
		$pwd      = (isset($_POST['password']) && !empty($_POST['course']))?$this->getValidInput($_POST['password']):0;
		$name     = $fname.' '.$lname;
	
		if($this->getStudentInfo($email)['email'] != '' ){ return $err = 'User with this email exists. Try again.</p>'; }
		try{
		$con = $this->dbConnect();
        $cmd = "INSERT INTO enrolment(stid, password, email, name,  course, programme, session, gender ) 
		        VALUES(?,?,?,?,?,?,?,?)";
		$prp = $con->prepare($cmd);
		$bind = $prp->bind_param('ssssssss',$stid, $pwd, $email, $name, $cos, $prg, $sexn, $sex);
		if(!$bind){ $prp->close();  return $err = 'Data Mismatched, try again.'; }
		if($prp->execute()){ 
			$this->qrCodeMaker($stid);
			$prp->close(); $con->close();
			return $err = 1;
		}
	    } catch (Error $e){ 	return $err =  $e->getMessage(); }
	}
	 return $err = 'Unknown action. Try again';
}

function enrolStaff(){
	//if (isset($_POST['axnBtn'])){
	    $err = '';
	    $stid    = 'STF'.$this->getID();
		$fname    = (isset($_POST['firstname']) && !empty($_POST['firstname']))?$this->getValidInput($_POST['firstname']):0;
		$lname    = (isset($_POST['lastname']) && !empty($_POST['lastname']))?$this->getValidInput($_POST['lastname']):0;
		$email    = (isset($_POST['email']) && !empty($_POST['email']))?$this->getValidInput($_POST['email']):0;
		$qualfxn  = (isset($_POST['qualification']) && !empty($_POST['qualification']))?$this->getValidInput($_POST['qualification']):0;
		$spec     = (isset($_POST['specialisation']) && !empty($_POST['specialisation']))?$this->getValidInput($_POST['specialisation']):0;
		$sex      = (isset($_POST['gender']) && !empty($_POST['gender']))?$this->getValidInput($_POST['gender']):0;
        $dept     = (isset($_POST['department']) && !empty($_POST['department']))?$this->getValidInput($_POST['department']):0;
		$rank     = (isset($_POST['rank']) && !empty($_POST['rank']))?$this->getValidInput($_POST['rank']):0;
		$pwd      = (isset($_POST['password']) && !empty($_POST['course']))?$this->getValidInput($_POST['password']):0;
		$name     = $fname.' '.$lname;
		
		if($this->getStaffInfo($email)['email'] != ''   ){ return $err = 'Staff record exists. Try again.'; }
		try{
		$con = $this->dbConnect();
        $cmd = "INSERT INTO staff(stfid, password, email, name,  rnk, dept, qualification, specialisation, gender ) 
		        VALUES(?,?,?,?,?,?,?,?,?)";
		$prp = $con->prepare($cmd);
		$bind = $prp->bind_param('sssssssss', $stid, $pwd, $email, $name, $rank, $dept, $qualfxn, $spec, $sex);
		if(!$bind){ $prp->close();  return $err = 'Data Mismatched, try again.'; }
		if($prp->execute()){ 
			$prp->close(); $con->close();
            $this->qrCodeMaker($stid);
			return $err =  1;
		}
	    } catch (Error $e){ 
			return $err =  $e->getMessage();			
		}
		return $err =  'Something went wrong. Try again.';
	//}
}
function captureModule(){
	$err = '';
	//if (isset($_POST['axnBtn'])){
		//var_dump($_SESSION);
	    $cosCode    = (isset($_POST['cosCode']) && !empty($_POST['cosCode']))?$this->getValidInput(trim($_POST['cosCode'])):0;
		$cosTitle   = (isset($_POST['cosTitle']) && !empty($_POST['cosTitle']))?$this->getValidInput($_POST['cosTitle']):0;
		$level      = (isset($_POST['level']) && !empty($_POST['level']))?$this->getValidInput($_POST['level']):0;
		$lect       = (isset($_POST['lecturer']) && !empty($_POST['lecturer']))?$this->getValidInput($_POST['lecturer']):0;
		$stfid      = (isset($_POST['stfid']) && !empty($_POST['stfid']))?$this->getStaffInfo($this->getValidInput($_POST['stfid']))['stfid']:0; //remember to generate this session on login
		$modInfo    = $this->getModuleInfo($stfid, $cosCode);
		if(empty($stfid)){ return $err = 'Staff record not found. Try again.'; }
		if(!empty($modInfo['stfid']) && $modInfo['cosCode'] === $cosCode ){ return $err = 'Module exists. Try again.'; }
		try{
		$con = $this->dbConnect();
        $cmd = "INSERT INTO module(stfid, cosCode, cosTitle, level,  lecturer) 
		        VALUES(?,?,?,?,?)";
		$prp = $con->prepare($cmd);
		$bind = $prp->bind_param('sssss',$stfid, $cosCode, $cosTitle, $level, $lect);
		if(!$bind){ $prp->close();  return $err = 'Data Mismatched, try again.'; }
		if($prp->execute()){ 
			$prp->close(); $con->close();
			return $err=1;
		}
	    } catch (Error $e){ 
			return $err = $e->getMessage();
		}
		return $err = "Something went wrong. Try again.";
	//}
}

function captureTimetable(){
	//if (isset($_POST['axnBtn'])){
		
	    $stfid      = @$this->getStaffInfo($_SESSION['stfid'])['stfid']; //remember to generate this session on login
		$cosCode    = (isset($_POST['cosCode']) && !empty($_POST['cosCode']))?$this->getValidInput($_POST['cosCode']):0;
		$open       = (isset($_POST['openAt']) && !empty($_POST['openAt']))?$this->getValidInput($_POST['openAt']):0;
		$close      = (isset($_POST['closeAt']) && !empty($_POST['closeAt']))?$this->getValidInput($_POST['closeAt']):0;
		$grace      = (isset($_POST['[graceAt]']) && !empty($_POST['graceAt']))?$this->getValidInput($_POST['graceAt']):0;
		//var_dump($this->getTimetableInfo($stfid, $cosCode));
		if($this->getTimetableInfo($stfid, $cosCode)['stfid'] == $stfid && $this->getTimetableInfo($stfid, $cosCode)['cosCode'] == $cosCode ){ echo '<p>Timetable  exists.</p>'; return; }
		try{
		$con = $this->dbConnect();
        $cmd = "INSERT INTO timetable (stfid, cosCode, openAt, closeAt,  graceAt) 
		        VALUES(?,?,?,?,?)";
		$prp = $con->prepare($cmd);
		$bind = $prp->bind_param('sssss',$stfid, $cosCode, $open, $close, $grace);
		if(!$bind){ $prp->close();  return $err = 'Data Mismatched, try again.'; }
		if($prp->execute()){ 
			$prp->close(); $con->close();
		}
	    } catch (Error $e){ 
			return $e->getMessage();
		}
		
	//}
}
function mapStudentToModule(){
	//if (isset($_POST['axnBtn'])){
		$err = '';
	    $stfid      = @$this->getStaffInfo($_POST['stfid'])['stfid']; //remember to generate this session on login
		$cosCode    = (isset($_POST['cosCode']) && !empty($_POST['cosCode']))?$this->getValidInput($_POST['cosCode']):0;
		$stid       = @$this->getStudentInfo($_POST['stid'])['stid']; //embed it into the form and let the lecturer to add the cos code only
		$cosTitle   = @$this->getModuleInfo($stfid, $cosCode)['cosTitle'];

		if($this->getModuleInfo($stfid, $cosCode)['stfid'] == ''){ return $err = 'Staff does not exist. Please enrol the student and try again'; }
		if($stid == ''){ return $err = 'Student does not exist. Please enrol the student and try again'; }
		if($this->getMappingInfo($stid, $cosCode)['stid'] == $stid && $this->getMappingInfo($stid, $cosCode)['cosCode'] == $cosCode ){ return $err = 'Student has been assigned.'; }
		try{
		$con = $this->dbConnect();
        $cmd = "INSERT INTO mapping (stfid, stid, cosCode, CosTitle) 
		        VALUES(?,?,?,?)";
		$prp = $con->prepare($cmd);
		$bind = $prp->bind_param('ssss',$stfid, $stid, $cosCode, $cosTitle);
		if(!$bind){ $prp->close();  return $err = 'Data Mismatched, try again.'; }
		if($prp->execute()){ 
			$prp->close(); $con->close();
			return $err =1;
		}
	    } catch (Error $e){ 
			return $err = $e->getMessage();
		}
	return	$err =	'Something went wrong. Try again.';
	//}
}
function captureAttendance(){
	$err = '';
	//if (isset($_POST['axnBtn'])){
		
	   $currentTime    = date('h:i:s A');
		$latitude       = (isset($_POST['latitude']) && !empty($_POST['latitude']))?$this->getValidInput($_POST['latitude']):0;
		$longitude      = (isset($_POST['longitude']) && !empty($_POST['longitude']))?$this->getValidInput($_POST['longitude']):0;
		$cosCode        = (isset($_POST['cosCode']) && !empty($_POST['cosCode']))?$this->getValidInput($_POST['cosCode']):0;
		$stid           = (isset($_POST['stid']) && !empty($_POST['stid']))?$this->getValidInput($_POST['stid']):0;
		$mappingInfo    = $this->getMappingInfo($stid, $cosCode);
		$type           = 'clock in';
        $stid           = @$this->getStudentInfo($stid)['stid'];
      
		if(substr($stid, 0,3) != 'STD'){ return $err = 'Sorry! Only student of this school can take attendance at the moment. ['.$stid.'] is not allowed.'; }
        if($mappingInfo['stid']=='' || $mappingInfo['stfid'] == '' ){ return $err =  'You are not eligible to take attendance'; }
		if($this->getTimetableInfo($mappingInfo['stfid'], $cosCode)['cosCode'] != $cosCode || empty($cosCode) == true ){ return $err = 'Timetable doesn \'t exist.'; }
		
		
		$timetableInfo    = $this->getTimetableInfo($mappingInfo['stfid'], $cosCode);
		$allowedOpenTime  = $timetableInfo['openAt'];
        $allowedCloseTime = $timetableInfo['closeAt'];
		$allowedGraceTime = $timetableInfo['graceAt'];

		try{
		$con = $this->dbConnect();
        $cmd = "INSERT INTO attendance (stid, cosCode, takenAt, type) VALUES(?,?,?,?)";
		$prp = $con->prepare($cmd);
		$bind = $prp->bind_param('ssss', $stid, $mappingInfo['cosCode'], $currentTime, $type);
		if(!$bind){ $prp->close();  return $err = 'Data Mismatched, try again.'; }
		if($prp->execute()){ 
			$prp->close(); $con->close();
			return $err = 1;
		}
	    } catch (Error $e){ 
			return $err = $e->getMessage();
		}
		return $err = "Something went wrong. Try again.";
	//}
}
function manualAttendance(){
	$err = '';
	$uid              = (isset($_POST['stid']) && !empty($_POST['stid']))?$this->getValidInput($_POST['stid']):0;
	$pwd              = (isset($_POST['password']) && !empty($_POST['password']))?$this->getValidInput($_POST['password']):0;
	$courseCode       = (isset($_POST['cosCode']) && !empty($_POST['cosCode']))?$this->getValidInput($_POST['cosCode']):0;
	if(empty($courseCode)){ return $err = 'Enter Course Code';}
	$user_exists      = $this->studentSignIn($uid, $pwd);
	if($user_exists !== 1){ return $err = $user_exists; }
	return $err = $this->captureAttendance();
}
function getAttendanceRecord(){
	
	try {
	$con = $this->dbConnect();		
	$state = '';
	$sn = 0;
	$cmd = "SELECT * FROM attendance";
    $prp = $con->prepare($cmd);	
	    //if(!$prp->bind_param('ss', $stid, $cosCode)){ $con->close(); return $state ;}
		$prp->execute();
		
		$data = $prp->get_result();
		if($data->num_rows < 0) { $con->close(); return $state = 'No record found.'; }
		echo "<table>
                <tr><th>S/N</th><th>Name</th><th>Student ID</th><th>Course Code</th><th>Time</th><th>Type</th><th>Action</th>
                </tr>";
		while($row = $data->fetch_array()) { $sn++;
			$stdInfo = $this->getStudentInfo($this->getValidInput($row['stid']));
		
			echo
			"<tr>
			<td>$sn</td>
			<td>{$stdInfo['name']}</td>
			<td>{$this->getValidInput($row['stid'])}</td>
			<td>{$this->getValidInput($row['cosCode'])}</td>
			<td>{$this->getValidInput($row['takenAt'])}</td>
			<td>{$this->getValidInput($row['type'])}</td>
			<td>
			  <a href='' style='color: #fff;' class='fa fa-trash' title='Delete'></a>
			  <a href='' style='color: #fff;' class='fa fa-edit' title='Update'></a>
			</td>  
		</tr>";

		}
	echo "</table>";
	} catch (Error $e){ $con->close(); return $state='No data found'; }

	$con->close();
	return $state ='Something went wrong';
}
}
$launch = new QRCodeManager();

?>