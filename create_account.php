<?php 

// all header scripts can be found here
require('scripts_header.php');

?>

<!-- Header - CSS -->
<body>
  <div id="app">
   <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="assets/img/bh-logo-2.png" alt="logo" class="img-fluid w-50" style="">
            </div>

            <div class="card card-primary" style="border-top: 0;">
              <div class="card-header">  
                <h4 style="font-size:28px;color:#6c757d">Register</h4>
                <div class="card-header-action">
                    <a href="home_page.php" class="text-small">Return to home</a>
                  </div>
              </div>

              <div class="card-body">
                <form method="POST" action="backend/user_registration.php">
                  <div class="row">
                    <div class="form-group col-4">
                      <label for="first_name">First Name</label>
                      <input id="first_name" type="text" class="form-control" name="first_name" autofocus>
                    </div>
                    <div class="form-group col-4">
                      <label for="middle_name">Middle Name</label>
                      <input id="middle_name" type="text" class="form-control" name="middle_name">
                    </div>
                    <div class="form-group col-4">
                      <label for="last_name">Last Name</label>
                      <input id="last_name" type="text" class="form-control" name="last_name">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email">
                    <div class="invalid-feedback">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control pwstrength" data-indicator="password2" name="password">
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Confirm Password</label>
                      <input id="password2" type="password" class="form-control" name="password-confirm">
                    </div>
                  </div>

              <!--     <div class="form-divider">
                    Your Home
                  </div>
               -->    
            
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree" required>
                      <label class="custom-control-label" for="agree">I agree with the terms and conditions</label> <a href="#" data-toggle="modal" data-target="#bookAppointment" data-backdrop="static"> Click here to view the terms and conditions 
                      </a>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="registerUser">
                      Register
                    </button>
                    <a href="login.php"class="btn btn-danger btn-lg btn-block">
                      Cancel
                    </a>
                  </div>
                </form>
              </div>
            </div>
            </div>
        </div>
      </div>
    </section>  
  </div>  

  <!-- Modals -->

  <!-- Add Subject Modal -->
         <!-- <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal" data-backdrop="static" data-keyboard="false"> -->
        <div class="modal fade" tabindex="-1" role="dialog" id="bookAppointment">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Terms & Conditions</h5>
              </div>
        <div class="card-body">
                  <div class="form-group">
                    <hr>
                    <div class="d-block">
                      <p class="lead text-normal">
                       <span style="font-weight: bold;color:black"> The BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System </span> allocates slots on a first come, first served basis.
                      </p>                   

 <p class="lead text-justify">
  <span style="font-weight: bold;color:black"> I agree to accept the responsibility for supplying, checking, and verifying the accuracy and correctness of the information </span> the information provided on this system.
</p>

<p class="lead text-justify" >
  I agree to share my personal data with the Barangay San Vincente Health Clinic in order to facilitate the scheduling of the service I have selected. <span style="font-weight: bold;color:black"> The Barangay San Vincente Health Clinic upholds Republic Act No. 10173 (Data Privacy Act of 2012) in processing patient data. </span>
</p>
                    </div>
                    <hr>
                  </div>

                  <div class="form-group">
                    <button data-dismiss="modal" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Proceed to Register Account
                    </button>
                  </div>
              </div>
            </div>
          </div>
        </div>

  
<?php 

// all footer scripts can be found here
require('scripts_footer.php');

?>


