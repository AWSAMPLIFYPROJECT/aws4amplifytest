<!DOCTYPE html>
<html>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="../images/logo.png" type="">

  <title> UoB Attandance System </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="../css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

</head>

<body onload='getGeolocation();'>

  <div class="hero_area" style="float:center; background-image:url('../images/background5.jpg'); background-repeat: no-repeat; background-size: cover;">
   
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <button class="navbar-toggler" type="but=]ton" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent" style="background-color: black;">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item active">
                <a class="nav-link" href="../index.html">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Staff</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
              </li>
            </ul>
            <div class="user_option">
              <a href="" class="user_link">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
              <a class="cart_link" href="#">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" 
                xmlns:xlink="http://www.w3.org/1999/xlink" 
                x="0px" y="0px" viewBox="0 0 456.029 456.029" 
                style="enable-background:new 0 0 456.029 456.029;" 
                xml:space="preserve">
                  <g>
                    <g>
                      <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                   c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                    </g>
                  </g>
                </svg>
              </a>

            </div>
          </div>
        </nav>
      </div>
    </header>
<!-- end header section -->
<!-- book section -->
<section class="book_section layout_padding" id="att">
  
    <div class="container" >

    <?php 
try{
          include_once('qrcodeManager.php');
          $handler = new QRCodeManager();
            if(isset($_POST['stid']) && !isset($_POST['manual'])){
            $status = $handler->captureAttendance();
            if($status ===1 ){ echo "<p class='text-success text-center'>Attendance succcessfully taken. </p>";}
            else{ echo "<p class='text-danger text-center'><b>{$status}</b></p>"; }
            
          }
          if(isset($_POST['manual'])){
            $status = $handler->manualAttendance();
            if($status ===1 ){ echo "<p class='text-success text-center'>Attendance succcessfully taken. </p>";}
            else{ echo "<p class='text-danger text-center'><b>{$status}</b></p>"; };
          }
}catch (Error $e){ echo $e->getMessage(); }
        ?>

     <div class="row" style="padding-top:0px">
        <div id="att1" style="margin-left:30px;">
        <video id="preview"></video>
          <form id='attendanceform' method='post' action='' >
          
          <input type='text' hidden name='stid' id = 'codeValue' value="<?php if(isset($_POST['stid'])){ echo $_POST['stid']; } ?>" readonly />
          <input type='text' hidden name = 'latitude'  value="<?php if(isset($_POST['latitude'])){ echo $_POST['latitude']; } ?>" readonly />
          <input type='text' hidden name = 'longitude'   value="<?php if(isset($_POST['longitude'])){ echo $_POST['longitude']; } ?>" readonly />
          </form>
        </div> 

        <div class="col-md-5" style="height: 400px; background-color: rgb(25, 146, 193); margin-left: 10px;" >
          <p style="color: rgb(221, 224, 226); text-align:center; padding-top:5px"> <strong>Not with card? Take attendance manually</strong></p>
          <div class="form_container">
            <form action="" method="post">
              <div>
                <input type="text" name="stid" value="<?php if(isset($_POST['stid'])){ echo $_POST['stid']; } ?>" class="form-control" placeholder="Enter your Student ID Number" />
              </div>
              <div>
                <input type="password" name="password" value="<?php if(isset($_POST['password'])){ echo $_POST['password']; } ?>" class="form-control" placeholder="Enter your Password" />
              </div>
              <div>
                <input type="text" name="cosCode" value="<?php if(isset($_POST['cosCode'])){ echo $_POST['cosCode']; } ?>" class="form-control" placeholder="Course Code" />
              </div>
              <i style='color:white'> Penalty applies </i>
              <div class="btn_box">
                <button name='manual'>  Mark Attendance  </button>
              </div>
            </form>
            
          </div>
          
        </div>

       
        
        <div style='width:100%; margin-left: 30px'>
          <?php 
          $lat  = !empty($_POST['latitude'])?$_POST['latitude']:0;
          $long = !empty($_POST['longitude'])?$_POST['longitude']:0;
          
          $map_url = "https://www.google.com/maps?q={$lat},{$long}&hl=es;z=14&output=embed"; 
          ?>
          <iframe width="100%" height="500px" style="border:0" src="<?php echo $map_url; ?>" allowfullscreen></iframe>
        </div>

      </div>
    </div>
  </section>
  <!-- end book section -->
       <!-- footer section -->
    <footer class="footer_section">
      <div class="container">
        <div class="row">
          <div class="col-md-4 footer-col">
            <div class="footer_contact">
              <h4 style="color: rgb(243, 205, 102)">
                Contact Us
              </h4>
              <div class="contact_link_box">
                <a href="">
                  <i class="fa fa-map-marker" aria-hidden="true"></i>
                  <span>
                    Location
                  </span>
                </a>
                <a href="">
                  <i class="fa fa-phone" aria-hidden="true"></i>
                  <span>
                    Call +44 7393042610
                  </span>
                </a>
                <a href="">
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                  <span>
                    ecu2crt@bolton.ac.uk.com
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-4 footer-col">
            <div class="footer_detail">
              <a href="" class="footer-logo" style="color: rgb(243, 205, 102)">
                UoB, Uk
              </a>
              <p>
                ​The University of Bolton's mission and vission is to be a distinctive, teaching-intensive, 
                research-informed institution recognized for the quality of its staff, facilities, 
                and strong links to employment sectors thereby contributing to a world that 
                maximizes human potential by reducing inequality and 
                protecting the environment through responsible consumption and thoughtful development.
              </p>
              <div class="footer_social">
                <a href="">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-linkedin" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
                <a href="">
                  <i class="fa fa-pinterest" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-4 footer-col">
            <h4 style="color: rgb(243, 205, 102)">
              Programmes we offer
            </h4>
            <p>
             Undergraduate (BSc)
            </p>
            <p>
              Postgraduate (MSc)
            </p>
            <p>
              Postgraduate (MRes)
            </p>
            <p>
              Postgraduate (PhD)
            </p>
          <br/>
            <h4 style="color: rgb(243, 205, 102)">
              Opening Hours
            </h4>
            <p>
             Monday to Friday
            </p>
            <p>
              7.00 Am - 5.00 Pm
            </p>
          </div>
        </div>
        <div class="footer-info">
          <p>
            &copy; <span id="displayYear"></span> All Rights Reserved By
            <a href="index.html">Universityof Bolton UK</a><br><br>
            &copy; <span id="displayYear"></span> Developed By
            <a href="https://themewagon.com/" target="_blank" style="color: rgb(243, 205, 102)">Team-J4-DevOps (Courtesy: Elijah | Ernest | Sopuru | Peter)</a>
          </p>
        </div>
      </div>
    </footer>
    <!-- footer section -->
  </body>
  <script type="text/javascript">
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
     Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          alert('No cameras found.');
        }
      }).catch(function (e) {
        alert(e);
      });
	    scanner.addListener('scan', function (content) {
        document.getElementById('codeValue').value = content;
		document.forms[0].submit();
		
      });
    </script>
  </body>
 <script type='text/javascript' >
 function getGeolocation(){
			 
			 const options = {
						  enableHighAccuracy: true,
						  maximumAge: 0
						};
			 if(navigator.geolocation){
				navigator.geolocation.getCurrentPosition(position=>{
				let lat = position.coords.latitude;
				 let lng = position.coords.longitude;
				 let acc = position.coords.accuracy;
				 
				 let queryQ = queryVals()[0];
				 let queryLt = queryVals()[1];
				 let queryLg = queryVals()[2];
				 let querydf = queryVals()[3];
				 newPosition(lat, lng);
				 let x = "<?php echo $_SESSION['landed'] =''; ?>";
				 if(queryQ != 'attendance' || queryQ == ''  ){
					 if(lat==null || lat==''  || lng == null || lng == '' || lat == 0|| lng == 0 ) {
					 let status = confirm("Sorry! Attendance denied. Turn on your device location and try again.");
					 if((status == true || status == false) && lat !=null && lat !=''  && lng != null && lng != '' ) { alert('Good! Proceed with taking attendance.'); } else { document.location.href="https://bolton.ac.uk";}
					 }
					 
				 }else{
				if(lat==null || lat==''  || lat != queryLt || lng != queryLg || acc != querydf  ) {
					 let status = confirm("Sorry! Attendance denied. Try again.");
					  let tid = "<?php echo @$_SESSION['moved']; ?>";
					 if(status == true || status == false) { document.location.href="https://bolton.ac.uk/?q=attendance&lt="+lat+"&lg="+lng+"&df="+acc+"&tid="+tid; }
				}else{   x = "<?php echo $_SESSION['landed'] = time()+500; ?>";     }    
				 }
				}, newError, options);
			  }
		 }  
		 
				 function     newPosition(lat, lng){
					 document.querySelector('#attendanceform input[name="latitude"]').value = lat;
					 document.querySelector('#attendanceform input[name="longitude"]').value = lng;
				 }
				 function  queryVals(){
				 const params = new Proxy(new URLSearchParams(window.location.search), {
				  get: (searchParams, prop) => searchParams.get(prop),
				});
				let q  = params.q?params.q:0;
				let lt = params.lt?params.lt:0;
				let lg = params.lg?params.lg:0;
				let df = params.df?params.df:0;
				let values = new Array(q, lt, lg,  df);
				return values;
				}
		 function newError(error){
		   
			 switch(error.code){
			   case error.PERMISSION_DENIED: {
				   let state = confirm('Ensure you enabled your device location.');
				   if(state == null) { setInterval(location.reload(), 60000); }
				   if(state == true) { 
				   alert("You will be logged out in 5 seconds if your device location is not enabled."); 
				   setTimeout(location.href='https://bolton.ac.uk', 5000); 
				   }
				   if(state == false) { setInterval(location.reload(), 30000); }
				  break;
			   }
			 }
			 
		 }
		 
function mapReader(){
	alert('la');
}
 </script>
  </html>
