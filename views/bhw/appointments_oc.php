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
                      <li class="nav-item active"><a href="appointments_oc.php" class="nav-link"> <span>Virtual Consultation</span> </a></li>
                      <li class="nav-item dropdown"><a class="nav-link has-dropdown">Walk-in Appointment</a>
                        <ul class="dropdown-menu">
                          <li class="nav-item"><a href="appointments_walk_in.php" class="nav-link">With Account</a></li>
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
            <h1>Virtual Consultation Appointments</h1>
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
                      WHERE a.appointment_type = 'onlineappointment' AND a.appointment_status IN (1,2,3,4,5,6)
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

                      ?>

                        <tr>
                          <td><a href="#" style="text-decoration: none;"><?php echo $patient_name ?></a></td>
                          <td><?php echo $doc_name ?></td>
                          <td><?php echo $appoint_patient_name ?></td>
                          <td><?php echo $appoint_service ?></td>
                          <td>
                          <?php  
                          // if status = pending
                          if($appointment_status == 1) {

                          ?>
                            <span class="badge badge-primary badge-pill">Pending</span>

                          <?php 
                          // if status = cancel
                          } else if($appointment_status == 2) { ?>

                            <span class="badge badge-danger badge-pill">Cancel</span>
                            <p>Reason: <?php echo $appointment_reason ?></p>

                          <?php 
                          // if status = accept
                          } else if($appointment_status == 3) { ?>

                            <span class="badge badge-info badge-pill">Accepted</span>

                          <?php } else if($appointment_status == 4) { ?>

                            <span class="badge badge-success badge-pill">Approved</span>

                          <?php } else if($appointment_status == 7) {?>


                          <?php } ?>
                              
                          </td>
                          <!-- <td><?php //echo $appoint_schedule_date ?></td>
                          <td><?php //echo $format_start ?> - <?php //echo $format_end ?></td>  -->
                          <td>
                             <button class="btn btn-info btn-sm btn-block appointmentDetailsBhw" id='<?php echo $appointment_id ?>'> View Details </button> 
                          </td>
                          <td>

                          <?php  
                          // if status = pending
                          if($appointment_status == 1) {

                          ?>

                            <button class="btn btn-primary btn-sm btn-block acceptAppointmentBhw" id='<?php echo $appointment_id ?>'> Accept </button> 

                           <!--  <button class="btn btn-danger btn-sm btn-block cancelAppointmentBhw" id='<?php //echo $appointment_id ?>'> Reschedule </button> --> 


                          <?php 
                          // if status = cancel
                          } else if($appointment_status == 2) { ?>

                            
                          <?php 
                          // if status = accept
                          } else if($appointment_status == 3) { ?>

                        
                          <?php } else if($appointment_status == 4) { ?>


                            <button class="btn btn-primary btn-sm btn-block consultationLinkBhw" id='<?php echo $appointment_id ?>'> Consultation Link </button> 

                            <!-- <button class="btn btn-danger btn-sm btn-block cancelAppointmentBhw" id='<?php //echo $appointment_id ?>'> Reschedule </button>  -->

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
       <div class="modal fade" tabindex="-1" role="dialog" id="appointmentDetails">
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
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Date: 10/27/2021
                        
                        <?php 

                        if($appointment_status == 1) {

                        ?>

                       <span class="badge badge-primary badge-pill">Pending</span>

                       <?php } else if($appointment_status == 2) { ?>

                       <span class="badge badge-danger badge-pill">Cancel</span>

                       <?php } else if($appointment_status == 3) { ?>

                       <span class="badge badge-info badge-pill">Accepted</span>

                       <?php } ?>

                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Schedule Time: <?php echo $format_start ?> - <?php echo $format_end ?>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Reason: <?php echo $appointment_reason ?>
                      </li>
                    </ul>        
        
              </div>
            </div>
          </div>
        </div>

            <!-- Modal for View Appointment Details -->
       <div class="modal fade" tabindex="-1" role="dialog" id="appointmentDetailsBhw">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><span class="badge badge-info badge-pill">View Appointment Details</span></h5>
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
                    <!--   <li class="list-group-item"> Reason: <span id="view_appointment_reason"></span>
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
                <h5 class="modal-title"><span class="badge badge-primary badge-pill">Accept Appointment</span></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
              </div>
             <div class="card-body">

              <h4>Are you sure you want to accept this appointment?</h4>
              
              <form method="POST" action="../../backend/bhw_appointment_oc.php">

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">Appointment Details</li>
                        <li class="list-group-item">Patient Name: <span id="accept_appoint_patient"></span></li>
                        <li class="list-group-item">Selected Service: <span id="accept_appoint_service"></span></li>
                        <li class="list-group-item">Selected Date: <span id="accept_appoint_date"></span></li>
                        <li class="list-group-item">Selected Time: <span id="accept_appoint_time"></span></li>
                      </ul>

                  <input type="hidden" name="acceptID" id="accept_appoint_id">

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


      <!-- Modal for View Appointment Details -->
       <div class="modal fade" tabindex="-1" role="dialog" id="cancelAppointmentBhw">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Cancel Appointment</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
              </div>
             <div class="card-body">

              <h4>Are you sure you want to cancel this appointment?</h4>
              
              <form method="POST" action="../../backend/bhw_appointment_oc.php">

                  <input type="hidden" name="cancelID" id="cancelID">

                  <div class="form-group mt-4">
                    <label for="reason">Reason</label>
                    <input id="reason" type="text" class="form-control" name="reason" tabindex="1" required="" autofocus="" placeholder="Please state the reason for the cancellation of the appointment..">
                  </div>

                  <div class="form-group">
                    <button type="submit" name="cancelAppointmentSubmit" class="btn btn-success" tabindex="4">
                      Submit
                    </button>
                    <button class="btn btn-danger" tabindex="4" data-dismiss="modal">
                      Close
                    </button>
                  </div>
                </form>

        
              </div>
            </div>
          </div>
        </div>

            <!-- Modal for View Appointment Details -->
       <div class="modal fade" tabindex="-1" role="dialog" id="consultationLinkBhw">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><span class="badge badge-primary badge-pill">Provide Virtual Consultation Link</span></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
              </div>
             <div class="card-body">

              <h4>Please Provide A Consultation Link for the Patient:</h4>
              
              <form method="POST" action="../../backend/bhw_appointment_oc.php">

                  <input type="hidden" name="consultationLinkID" id="consult_appoint_id">
                  <input type="hidden" name="consultationDoctorID" id="consult_doctor_id">
                  <input type="hidden" name="consultationPatientID" id="consult_patient_id">
                  <input type="hidden" name="consultationDate" id="consult_appoint_ddate">
                  <input type="hidden" name="consultationStartTime" id="consult_appoint_stime">
                  <input type="hidden" name="consultationEndTime" id="consult_appoint_etime">
                  <input type="hidden" name="consultationPfname" id="consult_appoint_pfname">
                  <input type="hidden" name="consultationPmname" id="consult_appoint_pmname">
                  <input type="hidden" name="consultationPlname" id="consult_appoint_plname">

                   <div class="form-group mt-4">
                    <label for="reason">Type of Consultation Link</label>
                    <select class="form-control" name="consultation_type">
                      <option selected hidden>Select Virtual Consultation Platform</option>
                      <option value="google-meet">Google Meet</option>
                      <option value="zoom">Zoom</option>
                    </select>
                  </div>

                  <div class="form-group mt-4">
                    <label for="reason">Provide Consultation Link</label>
                    <input id="reason" type="text" class="form-control" name="consultation_link" tabindex="1" required="" autofocus="" placeholder="Please input the consultation link here..">
                  </div>

                  <div class="form-group">
                    <button type="submit" name="consultationLinkSubmit" class="btn btn-primary btn-block" tabindex="4">
                      Submit
                    </button>
                    <button class="btn btn-danger btn-block" tabindex="4" data-dismiss="modal">
                      Close
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
          url:"../../backend/bhw_appointment_oc.php",
            method:"POST",
            data:{ocID:viewID},
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
    $(document).on('click','.acceptAppointmentBhw', function(){
        var acceptID = $(this).attr("id");
        $.ajax({
          url:"../../backend/bhw_appointment_oc.php",
            method:"POST",
            data:{ocID:acceptID},
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
                $('#acceptAppointmentBhw').modal('show');
             }
        })  
    })
});
</script>

