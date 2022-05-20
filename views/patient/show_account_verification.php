<?php 
  
  // session info here
  session_start();

  $patient_id = $_SESSION['patient_id']; // get session admin id
  $patient_fullname = $_SESSION['patient_fullname']; // get session admin fullname
  $patient_image = $_SESSION['patient_image'];

   if($_SESSION['patient_image'] == '') {
    $patient_image = "../../assets/img/avatar/avatar-1.png";
  } else {
    $patient_image = $patient_image;
  }

  // header links here
  require("scripts_header.php");

  // db connection
  require("../../backend/dbconn.php");
  $connection = dbConn();

  $displayCurrentUserInfo = "SELECT * FROM user WHERE user_type = 'Patient' AND user_id = '$patient_id'";
  $resultDisplay = mysqli_query($connection,$displayCurrentUserInfo);


  while($rowDisplay = mysqli_fetch_assoc($resultDisplay)) {
      $account_id     = $rowDisplay['user_account_id'];
      $account_type   = $rowDisplay['user_type'];
      $account_email  = $rowDisplay['user_email'];
      $account_phone  = $rowDisplay['user_cnum'];
      $account_dob    = $rowDisplay['user_dob'];
      $account_status = $rowDisplay['user_account_status'];

       if($rowDisplay['user_image'] == '') {
             $account_profile = "../../assets/img/avatar/avatar-1.png";
           } else {
             $account_profile = $rowDisplay['user_image'];
         }

      // user full name
      $firstname    = ucfirst($rowDisplay['user_firstname']);
      $middlename   = ucfirst($rowDisplay['user_middlename']);
      $lastname     = ucfirst($rowDisplay['user_lastname']);

      $fullname = $firstname.' '.$middlename.'.'.' '.$lastname;
  }
  
