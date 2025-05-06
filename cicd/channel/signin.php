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

</head>

<body>

  <div class="hero_area" style="background-image:url('../images/enviro4.jpeg'); background-repeat: no-repeat; background-size: cover;">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="../index.html">
            <div class="sm-box">
              <img src="../images/logo.png" alt="">
            </div>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item active">
                <a class="nav-link" href="../index.html">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../menu.html">Staff/ Admin</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../contact.html">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../book.html">Contact</a>
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
              <form class="form-inline">
                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
              <a href="../enrolStudent.html" class="order_online">
                Enrol
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
<!-- end header section -->
<?php
     include_once('qrcodeManager.php');
       $handler = new QRCodeManager();
       if(isset($_POST['signin'])){
       $status = $handler->staffSignIn();
       if($status ===1 ){ echo "<p class='text-success text-center'>Sign In is successful. </p>";}
       else{ echo "<p class='text-danger text-center'><b>{$status}</b></p>"; }
       
     }
?>
<!-- book section -->
<section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
            Signin as a Staff
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="signin.php" method="post">
              <div>
                <input type="text" name="stfid" class="form-control" placeholder="Enter Staff ID or Email" value="<?php if(isset($_POST['stfid'])){ echo $_POST['stfid']; } ?>" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Enter your Password" />
              </div>
              <div class="btn_box">
                <button name='signin'>
                 Sign In
                </button>
                <p style="color: #fff">
                  Don't have account yet? Click <a href="enrolStudent.php" style="color: rgb(243, 205, 102)">here</a> to Register
                  </p>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
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

</html>