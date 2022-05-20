<?php 
  
  // session info here
  session_start();

  $doctor_id = $_SESSION['doctor_id']; // get session doctor id
  $doctor_fullname = $_SESSION['doctor_fullname']; // get session doctor fullname
  $doctor_image = $_SESSION['doctor_image'];

  if($_SESSION['doctor_image'] == '') {
    $doctor_image = "../../assets/img/avatar/avatar-1.png";
  } else {
    $doctor_image = $doctor_image;
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
                  <span>Manage Appointments</span>
                </a>
                  <ul class="dropdown-menu" style="display: none;">
                      <li class="nav-item"><a href="appointments_book.php" class="nav-link" style="padding-right:0 !important"> <span>Face to Face Appointment</span> </a></li>
                      <li class="nav-item"><a href="appointments_oc.php" class="nav-link"> <span>Virtual Consultation</span> </a></li>
                     </ul>
                </li>

              <li class="nav-item">
                   <a href="online_consultation.php" class="nav-link"><i class="fas fa-notes-medical"></i><span>Virtual Consultation</span></a>
               </li>

            <li class="nav-item active">
              <a href="patients.php" class="nav-link"><i class="fas fa-user-friends"></i><span>Manage Patients</span></a>
            </li>

            <li class="nav-item">
              <a href="schedules.php" class="nav-link"><i class="fas fa-clock"></i><span>Schedules</span></a>
            </li>

          </ul>
        </div>
      </nav>


        <!-- Main Content -->
      <div class="main-content" style="min-height: 566px;">
        <section class="section">
          <div class="section-header">
            <h1>List of patients <!-- - <?php //echo date('Y-m-d'); ?> --></h1>
            </div>

   
        <div class="section-body">
            <div class="card">
              <div class="card-header">
                 <h4>Current Appointment Patient</h4>
                  <div class="card-header-action">
                   <!--  <a href="class_add.php" class="btn btn-success btn-sm">Add Class</a> -->
                  </div>
              </div>
 
                  <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="table-subject">
                        <thead class="thead-light">
                          <tr class="text-center">
                            <th>Booked By</th>
                            <th>Assigned Patient</th>
                            <th>Medical Service</th>
                            <th>Appointment Type</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Medical Description</th>
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
                      pl.patient_list_pfname as plist_pfname,
                      pl.patient_list_pmname as plist_pmname,
                      pl.patient_list_plname as plist_plname,
                      pl.patient_list_id as plist_id,
                      pl.patient_list_appointment_type as plist_atype,
                      pl.patient_list_medical_Service as plist_mservice,
                      pl.patient_list_date as plist_date,
                      pl.patient_list_stime as plist_stime,
                      pl.patient_list_etime as plist_etime,
                      pl.patient_list_status as plist_status,
                      pl.patient_list_bool as plist_bool
                      FROM patient_list pl 
                      LEFT JOIN user p 
                      ON pl.patient_list_user_id = p.user_id 
                      JOIN user d 
                      ON pl.patient_list_doctor_id = d.user_id
                      JOIN appointment a 
                      ON pl.patient_list_appointment_id = a.appointment_id
                      WHERE d.user_id = '$doctor_id' AND pl.patient_list_status = 1
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
                      $patient_id           = $row['patient_id'];
                      $book_patient_account      = $row['patient_account'];
                      $book_patient_firstname    = ucfirst($row['patient_fname']);
                      $book_patient_middlename   = ucfirst($row['patient_mname']);
                      $book_patient_lastname     = ucfirst($row['patient_lname']);

                      $book_patient_name = $book_patient_firstname.' '.$book_patient_middlename.'.'.' '.$book_patient_lastname;

                      // user patient fullname
                      $plist_firstname    = ucfirst($row['plist_pfname']);
                      $plist_middlename   = ucfirst($row['plist_pmname']);
                      $plist_lastname     = ucfirst($row['plist_plname']);

                      $plist_name = $plist_firstname.' '.$plist_middlename.'.'.' '.$plist_lastname;



                      // format date and time
                      $date = $row['plist_date'];
                      $format_start = date("h:i:A", strtotime($row['plist_stime']));
                      $format_end   = date("h:i:A", strtotime($row['plist_etime']));


                        //
                        $plist_id = $row['plist_id'];
                        $plist_mservice = $row['plist_mservice'];
                        $plist_atype = $row['plist_atype'];

                        if($plist_atype == "bookappointment") {
                          $atype = "Face to Face Appointment";
                        } else if($plist_atype == "onlineappointment") {
                          $atype = "Virtual Consultation";
                        } else if($plist_atype = "walkinappointment") {
                          $atype = "Walk-In Appointment";
                        }

                      ?>

                        <tr>

                          <td>
                            <?php if($patient_id == 0) { ?>
                              No Account
                            <?php } else { echo $book_patient_name  ?>
                              
                            <?php } ?>
                          </td>
                          
                          <td><?php echo $plist_name ?></td>
                          <td><?php echo $plist_mservice ?></td>
                          <td><?php echo $atype ?></td>
                          <td><?php echo $date ?></td>
                          <td><?php echo $format_start ?> - <?php echo $format_end ?></td>
                          <td>
                            <a href="patients_add_description.php?plid=<?php echo $plist_id ?>" class="btn btn-primary btn-sm btn-block"> Add </a> 
                          </td>
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