?>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg" style="background-color:rgba(40, 102, 199, 0.97)"></div>
      <nav class="navbar navbar-expand-lg main-navbar" style="background-color:rgba(40, 102, 199, 0.97)">
        <a href="dashboard.php" class="navbar-brand sidebar-gone-hide text-capitalize"><img class="sidebar-gone-hide" src="../../assets/img/bh-logo-2.png">
        </a>
        <img class="sidebar-gone-hide rounded-circle" src="../../assets/img/liloan-logo-2.png" style="height: 85px; width: 90px; padding:10px;">
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

            // notification here
            require("show_notification.php");
          
          ?>

          <!-- profile here -->
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../<?php echo $patient_image ?>" class="rounded-circle mr-1" style="width:30px;height:30px;">
            <div class="d-sm-none d-lg-inline-block text-capitalize">Hi, <?php echo $patient_fullname; ?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="../../home_page.php" class="dropdown-item has-icon"><i class="fas fa-arrow-left"></i> Homepage </a>
              <a class="dropdown-item has-icon" href="show_changepassword.php" style="cursor: pointer">
                <i class="fas fa-unlock"></i> Change Password
              </a>
              <a class="dropdown-item active has-icon" href="show_profile.php" style="cursor: pointer">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="../../logout.php" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>

        
        </ul>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">

            <li class="nav-item">
              <a href="dashboard.php" class="nav-link"><i class="fas fa-columns"></i><span>Dashboard</span></a>
            </li>

             <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-calendar-check"></i>
                  <span>Appointments</span>
                </a>
                  <ul class="dropdown-menu" style="display: none;">
                      <li class="nav-item"><a href="appointments_book.php" class="nav-link" style="padding-right:0 !important"> <span>Face to Face Appointment</span> </a></li>
                      <li class="nav-item"><a href="appointments_oc.php" class="nav-link"> <span>Virtual Consultation</span> </a></li>
                    </ul>
                </li>

                 <li class="nav-item">
                   <a href="online_consultation.php" class="nav-link"><i class="fas fa-notes-medical"></i><span>Virtual Consultation</span></a>
               </li>

                 <li class="nav-item">
                   <a href="medical_history.php" class="nav-link"><i class="fas fa-pen"></i><span>Medical History</span></a>
                </li>

          </ul>
        </div>
      </nav>

    <?php 

    if(isset($_GET['verify']) == 'yes' ) {

      $conn = dbConn();

      $patientID = $_GET['user_id'];

      $getPatient = "SELECT * FROM user WHERE user_type = 'Patient' AND user_id = '$patientID' ";
      $resultGetPatient = mysqli_query($conn,$getPatient);
      $rowGetPatient = mysqli_fetch_assoc($resultGetPatient);

      $patientEMAIL = $rowGetPatient['user_email'];
      $patientCODE = $rowGetPatient['user_account_code'];

      sendEmailNotification($patientID,$patientEMAIL,$patientCODE);
    }

    function sendEmailNotification($patientId,$patientEmail,$verifyCode) {

       require   '../../assets/mailer/PHPMailerAutoload.php';
       require '../../assets/mailer/credential.php';

       $email = $patientEmail;
       $getCode = $verifyCode;

       // $email = "louisadolfo08@gmail.com";
       //$email = "louisadolfo08@gmail.com";

          // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer;

      //$mail->SMTPDebug = 1;

      $mail->SMTPDebug = 0;

      // new
      $mail->Mailer = "smtp";
      $mail->SMTPOptions = array(
      'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      )
      );
                                                            // Send using SMTP
      $mail->IsSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = EMAIL;                              // SMTP username
      $mail->Password = PASS;                               // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      //$mail->Port = 587 / 465 / 25;  
      $mail->Port = 587;   
                                                // TCP port to connect to

      //Recipients
      $mail->setFrom(EMAIL, 'ACCOUNT VERIFICATION FOR BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System');
      $mail->addAddress($email);     // Add a recipient
      $mail->addReplyTo(EMAIL);
   
      // Content
      $mail->isHTML(true);   
      // Set email format to HTML

     // if($_GET['studentID'] == '$id') {
     //   $url = "http://" . $_SERVER['HTTP_POST'] . "localhost/mca_new_db/reset_password.php?email=$email&SID=$id";
     //  }

     // if($_GET['teacherID'] == '$id') {
     //    $url = "http://" . $_SERVER['HTTP_POST'] . "localhost/mca_new_db/reset_password.php?email=$email&TID=$id";
     // }

      date_default_timezone_set('Asia/Manila');
      $get_date = date('Y/m/d');

      $mail->Subject = 'Here is your verification code';
      $mail->Body    = "Verification Code:". $getCode."";
   
      if(!$mail->send()) {
              echo 'Message could not be sent.';
              echo 'Mailer Error: ' . $mail->ErrorInfo;
          } else {
              $str = 'The Verification Code Has Been Sent';
              //header("location:dashboard.php?success=".$str);
          }
    } 

    
    ?>

    <!-- Main Content -->
       <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1>Account Verification</h1>
          </div>
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-9">
                <div class="card">
                  <form action="../../backend/patient_account_verification.php" method="POST">
                    <div class="card-header">
                      <h4>Verify Account</h4>
                    </div>
                    <div class="card-body">

                        <input type="hidden" name="patient_id" value="<?php echo $patient_id ?>">

                        <h2 class="lead">Please check your email address for the verification code.</h2>
                          
                        <div class="row">
                          <div class="form-group col-md-7 col-12">
                            <label>Verification Code</label>
                            <input type="text" class="form-control" name="verification_code">
                          </div>
                        </div>
                       </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary" type="submit" name="accountVerification">Submit</button>
                      <a href="dashboard.php"  class="btn btn-danger text-white">Cancel</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

     
        </section>
      </div>




    </div>




    </div>


    
  
      <!-- <footer class="main-footer" style="background-color:rgba(40, 102, 199, 0.97)">
        <div class="container">
        <div class="footer-left text-white">
          © 2021 BRGYHEALTH: Barangay Health Center Appointment, Scheduling and Online Consultation System
        </div> 
      </div>
      </footer> -->

    </div>


   <!-- Menu for Footer Links -->
    <?php require("scripts_footer.php"); ?>
    <!-- -->


  </body>
</html>