    <?php if(isset($_GET['valid'])) { 
        $getSuccess =  $_GET['valid'];
      ?>
    <div class="alert alert-success" id="alert"><?php echo $getSuccess; ?></div>
                    
    <?php } else if(isset($_GET['invalid'])) { 
        $getFail = $_GET['invalid'];
      ?>

    <div class="alert alert-danger" id="alert"><?php echo $getFail; ?></div>

    <?php } else if(isset($_GET['nonvalid'])) { 
        $getUpdate = $_GET['nonvalid'];
      ?>
                      
    <div class="alert alert-info" id="alert"><?php echo $getUpdate; ?></div>

    <?php } ?>