<!-- Virtual Consultation Link BHW -->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.consultationLinkBhw', function(){
        var consultationID = $(this).attr("id");
        $.ajax({
          url:"../../backend/bhw_appointment_oc.php",
            method:"POST",
            data:{ocID:consultationID},
            dataType:"json",
            success:function(data) {
                // val - id
                $('#consult_appoint_id').val(data.appointment_id);
                $('#consult_doctor_id').val(data.doctor_id);
                $('#consult_patient_id').val(data.patient_id);
                $('#consult_appoint_dst_id').val(data.appoint_dst_id);
                // html - current patient;
                $('#consult_patient_account').val(data.patient_account);
                $('#consult_patient_fname').val(data.patient_fname);
                $('#consult_patient_mname').val(data.patient_mname);
                $('#consult_patient_lname').val(data.patient_lname);
                // html - doctor 
                $('#consult_doctor_account').val(data.doctor_account);
                $('#consult_doc_fname').val(data.doc_fname);
                $('#consult_doc_mname').val(data.doc_mname);
                $('#consult_doc_lname').val(data.doc_lname);
                // html - appoint patient names
                $('#consult_appoint_pfname').val(data.appoint_pfname);
                $('#consult_appoint_pmname').val(data.appoint_pmname);
                $('#consult_appoint_plname').val(data.appoint_plname);
                $('#consult_appoint_pemail').val(data.appoint_pemail);
                $('#consult_appoint_ppnum').val(data.appoint_ppnum);

                // name format
                var patient_fname = data.appoint_pfname;
                var patient_mname = data.appoint_pmname;
                var patient_lname = data.appoint_plname;

                var patient_fullname = patient_fname+ ' '+patient_mname+'. '+patient_lname;

                $('#consult_appoint_patient').html(patient_fullname);

                // date format
                var date = data.appoint_date;
                var dateFormat = moment(date).format('MM/DD/YYYY');

                var start_time = data.appoint_date + ' ' +data.appoint_start_time;
                var startTimeFormat = moment(start_time).format('HH:mm A');

                var end_time = data.appoint_date + ' ' +data.appoint_end_time;
                var endTimeFormat = moment(end_time).format('HH:mm A');

                var consult_date = dateFormat;
                var consult_time = startTimeFormat + ' - ' + endTimeFormat;

                // // status format
                // if(data.appointment_status == 1) {
                //   $('#consult_appointment_status').html('Pending');
                // } else if(data.appointment_status == 2) {
                //   $('#consult_appointment_status').html('Cancel');
                // } else if(data.appointment_status == 3) {
                //   $('#consult_appointment_status').html('Accepted');
                // } else if(data.appointment_status == 4) {
                //   $('#consult_appointment_status').html('Approve');
                // } else if(data.appointment_status == 5) {
                //   $('#consult_appointment_status').html('Reschedule');
                // } else if(data.appointment_status == 6) {
                //   $('#consult_appointment_status').html('On-going');
                // } else if(data.appointment_status == 7) {
                //   $('#consult_appointment_status').html('No-show');
                // } else if(data.appointment_status == 0) {
                //   $('#consult_appointment_status').html('Completed');
                // }

                // var test_result = "<span class='badge badge-danger'>Pending</span>";

                // $('#consult_appoint_test').html(test_result);
                $('#consult_appoint_ddate').val(data.appoint_date);
                $('#consult_appoint_stime').val(data.appoint_start_time);
                $('#consult_appoint_etime').val(data.appoint_end_time);
                
                
          
                // html - date and time
                $('#consult_appoint_date').html(consult_date);
                $('#consult_appoint_time').html(consult_time);
                $('#consult_appointment_status').html(data.appointment_status);
                $('#consult_appoint_service').html(data.appoint_service);
                $('#consult_appoint_type').val(data.appointment_type);
                $('#consult_appointment_reason').val(data.appointment_reason);
                $('#consultationLinkBhw').modal('show');
             }
        })  
    })
});
</script>


  </body>
</html>