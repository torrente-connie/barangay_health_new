  <!-- General JS Scripts -->
  <script src="assets/vendors/jquery/jquery.min.js"></script>

  <script src="assets/js/stisla.js"></script>
  <script src="assets/vendors/bootstrap/js/bootstrap.js"> </script>

  <script src="assets/vendors/jquery-nicescroll/js/jquery.nicescroll.js"> </script>

  <script src="assets/vendors/fullcalendar/lib/main.js"> </script>

  <script src="assets/vendors/owlcarousel/dist/owl.carousel.js"> </script>

  <script src="assets/vendors/jquery-ui/jquery-ui.js"></script>

  <script src="assets/vendors/moment/moment.js"></script>  

  <!-- JS Libraies -->

  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <script src='assets/vendors/fullcalendar/packages/core/main.js'></script>
  <script src='assets/vendors/fullcalendar/packages/interaction/main.js'></script>
  <script src='assets/vendors/fullcalendar/packages/daygrid/main.js'></script>
  <script src='assets/vendors/fullcalendar/packages/timegrid/main.js'></script>
  <script src='assets/vendors/fullcalendar/packages/list/main.js'></script>

</body>
</html>


<!-- Confirmation Submission Bug Resolve -->
<script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
</script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      //plugins: [ 'interaction', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridDay,listMonth'
        //right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      defaultDate:  new Date(),
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      events: <?php echo $data ?>,
      eventClick:  function(info) {


          var title = info.event.title;
          
          
          var starttime = info.event.start;
          var endtime = info.event.end;
          

          var dateFormat = moment(starttime).format('MM/DD/YYYY');
          var startTimeFormat = moment(starttime).format('HH:mm A');
          var startEndFormat = moment(endtime).format('HH:mm A');

          var show_time = startTimeFormat + ' - ' + startEndFormat;

                $('#modalTitle').html(title);
                $('#modalShowDate').html(dateFormat);
                $('#modalShowTime').html(show_time);
                $('#calendarModal').modal();
            },
    });
    calendar.render();
  });
</script>


