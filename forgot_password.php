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
                <h4 style="font-size:24px;color:#6c757d">Forgot Password</h4>
                <div class="card-header-action">
                    <a href="home_page.php" class="text-small">Return to home</a>
                  </div>
              </div>

              <div class="card-body">
                <p class="text-muted">We will send a link to reset your password
                 </p>
                <form method="POST">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Submit
                    </button>
                    <a href="login.php" class="btn btn-danger btn-lg btn-block" tabindex="4">
                      Cancel
                    </a>
                  </div>
                </form>
              </div>
              <div class="form-group">
              <div class="text-small text-center">
                 (Note: Only email that are register inside the system)
              </div>
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
