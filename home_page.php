<?php 
  
  require("scripts_header.php");

  // db connection
  require("backend/dbconn.php");
  $connection = dbConn();
  
?>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg" style="background-color:rgba(40, 102, 199, 0.97)"></div>
      <nav class="navbar navbar-expand-lg main-navbar" style="background-color:rgba(40, 102, 199, 0.97)">
        <a href="home_page.php" class="navbar-brand sidebar-gone-hide text-capitalize"><img class="sidebar-gone-hide" src="assets/img/bh-logo-2.png">
        </a>
        <img class="sidebar-gone-hide rounded-circle" src="assets/img/liloan-logo-2.png" style="height: 85px; width: 90px; padding:10px;">
        <div class="navbar-nav">
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
         </div>
      
       <form class="form-inline ml-auto">
          <ul class="navbar-nav">
            <!-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> -->
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">

           <?php 
          
            // profile dropdown here
            require("show_listdropdown.php"); 

          ?>

        
        </ul>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">

            <li class="nav-item">
              <a href="home_schedules.php" class="nav-link"><i class="fas fa-clock"></i><span>Schedules</span></a>
            </li>
           
            <li class="nav-item">
              <a href="home_appointments.php" class="nav-link"><i class="fas fa-calendar-check"></i><span>Appointments</span></a>
            </li>


          </ul>
        </div>
      </nav>

        <!-- Main Content -->
      <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1 class="text-center">Welcome to BrgyHealth: Barangay Health Center Appointment, Scheduling and Online Consultation System</h1>
            </div>

   
         <div class="section-body">
            <div class="card card-secondary">
              <div class="card-header">
                <h4></h4>
              </div>

                <div class="card-body">
                  <div class="row">
                  <div class="col-lg-6">
                    <div class="owl-carousel">
                          <div>
                            <img class="single-item rounded-circle" src="assets/img/liloan-logo-2.png">
                          </div>
                         <!--   <div>
                          <img class="single-item rounded-circle" src="assets/img/liloan-logo-2.png">
                          </div> -->
                        </div>
                    </div>
                  
                  <div class="col-lg-6">
                      <p class="lead text-justify"><strong>San Vicente</strong> is a barangay in the municipality of Liloan, in the province of Cebu. The BrgyHealth: Barangay Health Center Appointment, Scheduling and Online Consultation System can help provide the Barangay San Vincente Liloan. An easier way to book an appointment, set schedules and to have online consultation for the residents living in the barangay.</p>

                      <div class="">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3924.284168383133!2d123.97116955054143!3d10.3989900688534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9a2d36113ca67%3A0x1a661f56d2c041b9!2sSan%20Vicente%20Barangay%20Hall!5e0!3m2!1sen!2sph!4v1633616800174!5m2!1sen!2sph"  style="border:0;width: 100%;height: 250px;" allowfullscreen loading="lazy"></iframe>
                      </div>

                  </div>
                </div>


              <div class="card-footer bg-whitesmoke"> </div>
            </div>

            </div>
          </div>

     <div class="section-body">
      <div class="card card-primary">
          <div class="card-header">
                <h4 style="font-size:24px;"> Process for booking an appointment: </h4>
              </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <div class="section-body">
            <div class="card card-primary">
              <div class="card-header">
                <h4><i class="fa fa-users"></i> STEP 1</h4>
              </div>
                <div class="card-body">
                        <h4 class="mt-0">Register an account</h4>
                        
                  </div>
                    <div class="card-footer bg-whitesmoke"> </div>
                  </div>
                </div>
              </div>

       <div class="col-lg-3">
          <div class="section-body">
            <div class="card card-primary">
              <div class="card-header">
                <h4><i class="fa fa-users"></i> STEP 2</h4>
              </div>
                <div class="card-body">
                        <h4 class="mt-0">Book an appointment</h4>
                  </div>
                    <div class="card-footer bg-whitesmoke"> </div>
                  </div>
                </div>
              </div>

        <div class="col-lg-3">
          <div class="section-body">
            <div class="card card-primary">
              <div class="card-header">
                <h4><i class="fa fa-users"></i> STEP 3</h4>
              </div>
                <div class="card-body">
                        <h4 class="mt-0">Choose a medical service</h4>
                  </div>
                    <div class="card-footer bg-whitesmoke"> </div>
                  </div>
                </div>
              </div>

        <div class="col-lg-3">
          <div class="section-body">
            <div class="card card-primary">
              <div class="card-header">
                <h4><i class="fa fa-users"></i> STEP 4</h4>
              </div>
                <div class="card-body">
                        <h4 class="mt-0">Print appointment schedule</h4>
                  </div>
                    <div class="card-footer bg-whitesmoke"> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            
            </div>
         </section>
      </div>
    </div>
  
      <footer class="main-footer" style="background-color:rgba(40, 102, 199, 0.97)">
        <div class="container">
        <div class="footer-left text-white">
          © 2021 BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System
        </div> 
      </div>
      </footer>

    </div>


   <!-- Menu for Footer Links -->
    <?php require("scripts_footer.php"); ?>
    <!-- -->

<script>
  $(document).ready(function(){
   $('.owl-carousel').owlCarousel({
      loop:false,
      items: 1,
      margin: 10,
      singleItem: true
   })
  });
</script>