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
          
            // profile dropdown here
            require("show_listdropdown.php"); 

          ?>

        
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

                 <li class="nav-item active">
                   <a href="online_consultation.php" class="nav-link"><i class="fas fa-notes-medical"></i><span>Virtual Consultation</span></a>
               </li>

                 <li class="nav-item">
                   <a href="medical_history.php" class="nav-link"><i class="fas fa-pen"></i><span>Medical History</span></a>
                </li>

          </ul>
        </div>
      </nav>
        <!-- Main Content -->
      <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1>Virtual Consultation</h1>
            </div>

   
        <div class="section-body">
            <div class="card">
              <div class="card-header">
                 <h4></h4>
                  <div class="card-header-action">
                  </div>
              </div>

            <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered" id="table-subject">
                        <thead class="thead-light">
                          <tr class="text-center">
                            <th>Assigned Doctor</th>
                            <th>Virtual Consultation Link</th>
                            <th>Platform</th>
                            <th>Date</th>
                            <th>Time</th>
                          </tr>
                        </thead>
                        <tbody>

                      <?php 

                      $sql = "SELECT 
                      d.user_id as doctor_id,
                      d.user_account_id as doctor_account,
                      d.user_firstname  as doc_fname, 
                      d.user_middlename as doc_mname, 
                      d.user_lastname   as doc_lname,
                      p.user_firstname  as patient_fname,
                      p.user_middlename as patient_mname,
                      p.user_lastname   as patient_lname,
                      p.user_account_id as patient_account,
                      p.user_id as patient_id,
                      a.appointment_id as appointment_id,
                      vc.virtual_consultation_link as consultation_link,
                      vc.virtual_consultation_type as consultation_type,
                      vc.virtual_consultation_date as consultation_date,
                      vc.virtual_consultation_start_time as consultation_stime,
                      vc.virtual_consultation_end_time as consultation_etime,
                      vc.virtual_consultation_status as consultation_status,
                      vc.virtual_consultation_bool as consultation_bool
                      FROM virtual_consultation vc
                      JOIN user d 
                      ON vc.virtual_consultation_doctor_id = d.user_id 
                      JOIN user p 
                      ON vc.virtual_consultation_user_id = p.user_id 
                      JOIN appointment a 
                      ON vc.virtual_consultation_appointment_id = a.appointment_id
                      WHERE p.user_id = '$patient_id'
                      ";
                      $result = mysqli_query($connection,$sql);

                      
                      while($row = mysqli_fetch_assoc($result)) {

                      // doctor fullname
                      $doc_account      = $row['doctor_account'];
                      $doc_firstname    = ucfirst($row['doc_fname']);
                      $doc_middlename   = ucfirst($row['doc_mname']);
                      $doc_lastname     = ucfirst($row['doc_lname']);

                      $doc_name = $doc_firstname.' '.$doc_middlename.'.'.' '.$doc_lastname;

                      // user patient fullname
                      $patient_account      = $row['patient_account'];
                      $patient_firstname    = ucfirst($row['patient_fname']);
                      $patient_middlename   = ucfirst($row['patient_mname']);
                      $patient_lastname     = ucfirst($row['patient_lname']);

                      $patient_name = $patient_firstname.' '.$patient_middlename.'.'.' '.$patient_lastname;

                      // format date and time
                      $date = $row['consultation_date'];
                      $format_start = date("h:i:A", strtotime($row['consultation_stime']));
                      $format_end   = date("h:i:A", strtotime($row['consultation_etime']));


                        //
                        $consultation_link = $row['consultation_link'];
                        $consultation_platform = $row['consultation_type'];

                        if($consultation_platform == "google-meet") {
                          $platform = "Google Meet";
                        } else if($consultation_platform == "zoom") {
                          $platform = "Zoom";
                        }

                      ?>

                        <tr>
                          <td><?php echo $doc_name ?></td>
                          <td><a href="<?php echo $consultation_link ?>" target="_blank"><?php echo $consultation_link ?></a></td>
                          <td><?php echo $platform ?></td>
                          <td><?php echo $date ?></td>
                          <td><?php echo $format_start ?> - <?php echo $format_end ?></td>
                         
                         </tr>
                      
                      <?php } ?>

                        </tbody>
                      </table>
                    </div>
                  </div>


              <div class="card-footer bg-whitesmoke"> </div>
            </div>
          </div>
         </section>
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