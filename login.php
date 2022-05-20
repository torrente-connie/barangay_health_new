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
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/bh-logo-2.png" alt="logo" class="img-fluid w-100" style="">
            </div>

            <div class="card card-primary" style="border-top: 0;">
             <div class="card-header">  
                <h4 style="font-size:28px;color:#6c757d">Login</h4>
                <div class="card-header-action">
                    <a href="home_page.php" class="text-small">Return to home</a>
                  </div>
              </div>
              <div class="card-body">
                <!-- <form method="POST" action="#" class="needs-validation" novalidate="">
                 -->   
                <form method="POST" action="backend/login.php">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required="" autofocus="">
                    <!-- <div class="invalid-feedback">
                      Please fill in your email
                    </div> -->
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    <!--   <div class="float-right">
                        <a href="forgot_password.php" class="text-small">
                          Forgot Password?
                        </a>
                      </div> -->
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required="">
                    <!-- <div class="invalid-feedback">
                      please fill in your password
                    </div> -->
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                      Don't have an account? 
                      <a href="create_account.php">
                          Create One
                        </a>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" name="login" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
               <!--   <div class="row sm-gutters">
                
                  <div class="col-6">
                    <a class="btn btn-block btn-lg btn-social btn-google">
                      <span class="fab fa-google"></span> Google
                    </a>                   
                  </div>

                    <div class="col-6">
                    <a class="btn btn-block btn-lg btn-social btn-facebook">
                      <span class="fab fa-facebook"></span> Facebook
                    </a>
                  </div>
                </div> -->
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>  
  
<?php 

// all footer scripts can be found here
require('scripts_footer.php');

?>

