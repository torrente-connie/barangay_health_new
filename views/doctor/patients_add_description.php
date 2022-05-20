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


  $patient_list_id = $_GET['plid'];

  $query = "SELECT 
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
       WHERE pl.patient_list_id = '$patient_list_id'
       ";

  $resultQuery = mysqli_query($connection,$query);

  while($rowQuery = mysqli_fetch_assoc($resultQuery)) {

    $plist_id = $rowQuery['plist_id'];
    $plist_doctor_id = $rowQuery['doctor_id'];
    $plist_user_id = $rowQuery['patient_id'];
    $plist_appointment_id = $rowQuery['appointment_id'];

    // book patient
    $booked_account      = $rowQuery['doctor_account'];
    $booked_firstname    = ucfirst($rowQuery['patient_fname']);
    $booked_middlename   = ucfirst($rowQuery['patient_mname']);
    $booked_lastname     = ucfirst($rowQuery['patient_lname']);

    $booked_name = $booked_firstname.' '.$booked_middlename.'.'.' '.$booked_lastname;


    // doctor fullname
    $doc_account      = $rowQuery['doctor_account'];
    $doc_firstname    = ucfirst($rowQuery['doc_fname']);
    $doc_middlename   = ucfirst($rowQuery['doc_mname']);
    $doc_lastname     = ucfirst($rowQuery['doc_lname']);

    $doc_name = $doc_firstname.' '.$doc_middlename.'.'.' '.$doc_lastname;

    // user patient fullname
    $plist_firstname    = ucfirst($rowQuery['plist_pfname']);
    $plist_middlename   = ucfirst($rowQuery['plist_pmname']);
    $plist_lastname     = ucfirst($rowQuery['plist_plname']);

    $plist_name = $plist_firstname.' '.$plist_middlename.'.'.' '.$plist_lastname;

    // format date and time
    $date = $rowQuery['plist_date'];
    $start_time = $rowQuery['plist_stime'];
    $end_time = $rowQuery['plist_etime'];
    $format_start = date("h:i:A", strtotime($start_time));
    $format_end   = date("h:i:A", strtotime($end_time));


    //
    $plist_id = $rowQuery['plist_id'];
    $plist_mservice = $rowQuery['plist_mservice'];
    $plist_atype = $rowQuery['plist_atype'];

    if($plist_atype == "bookappointment") {
        $atype = "Face to Face Appointment";
    } else if($plist_atype == "onlineappointment") {
        $atype = "Virtual Consultation";
    } else if($plist_atype = "walkinappointment" AND $plist_user_id == 0) {
        $atype = "Walk-In Appointment Without Account";
    } else if($plist_atype = "walkinappointment" AND $plist_user_id != 0) {
        $atype = "Walk-In Appointment With Account";   
    }

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
            <h1>Add Patient Medical Description <!-- - <?php //echo date('Y-m-d'); ?> --></h1>
            </div>

           <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                   <div class="card-header">
                    <h4>Appointment Details</h4>
                     <!--  <div class="card-header-action">
                    <a href="accounts_doctor.php" class="btn btn-danger btn-sm">Return</a>
                  </div> -->
                  </div>

                
                    <div class="card-body">
                        <div class="row">
                          <div class="form-group col-md-4 col-12">
                            <label>Booked By</label>

                          <?php if($plist_user_id == 0) { ?>
                            <input type="text" class="form-control" value="No Account" readonly>
                          <?php } else { ?>
                            <input type="text" class="form-control" value="<?php echo $booked_name ?>" readonly>
                          <?php } ?>
                          </div>

                           <div class="form-group col-md-4 col-12">
                            <label>Appointment Type</label>
                            <input type="text" class="form-control" value="<?php echo $atype ?>" readonly>
                          </div>

                           <div class="form-group col-md-4 col-12">
                            <label>Medical Service</label>
                            <input type="text" class="form-control" value="<?php echo $plist_mservice ?>" readonly>
                          </div>

                        </div>
                         <div class="row">
                          <div class="form-group col-md-4 col-12">
                            <label>Appointment Date</label>
                            <input text class="form-control" value="<?php echo $date ?>" readonly>
                          </div>
                          <div class="form-group col-md-4 col-12">
                            <label>Appointment Time</label>
                            <input text class="form-control" value="<?php echo $format_start ?> - <?php echo $format_end ?>" readonly>
                          </div>
                        </div>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>

   
           <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <form method="POST" action="../../backend/doctor_medical_history.php">
                   <div class="card-header">
                    <h4>Patient Information</h4>
                 <!--  <div class="card-header-action">
                    <a href="accounts_doctor.php" class="btn btn-danger btn-sm">Return</a>
                  </div> -->
                  </div>

                    <!-- -->
                    <input type="hidden" name="plist_id" value="<?php echo $plist_id ?>">
                    <input type="hidden" name="plist_user_id" value="<?php echo $plist_user_id ?>">
                    <input type="hidden" name="plist_doctor_id" value="<?php echo $plist_doctor_id ?>">
                    <input type="hidden" name="plist_appointment_id" value="<?php echo $plist_appointment_id ?>">
                    <input type="hidden" name="plist_firstname" value="<?php echo $plist_firstname ?>">
                    <input type="hidden" name="plist_middlename" value="<?php echo $plist_middlename ?>">
                    <input type="hidden" name="plist_lastname" value="<?php echo $plist_lastname ?>">
                    <input type="hidden" name="plist_atype" value="<?php echo $plist_atype ?>">
                    <input type="hidden" name="plist_mservice" value="<?php echo $plist_mservice ?>">
                    <input type="hidden" name="plist_date" value="<?php echo $date ?>">
                    <input type="hidden" name="plist_stime" value="<?php echo $start_time ?>">
                    <input type="hidden" name="plist_etime" value="<?php echo $end_time ?>">

                    
                    <div class="card-body">
                        <div class="row">

                          <div class="form-group col-md-3 col-12">
                            <label>Patient Fullname</label>
                            <input type="text" class="form-control" value="<?php echo $plist_name ?>" readonly>
                          </div>

                           <div class="form-group col-md-3 col-12">
                            <label>Patient Age</label>
                            <input type="text" class="form-control" placeholder="Enter Patient Age" name="patient_age" required>
                          </div>

                          <div class="form-group col-md-3 col-12">
                            <label>Patient Allergy</label>
                            <input type="text" class="form-control" placeholder="Enter Patient Allergy" name="patient_allergy" required>
                          </div>

                           <div class="form-group col-md-3 col-12">
                            <label>Patient Symptoms</label>
                            <input type="text" class="form-control" placeholder="Enter Patient Symptoms" name="patient_symptoms" required>
                          </div>

                        </div>
                         <div class="row">
                          <div class="form-group col-md-3 col-12">
                            <label>Patient Temperature</label>
                            <input type="text" class="form-control" placeholder="Enter Patient Temperature" name="patient_temperature" required>
                          </div>
                           <div class="form-group col-md-3 col-12">
                            <label>Patient Heart Rate</label>
                            <input type="text" class="form-control" placeholder="Enter Patient Heart Rate" name="patient_hr" required>
                          </div>
                           <div class="form-group col-md-3 col-12">
                            <label>Patient Blood Pressure</label>
                            <input type="text" class="form-control" placeholder="Enter Blood Pressure" name="patient_bp" required>
                          </div>
                           <div class="form-group col-md-3 col-12">
                            <label>Patient Pulse Rate</label>
                            <input type="text" class="form-control" placeholder="Enter Pulse Rate" name="patient_pr" required>
                          </div>
                        </div>
                         <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>Comments</label>
                            <textarea class="form-control" name="patient_comments" style="height:150px" placeholder="Enter Comments.." required></textarea>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Prescription</label>
                            <textarea class="form-control" name="patient_prescription" style="height:150px" placeholder="Enter Prescription.."></textarea>
                          </div>
                        </div>

                    </div>
                    <div class="card-footer text-left">
                      <button type="submit" class="btn btn-primary" name="addPatientMedicalDescription">Submit</button>
                      <a href="patients.php" class="btn btn-danger">Cancel</a>
                    </div>
                  </form>
                </div>
              </div>
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