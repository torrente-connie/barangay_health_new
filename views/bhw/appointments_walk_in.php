<?php 
  
  // session info here
  session_start();

  $bhw_id = $_SESSION['bhw_id']; // get session bhw id
  $bhw_fullname = $_SESSION['bhw_fullname']; // get session bhw fullname
  $bhw_image = $_SESSION['bhw_image'];

  if($_SESSION['bhw_image'] == '') {
    $bhw_image = "../../assets/img/avatar/avatar-1.png";
  } else {
    $bhw_image = $bhw_image;
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

             <li class="nav-item active dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-calendar-check"></i>
                  <span>Appointments</span>
                </a>
                  <ul class="dropdown-menu" style="display: none;">
                      <li class="nav-item"><a href="appointments_book.php" class="nav-link" style="padding-right:0 !important"> <span>Face to Face Appointment</span> </a></li>
                      <li class="nav-item"><a href="appointments_oc.php" class="nav-link"> <span>Virtual Consultation</span> </a></li>
                      <li class="nav-item active dropdown"><a class="nav-link has-dropdown">Walk-in Appointment</a>
                        <ul class="dropdown-menu">
                          <li class="nav-item active"><a href="appointments_walk_in.php" class="nav-link">With Account</a></li>
                          <li class="nav-item"><a href="appointments_walk_in_noacc.php" class="nav-link">Without Account</a></li>
                        </ul>
                      </li>
                    </ul>
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
            <h1>Walk-in Appointments For Patients With Account</h1>
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
                           <tr>
                            <th>Appointment Booked By</th>
                            <th>Appointment Doctor</th>
                            <th>Patient Name</th>
                            <th>Medical Service</th>
                            <th>Appointment Status</th>
                           <!--  <th>Appointment Date</th>
                            <th>Appointment Time</th> -->
                            <th>Appointment Details</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>

                     <?php 

                      $sql = "SELECT 
                      d.user_account_id as doctor_account,
                      d.user_firstname  as doc_fname, 
                      d.user_middlename as doc_mname, 
                      d.user_lastname   as doc_lname,
                      p.user_id         as patient_id,
                      p.user_firstname  as patient_fname,
                      p.user_middlename as patient_mname,
                      p.user_lastname   as patient_lname,
                      p.user_account_id as patient_account,
                      a.appointment_id as appointment_id,
                      a.appointment_patient_fname as appoint_pfname,
                      a.appointment_patient_mname as appoint_pmname,
                      a.appointment_patient_lname as appoint_plname,
                      a.appointment_patient_email as appoint_pemail,
                      a.appointment_patient_pnum as appoint_ppnum,
                      a.appointment_selected_date as appoint_date,
                      a.appointment_selected_time as appoint_dst_id, 
                      dst.schedule_start_time as appoint_start_time,
                      dst.schedule_end_time as appoint_end_time,
                      a.appointment_selected_service as appoint_service,
                      a.appointment_type as appointment_type,
                      a.appointment_status as appointment_status,
                      a.appointment_reason as appointment_reason
                      FROM appointment a
                      JOIN user d 
                      ON a.appointment_doctor_id = d.user_id 
                      JOIN user p 
                      ON a.appointment_patient_id = p.user_id 
                      JOIN doctor_schedule_time dst 
                      ON a.appointment_selected_time = dst.schedule_time_id
                      WHERE a.appointment_type = 'walkinappointment' AND a.appointment_status IN (13)
                      ORDER BY a.appointment_id ASC
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
                      $patient_account      = $row['patient_account'];
                      $patient_firstname    = ucfirst($row['patient_fname']);
                      $patient_middlename   = ucfirst($row['patient_mname']);
                      $patient_lastname     = ucfirst($row['patient_lname']);

                      $patient_name = $patient_firstname.' '.$patient_middlename.'.'.' '.$patient_lastname;

                      // appointed patient
                      $appoint_pfname    = ucfirst($row['appoint_pfname']);
                      $appoint_pmname   = ucfirst($row['appoint_pmname']);
                      $appoint_plname     = ucfirst($row['appoint_plname']);

                      $appoint_patient_name = $appoint_pfname.' '.$appoint_pmname.'.'.' '.$appoint_plname;

                      // the appointed patient name
                      $appoint_patient_email = $row['appoint_pemail'];
                      $appoint_patient_email = $row['appoint_ppnum'];

                      // appointment schedules
                      $time_schedule_id = $row['appoint_dst_id'];
                      $appoint_schedule_date = $row['appoint_date'];

                      $appoint_start_time = $row['appoint_start_time'];
                      $appoint_end_time = $row['appoint_end_time'];

                      // appointment service and booking appointment type
                      $appoint_service = $row['appoint_service'];
                      $appoint_type = $row['appointment_type'];

                      // format time
                      $format_start = date("h:i:A", strtotime($appoint_start_time));
                      $format_end   = date("h:i:A", strtotime($appoint_end_time));

                      // for tool tip
                      $acname_tooltip = $patient_name;

                      // id
                      $appointment_id = $row['appointment_id'];

                      // reason
                      $appointment_reason = $row['appointment_reason'];

                      $appointment_status = $row['appointment_status'];

                      $appointment_type = $row['appointment_type'];

                      ?>

                        <tr>
                          <td> 
                            <?php if($patient_id == 0) { ?>
                              <a href="#" style="text-decoration: none;">No Account</a>
                            <?php } else { ?>
                              <a href="#" style="text-decoration: none;"><?php echo $patient_name ?></a></td>
                            <?php } ?>
                          <td><?php echo $doc_name ?></td>
                          <td><?php echo $appoint_patient_name ?></td>
                          <td><?php echo $appoint_service ?></td>
                          
                          <td>
                          <?php  
                          // if status = pending
                          if($appointment_status == 13) {

                          ?>

                             <span class="badge badge-success badge-pill">Approved</span>

                          <?php 
                          // if status = cancel
                          } else if($appointment_status == 2) { ?>

                            <span class="badge badge-danger badge-pill">Danger</span>

                          <?php 
                          // if status = accept
                          } else if($appointment_status == 3) { ?>

                            <span class="badge badge-info badge-pill">Accepted</span>

                          <?php } ?>
                              
                          </td>
                          <td>
                            <button class="btn btn-info btn-sm btn-block appointmentDetailsBhw" id='<?php echo $appointment_id ?>'> View Details </button> 
                          </td>
                          <td>

                          <?php  
                          // if status = pending
                          if($appointment_status == 13) {

                          ?>
                                <button class="btn btn-primary btn-sm btn-block proceedAppointmentWalkIn" id='<?php echo $appointment_id ?>'> Accept Appointment </button>


                          <?php 
                          // if status = cancel
                          } else if($appointment_status == 2) { ?>

                             <a class="btn btn-disabled text-white btn-sm btn-block" data-toggle="modal" data-accept-id="<?php echo $appointment_id ?>">Accept</a>
                             <a class="btn btn-disabled btn-block btn-sm" data-toggle="modal" data-cancel-id="<?php echo $appointment_id ?>"> Cancel </a>

                          <?php 
                          // if status = approve
                          } else if($appointment_status == 3) { ?>

                             <a class="btn btn-light text-dark  btn-sm btn-block" data-toggle="modal" data-accept-id="<?php echo $appointment_id ?>">Accept</a>
                             <a class="btn btn-light text-dark btn-block btn-sm" data-toggle="modal" data-cancel-id="<?php echo $appointment_id ?>"> Cancel </a>

                          <?php } ?>
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


    <!-- Modal for View Appointment Details -->
       <div class="modal fade" tabindex="-1" role="dialog" id="appointmentDetailsBhw">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">View Appointment Details</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
              </div>
             <div class="card-body">
              
              <ul class="list-group">
                      <li class="list-group-item ">
                        Date: <span id="view_appoint_date"></span>
                      </li>
                      <li class="list-group-item">
                        Schedule Time: <span id="view_appoint_time"></span>
                      </li>
                       <li class="list-group-item">
                        Appointment Status: <span id="view_appoint_status"></span>
                      </li>
                   <!--    <li class="list-group-item"> Reason: <span id="view_appointment_reason"></span>
                      </li> -->
                    </ul>       
        
              </div>
            </div>
          </div>
        </div>

     <!-- Modal for View Appointment Details -->
       <div class="modal fade" tabindex="-1" role="dialog" id="acceptAppointmentBhw">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Accept Appointment</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
              </div>
             <div class="card-body">

              <h4>Are you sure you want to accept this appointment?</h4>

              
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">Appointment Details</li>
                        <li class="list-group-item">Patient Name: <span id="accept_appoint_patient"></span></li>
                        <li class="list-group-item">Selected Service: <span id="accept_appoint_service"></span></li>
                        <li class="list-group-item">Selected Date: <span id="accept_appoint_date"></span></li>
                        <li class="list-group-item">Selected Time: <span id="accept_appoint_time"></span></li>
                      </ul>
            
              
               <form method="POST" action="../../backend/bhw_appointment_walkin.php">

                  <input type="text" name="proceedID" id="proceed_appoint_id">
                  <input type="text" name="proceedDoctorID" id="proceed_doctor_id">
                  <input type="text" name="proceedPatientID" id="proceed_patient_id">
                  <input type="text" name="proceedMedicalService" id="proceed_appoint_service">
                  <input type="text" name="proceedAppointmentType" id="proceed_appoint_type">
                  <input type="text" name="proceedDate" id="proceed_appoint_ddate">
                  <input type="text" name="proceedStartTime" id="proceed_appoint_stime">
                  <input type="text" name="proceedEndTime" id="proceed_appoint_etime">
                  <input type="text" name="proceedPfname" id="proceed_appoint_pfname">
                  <input type="text" name="proceedPmname" id="proceed_appoint_pmname">
                  <input type="text" name="proceedPlname" id="proceed_appoint_plname">

                  <input type="hidden" name="acceptWalkInID" id="accept_appoint_id">
                  <div class="form-group mt-4">
                    <button type="submit" name="acceptAppointmentSubmit" class="btn btn-success btn-block" tabindex="4">
                      Yes
                    </button>
                    <button class="btn btn-danger btn-block" tabindex="4" data-dismiss="modal">
                      No
                    </button>
                  </div>
                </form>

        
              </div>
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


<!-- View Details BHW -->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.appointmentDetailsBhw', function(){
        var viewID = $(this).attr("id");
        $.ajax({
          url:"../../backend/bhw_appointment_walkin.php",
            method:"POST",
            data:{walkInID:viewID},
            dataType:"json",
            success:function(data) {
                // date format
                var date = data.appoint_date;
                var dateFormat = moment(date).format('MM/DD/YYYY');

                var start_time = data.appoint_date + ' ' +data.appoint_start_time;
                var startTimeFormat = moment(start_time).format('HH:mm A');

                var end_time = data.appoint_date + ' ' +data.appoint_end_time;
                var endTimeFormat = moment(end_time).format('HH:mm A');

                var view_date = dateFormat;
                var view_time = startTimeFormat + ' - ' + endTimeFormat;

                // status format
                if(data.appointment_status == 1) {
                  $('#view_appoint_status').html("<span class='badge badge-primary badge-pill'>Pending</span>");
                } else if(data.appointment_status == 2) {
                  $('#view_appoint_status').html('');
                } else if(data.appointment_status == 3) {
                  $('#view_appoint_status').html("<span class='badge badge-info badge-pill'>Accepted</span>");
                } else if(data.appointment_status == 4) {
                  $('#view_appoint_status').html("<span class='badge badge-success badge-pill'>Approved</span>");
                } else if(data.appointment_status == 5) {
                  $('#view_appoint_status').html('');
                } else if(data.appointment_status == 6) {
                  $('#view_appoint_status').html('');
                } else if(data.appointment_status == 7) {
                  $('#view_appoint_status').html('');
                } else if(data.appointment_status == 0) {
                  $('#view_appoint_status').html("<span class='badge badge-success badge-pill'>Completed</span>");
                } else if(data.appointment_status == 13) {
                  $('#view_appoint_status').html("<span class='badge badge-success badge-pill'>Approved</span>");
                }

                // var test_result = "<span class='badge badge-danger'>Pending</span>";

                // $('#accept_appoint_test').html(test_result);
                
          
                // html - date and time
                $('#view_appoint_date').html(view_date);
                $('#view_appoint_time').html(view_time);
                $('#view_appointment_reason').html(data.appointment_reason);
                $('#appointmentDetailsBhw').modal('show');
             }
        })  
    })
});
</script>

