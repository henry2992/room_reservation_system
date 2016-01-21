<!-- DataBase Connection -->
     <?php
		include 'db.php';
	?>
<!-- End Of DataBase Connection -->

<!-- Get Session Email -->
<?php
	session_start();
  	$email = $_SESSION['email'];

  	if ($email == null) {
  		header("location: index.php");
  	}
?>
<!-- If post delete it -->
<?php
	if($_POST) {
		$roomID= $_POST['roomID'];
		$checkIn= $_POST['checkIn'];
		$checkOut= $_POST['checkOut'];	

		mysql_query("SET AUTOCOMMIT=0");
		mysql_query("START TRANSACTION");

		$a1=mysql_query("DELETE from RoomSchedule WHERE RoomID=$roomID AND reservedDate >= '$checkIn' AND reservedDate < '$checkOut' ");		
        $a2 =mysql_query("DELETE FROM Reservation WHERE Email= '$email' and RoomID = '$roomID' AND CheckIn='$checkIn' ") ;
        
        if ($a1 and $a2) {
    	mysql_query("COMMIT");
		} else {        
    	mysql_query("ROLLBACK");
		}
	}
?>


<!-- Run Queries -->
<?php



	$sql = "SELECT count(*) as NumberofReservations FROM Reservation WHERE Email='$email ' "or  die(mysql_error());
	$result = mysql_query($sql);


	while ($row = mysql_fetch_assoc($result)){
	    $reservations_number = $row["NumberofReservations"];
	}

	$sql = "SELECT * FROM Reservation WHERE Email='$email ' " or die(mysql_error());

	$result = mysql_query($sql);

	$reservations = [];

	$counter = 0;

	while ( $counter < $reservations_number) {
	 	while ($row = mysql_fetch_assoc($result)){
		 	 $roomID= $row['RoomID'];
			 $email= $row['Email'];
			 $checkIn= $row['Checkin'];
			 $checkOut= $row['Checkout'];
			 $totalCost= $row['TotalCost'];
			 $guestNo= $row['guestno'];
			 $newreservation = array($roomID,$email,$checkIn,$checkOut,$totalCost,$guestNo);
			 array_push($reservations, $newreservation);	 
	 	}
	 	$counter++;
	}


?>
<!DOCTYPE html>
<html lang="en">
  	<head>
	    <meta charset="utf-8">
	    <title>Chicago Inn</title>
	    <!-- Custom CSS -->
	    <link rel="stylesheet" type="text/css" href="css/style.css"/> 
	    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>

	    <!-- Jquery and JqueryUI Connection -->
	    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	</head>
  	<body>

  		<!-- Nav Bar -->
		      <nav id="mainNav" class="navbar  navbar-inverse navbar-fixed-top">
		            <div class="container">
		                <!-- Brand and toggle get grouped for better mobile display -->
		                <div class="navbar-header">
		                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		                        <span class="sr-only">Toggle navigation</span>
		                        <span class="icon-bar"></span>
		                        <span class="icon-bar"></span>
		                        <span class="icon-bar"></span>
		                    </button>
		                    <a class="logo navbar-brand page-scroll" href="index.php">
		                      CHICAGO INN
		                    </a>
		                </div>

		               <!-- Collect the nav links, forms, and other content for toggling -->
		                 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		                    <ul class="nav navbar-nav navbar-right">
		                        <li>
		                            <a class="page-scroll" href="index.php">Home</a>
		                        </li>
		                        <li>
		                            <a class="page-scroll" href="logout.php">Log out</a>
		                        </li>
		                   
		                    </ul>
		                </div>
		                <!-- /.navbar-collapse -->
		            </div>
		            <!-- /.container-fluid -->
		        </nav>
	<!-- End of NAvbar -->
		<div class="login container">
  			<h3>Number of Reservations: 
				<?php echo $reservations_number;?>
			</h3> 
		</div>
		<div class="reservation container">
			<h3> Reservations: </h3> 
		</div>

		        	<?php 
			           	$count = 0;
			           	while ( $count < $reservations_number) {
			           		$roomID_form = $reservations[$count][0];
			           		$checkIn_form = $reservations[$count][2];
			           		$checkOut_form =$reservations[$count][3];
			           		$total_form = $reservations[$count][4];
			           		$guest_form = $reservations[$count][5];
		           	?>	
		           	<div class="login-account container">	
		            	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">   
				            <div id="data">
				            	<!-- Room ID -->
				            	<h4 class="inline-display">
				            	<label class="form-label-user"  for="roomID">Room No:</label>
				            	 <?php echo $roomID_form ?> </h4> 
					            <input type="text" name="roomID" id="roomID" value= '<?php echo (isset($roomID_form) ? $roomID_form : null); ?>' hidden/>
					            <br>
					            <!-- Checkin -->
					            <h4 class="inline-display">
					            <label class="form-label-user"  for="checkIn">CheckIn Date:</label> 
					             <?php echo $checkIn_form ?> </h4> 
					            <input type="text" name="checkIn" id="checkIn" value= '<?php echo (isset($checkIn_form) ? $checkIn_form  : null); ?>' hidden/>
					            <br>
					            <!-- Checkout  -->
					            <h4 class="inline-display">
					            <label class="form-label-user"  for="checkout">CheckOut Date:</label> 
					             <?php echo $checkOut_form ?> </h4> 
					            <input type="text" name="checkOut" id="checkOut" value= '<?php echo (isset($checkOut_form) ? $reservations[$count][3] : null); ?>' hidden/>
					            <br>
					            <!-- TotalCost -->
					            <h4 class="inline-display">
					            <label class="form-label-user"  for="totalCost">Total Cost:</label> 
					           $<?php echo $total_form ?> </h4> 
					            <input type="text" name="totalCost" id="totalCost" value= '<?php echo (isset($total_form) ? $reservations[$count][4] : null); ?>' hidden/>
					            <br>
							 	<!-- Guestno -->
							 	<h4 class="inline-display">
							 	<label class="form-label-user" for="guestNo">Number of Guest:</label> 
							 		<?php echo $guest_form  ?> </h4> 
					            <input type="text" name="guestNo" id="guestNo" value= '<?php echo (isset($guest_form ) ? $reservations[$count][5] : null); ?>' hidden />
					            <br>
					             

					            <!-- Submit Button -->
					            <input class="btn btn-warning btn-lg" type="submit" name="<?php echo "$count"; ?>" value="Cancel">  
					            <br>
					            <br> 
				          	</div>
		           		</form>
		        	</div>
		          <?php
		          	$count++;
		          	}
		          ?>
  	</body>
</html>


     




