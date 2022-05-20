<!-- General JS Scripts -->
  <script src="../../assets/vendors/jquery/jquery.min.js"></script>

  <script src="../../assets/js/stisla.js"></script>
  <script src="../../assets/vendors/bootstrap/js/bootstrap.js"> </script>

  <script src="../../assets/vendors/jquery-nicescroll/js/jquery.nicescroll.js"> </script>

  <script src="../../assets/vendors/datatables/jquery.dataTables.js"> </script>

  <script src="../../assets/vendors/datatables-bs4/dataTables.bootstrap4.js"> </script>

  <script src="../../assets/js/page/bootstrap-modal.js"></script>

  <script src="../../assets/vendors/jquery-mask/dist/jquery.mask.js"></script>

  <script src="../../assets/vendors/jquery-validation/dist/jquery.validate.js"></script>

  <script src="../../assets/vendors/moment/moment.js"></script>  
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="../../assets/js/scripts.js"></script>
  <script src="../../assets/js/custom.js"></script>

<!-- Confirmation Submission Bug Resolve -->
<script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
</script>

<script>
$(document).ready(function(){
// updating the view with notifications using ajax
function load_unseen_notification(view = '')
{

  var session_id = <?php echo $doctor_id ?>;
  var session_login = 'doctor';

 $.ajax({
  url:"../../backend/notification.php",
  method:"POST",
  data:{view:view,session_id:session_id,session_login:session_login},
  dataType:"json",
  success:function(data)
  {
   $('.dropdown-notif').html(data.notification);
     if(data.unseen_notification < 1)
   {
    $('span.beep').hide();
   }
  }
 });
}
load_unseen_notification();

// load new notifications
$(document).on('click', '#notif-toggle', function() {
  $('span.beep').html('');
 load_unseen_notification('yes');
  });
});
</script>