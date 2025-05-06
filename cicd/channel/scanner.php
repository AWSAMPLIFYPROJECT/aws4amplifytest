<!DOCTYPE html>
<html>
  <head>
    <title>Instascan</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  </head>
  <body onload='getGeolocation();'>
    <video id="preview"></video>
	<p id='qrcodeID'>QR Code</p>
	<form id='attendanceform' method='post'>
	<input type='text' id = 'codeValue'disabled />
	<input type='text' name = 'longitude'disabled />
	<input type='text' name = 'latitude'disabled />
	</form>
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
 </script>
</html>