<!-- Accept Book -->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.proceedAppointmentWalkIn', function(){
        var acceptID = $(this).attr("id");
        $.ajax({
          url:"../../backend/bhw_appointment_walkin.php",
            method:"POST",
            data:{walkInID:acceptID},
            dataType:"json",
            success:function(data) {
                // val - id
                $('#accept_appoint_id').val(data.appointment_id);
                $('#accept_doctor_id').val(data.doctor_id);
                $('#accept_patient_id').val(data.patient_id);
                $('#accept_appoint_dst_id').val(data.appoint_dst_id);
                // html - current patient;
                $('#accept_patient_account').val(data.patient_account);
                $('#accept_patient_fname').val(data.patient_fname);
                $('#accept_patient_mname').val(data.patient_mname);
                $('#accept_patient_lname').val(data.patient_lname);
                // html - doctor 
                $('#accept_doctor_account').val(data.doctor_account);
                $('#accept_doc_fname').val(data.doc_fname);
                $('#accept_doc_mname').val(data.doc_mname);
                $('#accept_doc_lname').val(data.doc_lname);
                // html - appoint patient names
                $('#accept_appoint_pfname').val(data.appoint_pfname);
                $('#accept_appoint_pmname').val(data.appoint_pmname);
                $('#accept_appoint_plname').val(data.appoint_plname);
                $('#accept_appoint_pemail').val(data.appoint_pemail);
                $('#accept_appoint_ppnum').val(data.appoint_ppnum);

                // name format
                var patient_fname = data.appoint_pfname;
                var patient_mname = data.appoint_pmname;
                var patient_lname = data.appoint_plname;

                var patient_fullname = patient_fname+ ' '+patient_mname+'. '+patient_lname;

                $('#accept_appoint_patient').html(patient_fullname);

                // date format
                var date = data.appoint_date;
                var dateFormat = moment(date).format('MM/DD/YYYY');

                var start_time = data.appoint_date + ' ' +data.appoint_start_time;
                var startTimeFormat = moment(start_time).format('HH:mm A');

                var end_time = data.appoint_date + ' ' +data.appoint_end_time;
                var endTimeFormat = moment(end_time).format('HH:mm A');

                var accept_date = dateFormat;
                var accept_time = startTimeFormat + ' - ' + endTimeFormat;

                // // status format
                // if(data.appointment_status == 1) {
                //   $('#accept_appointment_status').html('Pending');
                // } else if(data.appointment_status == 2) {
                //   $('#accept_appointment_status').html('Cancel');
                // } else if(data.appointment_status == 3) {
                //   $('#accept_appointment_status').html('Accepted');
                // } else if(data.appointment_status == 4) {
                //   $('#accept_appointment_status').html('Approve');
                // } else if(data.appointment_status == 5) {
                //   $('#accept_appointment_status').html('Reschedule');
                // } else if(data.appointment_status == 6) {
                //   $('#accept_appointment_status').html('On-going');
                // } else if(data.appointment_status == 7) {
                //   $('#accept_appointment_status').html('No-show');
                // } else if(data.appointment_status == 0) {
                //   $('#accept_appointment_status').html('Completed');
                // }

                // var test_result = "<span class='badge badge-danger'>Pending</span>";

                // $('#accept_appoint_test').html(test_result);
                
          
                // html - date and time
                $('#accept_appoint_date').html(accept_date);
                $('#accept_appoint_time').html(accept_time);
                $('#accept_appointment_status').html(data.appointment_status);
                $('#accept_appoint_service').html(data.appoint_service);
                $('#accept_appoint_type').val(data.appointment_type);
                $('#accept_appointment_reason').val(data.appointment_reason);

                     // val - id
                $('#proceed_appoint_id').val(data.appointment_id);
                $('#proceed_doctor_id').val(data.doctor_id);
                $('#proceed_patient_id').val(data.patient_id);

                if(data.patient_id == null) {
                  $('#proceed_patient_id').val(0);
                } else {
                  $('#proceed_patient_id').val(data.patient_id);
                }

                $('#proceed_appoint_dst_id').val(data.appoint_dst_id);
                // html - current patient;
                $('#proceed_patient_account').val(data.patient_account);
                $('#proceed_patient_fname').val(data.patient_fname);
                $('#proceed_patient_mname').val(data.patient_mname);
                $('#proceed_patient_lname').val(data.patient_lname);
                // html - doctor 
                $('#proceed_doctor_account').val(data.doctor_account);
                $('#proceed_doc_fname').val(data.doc_fname);
                $('#proceed_doc_mname').val(data.doc_mname);
                $('#proceed_doc_lname').val(data.doc_lname);
                // html - appoint patient names
                $('#proceed_appoint_pfname').val(data.appoint_pfname);
                $('#proceed_appoint_pmname').val(data.appoint_pmname);
                $('#proceed_appoint_plname').val(data.appoint_plname);
                $('#proceed_appoint_pemail').val(data.appoint_pemail);
                $('#proceed_appoint_ppnum').val(data.appoint_ppnum);

                // name format
                var patient_fname = data.appoint_pfname;
                var patient_mname = data.appoint_pmname;
                var patient_lname = data.appoint_plname;

                var patient_fullname = patient_fname+ ' '+patient_mname+'. '+patient_lname;

                $('#proceed_appoint_patient').html(patient_fullname);

                // date format
                var date = data.appoint_date;
                var dateFormat = moment(date).format('MM/DD/YYYY');

                var start_time = data.appoint_date + ' ' +data.appoint_start_time;
                var startTimeFormat = moment(start_time).format('HH:mm A');

                var end_time = data.appoint_date + ' ' +data.appoint_end_time;
                var endTimeFormat = moment(end_time).format('HH:mm A');

                var proceed_date = dateFormat;
                var proceed_time = startTimeFormat + ' - ' + endTimeFormat;

                // // status format
                // if(data.appointment_status == 1) {
                //   $('#proceed_appointment_status').html('Pending');
                // } else if(data.appointment_status == 2) {
                //   $('#proceed_appointment_status').html('Cancel');
                // } else if(data.appointment_status == 3) {
                //   $('#proceed_appointment_status').html('Accepted');
                // } else if(data.appointment_status == 4) {
                //   $('#proceed_appointment_status').html('Approve');
                // } else if(data.appointment_status == 5) {
                //   $('#proceed_appointment_status').html('Reschedule');
                // } else if(data.appointment_status == 6) {
                //   $('#proceed_appointment_status').html('On-going');
                // } else if(data.appointment_status == 7) {
                //   $('#proceed_appointment_status').html('No-show');
                // } else if(data.appointment_status == 0) {
                //   $('#proceed_appointment_status').html('Completed');
                // }

                // var test_result = "<span class='badge badge-danger'>Pending</span>";

                // $('#proceed_appoint_test').html(test_result);
                $('#proceed_appoint_ddate').val(data.appoint_date);
                $('#proceed_appoint_stime').val(data.appoint_start_time);
                $('#proceed_appoint_etime').val(data.appoint_end_time);
                
                
          
                // html - date and time
                $('#proceed_appoint_date').html(proceed_date);
                $('#proceed_appoint_time').html(proceed_time);
                $('#proceed_appointment_status').html(data.appointment_status);
                $('#proceed_appoint_service').val(data.appoint_service);
                $('#proceed_appoint_type').val(data.appointment_type);
                $('#proceed_appointment_reason').val(data.appointment_reason);

                $('#acceptAppointmentBhw').modal('show');
             }
        })  
    })
});
</script>


  </body>
</html>