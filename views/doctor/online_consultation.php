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

              <li class="nav-item active">
                   <a href="online_consultation.php" class="nav-link"><i class="fas fa-notes-medical"></i><span>Virtual Consultation</span></a>
               </li>

            <li class="nav-item">
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
                            <th>Booked By</th>
                            <th>Assigned Patient</th>
                            <th>Virtual Consultation Link</th>
                            <th>Platform</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th></th>
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
                      vc.virtual_consultation_patient_fname as virtual_pfname,
                      vc.virtual_consultation_patient_mname as virtual_pmname,
                      vc.virtual_consultation_patient_lname as virtual_plname,
                      vc.virtual_consultation_id as consultation_id,
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
                      WHERE d.user_id = '$doctor_id' AND vc.virtual_consultation_status = 1
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
                      $book_patient_account      = $row['patient_account'];
                      $book_patient_firstname    = ucfirst($row['patient_fname']);
                      $book_patient_middlename   = ucfirst($row['patient_mname']);
                      $book_patient_lastname     = ucfirst($row['patient_lname']);

                      $book_patient_name = $book_patient_firstname.' '.$book_patient_middlename.'.'.' '.$book_patient_lastname;

                      // user patient fullname
                      $virtual_firstname    = ucfirst($row['virtual_pfname']);
                      $virtual_middlename   = ucfirst($row['virtual_pmname']);
                      $virtual_lastname     = ucfirst($row['virtual_plname']);

                      $virtual_name = $virtual_firstname.' '.$virtual_middlename.'.'.' '.$virtual_lastname;

                      // format date and time
                      $date = $row['consultation_date'];
                      $format_start = date("h:i:A", strtotime($row['consultation_stime']));
                      $format_end   = date("h:i:A", strtotime($row['consultation_etime']));


                        //
                        $consultation_id = $row['consultation_id'];
                        $consultation_link = $row['consultation_link'];
                        $consultation_platform = $row['consultation_type'];

                        if($consultation_platform == "google-meet") {
                          $platform = "Google Meet";
                        } else if($consultation_platform == "zoom") {
                          $platform = "Zoom";
                        }

                      ?>

                        <tr>
                          <td><?php echo $book_patient_name ?></td>
                          <td><?php echo $virtual_name ?></td>
                          <td><a href="<?php echo $consultation_link ?>" target="_blank"><?php echo $consultation_link ?></a></td>
                          <td><?php echo $platform ?></td>
                          <td><?php echo $date ?></td>
                          <td><?php echo $format_start ?> - <?php echo $format_end ?></td>
                          <td>
                              <button class="btn btn-success btn-sm btn-block virtualConsultationDone" id='<?php echo $consultation_id ?>'> Done </button> 
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
       <div class="modal fade" tabindex="-1" role="dialog" id="virtualConsultationDone">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><span class="badge badge-success badge-pill">Completed Virtual Consultation</span></h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
              </div>
             <div class="card-body">

              <h4>Is the virtual consultation completed ? </h4>

                     <ul class="list-group list-group-flush">
                        <li class="list-group-item text-center">Virtual Consultation Details</li>
                        <li class="list-group-item">Assigned Patient Name: <span id="virtual_consultation_patient"></span></li>
                        <li class="list-group-item">Virtual Consultation Link: <span id="virtual_consultation_link"></span></li>
                        <li class="list-group-item">Platform: <span id="virtual_consultation_type"></span></li>
                        <li class="list-group-item">Date: <span id="view_consultation_date"></span></li>
                        <li class="list-group-item">Time: <span id="view_consultation_time"></span></li>
                      </ul>

              
              <form method="POST" action="../../backend/doctor_online_consultation.php">

                  <input type="hidden" name="consultationID" id="virtual_consultation_id">
                  <input type="hidden" name="appointmentID" id="virtual_consultation_appointment_id">

                 
                  <div class="form-group mt-4">
                    <button type="submit" name="completedVirtualConsultationSubmit" class="btn btn-success btn-block" tabindex="4">
                      Completed
                    </button>
                    <button class="btn btn-danger btn-block" tabindex="4" data-dismiss="modal">
                      Cancel
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
    $(document).on('click','.virtualConsultationDone', function(){
        var doneID = $(this).attr("id");
        $.ajax({
          url:"../../backend/doctor_online_consultation.php",
            method:"POST",
            data:{vcID:doneID},
            dataType:"json",
            success:function(data) {
                $('#virtual_consultation_id').val(data.consultation_id);
                $('#virtual_consultation_appointment_id').val(data.appointment_id);

                // name format
                var patient_fname = data.virtual_pfname;
                var patient_mname = data.virtual_pmname;
                var patient_lname = data.virtual_plname;

                var patient_fullname = patient_fname+ ' '+patient_mname+'. '+patient_lname;

                $('#virtual_consultation_patient').html(patient_fullname);

                // date format
                var date = data.consultation_date;
                var dateFormat = moment(date).format('MM/DD/YYYY');

                var start_time = data.consultation_date + ' ' +data.consultation_stime;
                var startTimeFormat = moment(start_time).format('HH:mm A');

                var end_time = data.consultation_date + ' ' +data.consultation_etime;
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
                  $('#view_appoint_status').html("<span class='badge badge-primary badge-pill'>Confirmed</span>");
                } else if(data.appointment_status == 0) {
                  $('#view_appoint_status').html("<span class='badge badge-success badge-pill'>Completed</span>");
                }

                // var test_result = "<span class='badge badge-danger'>Pending</span>";

                // $('#accept_appoint_test').html(test_result);
                $('#virtual_consultation_link').html(data.consultation_link);

                if(data.consultation_type == "google-meet") {
                   $('#virtual_consultation_type').html('Google Meet');
                } else if(data.consultation_type == "zoom" ) {
                   $('#virtual_consultation_type').html('Zoom');
                }
                
              
                // html - date and time
                $('#view_consultation_date').html(view_date);
                $('#view_consultation_time').html(view_time);
                $('#virtualConsultationDone').modal('show');
             }
        })  
    })
});
</script>


  </body>
</html>