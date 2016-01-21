<!-- DataBase Connection -->
<?php
  include 'db.php';
  $sql = "SELECT distinct Category FROM Rooms";
  $result = mysql_query($sql);
?>
<!-- End Of DataBase Connection -->

<!-- Start HTML -->
<!DOCTYPE html>
<html>

  <head>
      <meta charset="utf-8">
      <title>Chicago Inn</title>
      <!-- Custom CSS -->
      <link rel="stylesheet" type="text/css" href="css/style.css"/> 

      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
      <link rel="stylesheet" href="css/flexslider.css" type="text/css"> 
      <!-- Jquery and JqueryUI Connection -->
      
      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <script src="js/jquery.flexslider-min.js"></script>
  </head>
  <body>
      <?php
        include 'navbar.php';
      ?>
      <!-- Slice Carousel -->
      <!-- Place somewhere in the <body> of your page -->
      <div class="flexslider-container">  
        <div class="flexslider">
          <ul class="slides">
            <li>
              <div class="img-slider bg-img-1"><div>
            </li>
            <li>
              <div class="img-slider bg-img-2"><div>
            </li>
            <li >
              <div class="img-slider bg-img-3"><div>
            </li>
          </ul>
        </div>
      </div>
      <!-- End of Slice Carousel -->
       <div id="search-form" class="booking_box">

          <div class="search-form-head">
            <h1>ONLINE RESERVATIONS</h1>
            <p>BEST PRICE GUARANTEED</p>
          </div>

          <div class="search-form-body">
            <form action="searchresults.php" method="get" id="search_form"> 
              <br>
              <div class="form-item booking-date" >
                <label for="booking-form-date-from">Check-in</label>
                <input type="text" class="datepicker" name="datepicker_start" id="datepicker_start" required>     
              </div>

              <div class="form-item booking-date" >
                <label for="booking-form-date-from">Check-Out</label>
                <input type="text" class="datepicker"  name="datepicker_end"   id="datepicker_end" required>  
              </div>


              <div class="form-item booking-date" >
                <label for="booking-form-date-from">Room Type</label>
                 <br>
                 <select name='category' id='category'>
                  <?php 
                  while ($row = mysql_fetch_array($result)) {
                      echo "<option value='" . $row['Category'] . "'>" . $row['Category'] . "</option>" ;
                  }
                  ?>
                </select> 
              </div>

              <div class="form-item booking-date" >
                <label for="booking-form-date-from">Number of Guests</label>
                <select name="guests" id='guests' >
                  <option value="1" >1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>


               <input type="text" id="totaldays" name="totaldays" required hidden>
              
              <div id="search-button">
                <input id="send" type="submit" value="Book Now">
              </div>

            </form>
          </div>

          <?php
              if(isset($_GET['submit'])){
                $selected_val = $_POST['category']; 
                $selected_val = $_POST['guests'];  
              }    
          ?>
      </div>
  </body>

  <script src="js/dates.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
    $(window).load(function() {
      $('.flexslider').flexslider({
        controlNav: false,
        directionNav: false, 
        animation: "fade",
        animationLoop: true,    
        slideshow: true,  
        slideshowSpeed: 3000, 
        animationSpeed: 600,  
      });
    });
  </script>
  <script src="js/bootstrap.min.js"></script>
</html>