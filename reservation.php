<!-- DataBase Connection -->
     <?php
		  include 'db.php';
		  error_reporting(0);
	?>

<!-- End Of DataBase Connection -->

<!-- Get Variables -->
<?php
	$startDate = $_POST['datepicker_start'];
	$lastDate = $_POST['datepicker_end'];
	$guests = $_POST['guests'];
	$days = $_POST['totaldays'];
	$roomId = $_POST['roomId'];
	$price = $_POST['price'];
?>

<!-- Error Checking for First Form -->
<?php 

	if($_POST && isset($_POST['feedback'],
					   $_POST['fname'], 
					   $_POST['lname'], 
					   $_POST['phonenumber'], 
					   $_POST['email'],
					   $_POST['pwd'],  
					   $_POST['roomId'], 
					   $_POST['datepicker_start'],
					   $_POST['datepicker_end'],
					   $_POST['totaldays'],
					   $_POST['totalprice'],
					   $_POST['guests'],
					   $_POST['discount_type'],
					   $_POST['price']
					   )) {

	    $fname = $_POST['fname'];
	    $lname = $_POST['lname'];
		$phonenumber = $_POST['phonenumber'];
		$email = $_POST['email'];

		$pwd = $_POST['pwd'];
		$pwdHash = password_hash($pwd,PASSWORD_DEFAULT);

		$roomId= $_POST['roomId'];
	    $datepicker_start = $_POST['datepicker_start'];
		$datepicker_end = $_POST['datepicker_end'];
		$totaldays = $_POST['totaldays'];
		$totalprice = $_POST['totalprice'];
		$guests = $_POST['guests'];
		$discount_type = $_POST['discount_type'];
		$price = $_POST['price'];

	    //  Set Regular Expressions
	    $string_exp = "/^[A-Za-z .'-]+$/";
 		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	
		if (empty($fname)) {
	      $error_message = 'Please enter a valid first name';
		} else if (!preg_match($string_exp, $fname) ){
			$error_message = 'The first name you entered has an unexpected character.';  
				$error_message = 'Please enter a valid last name';
		} else if (!preg_match($string_exp, $lname) ){
			$error_message = 'The last name you entered has an unexpected character.';
		} else if (empty($phonenumber)) {
	    	$error_message = 'Please enter a valid 10 digit phone number';
		} else if (!is_numeric($phonenumber)){
			$error_message = 'You must enter a valid phonenumber';
		} elseif (strlen($phonenumber)!= 10 ) {
	        $error_message = 'Your phonenumber needs to be 10 digits';
	    } else if (empty($email)) {
			$error_message = 'Please enter a valid email';
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$error_message = 'Invalid email format';
		}else if (empty($pwd)) {
			$error_message = 'Please enter a password';
		} 
		else {

			// Store the Costumer
			$sql="INSERT INTO Customer (Fname, Lname, Phone, Email, Discount_type, password)
		  		  VALUES
		  		  ('$_POST[fname]', '$_POST[lname]','$_POST[phonenumber]','$_POST[email]','$_POST[discount_type]', '$pwdHash')";
		  	
		  	if (!mysql_query($sql)){
		  		if (mysql_errno() == 1062) {
    				$error_message = "That email already exits";
				}	
			}  else{
				// Store Reservation If Everything is Correct
		  			$sql="INSERT INTO Reservation (RoomID, Email, Checkin, Checkout, TotalCost, guestno)
		  		  				VALUES
		  		 		('$_POST[roomId]', '$_POST[email]','$_POST[datepicker_start]','$_POST[datepicker_end]','$_POST[totalprice]', '$_POST[guests]')";
		  		 	if (!mysql_query($sql)){
		  		 			die('Error : ' . mysql_error());
		  		 		}
		  		 		
		  		 	$count_days = 0	;
		  		 	while ( $count_days < $totaldays) {


		  		 		$date = strtotime("+$count_days day", strtotime("$datepicker_start"));
		  		 		echo "<br>";
						$days_reserved = date("Y-m-d", $date);

		  		 			$sql="INSERT INTO RoomSchedule(RoomID, reservedDate, RoomStatus)
		  		  				VALUES
		  		 				('$_POST[roomId]','$days_reserved', 'Reserved')";
					  		 	if (!mysql_query($sql)){
					  		 		die('Error : ' . mysql_error());
					  		 	}

					  	$count_days++;	 	
		  		 	}		
					header("Location: reservation_results.php");
				}
				
	      	
    	}

	    
	 } //Eror Checking First form.

// Error Checking Second form.

	 if($_POST && isset($_POST['user_register'], 
	 				   $_POST['email'], 
	 				   $_POST['roomId'], 
	 				   $_POST['datepicker_start'],
					   $_POST['datepicker_end'],
					   $_POST['totaldays'],
					   $_POST['totalprice'],
					   $_POST['guests'],
					   $_POST['discount_type'],
					   $_POST['price']
					   )) {

		$email_search = $_POST['email'];

		$pwd = $_POST['pwd'];
		$pwdHash = password_hash($pwd,PASSWORD_DEFAULT);

		$roomId= $_POST['roomId'];
	    $datepicker_start = $_POST['datepicker_start'];
		$datepicker_end = $_POST['datepicker_end'];
		$totaldays = $_POST['totaldays'];
		$totalprice = $_POST['totalprice'];
		$guests = $_POST['guests'];
		$discount_type = $_POST['discount_type'];
		$price = $_POST['price'];


	    if (empty($email_search)) {
			$error_message2 = 'Please enter a valid email.';
		} else if (!filter_var($email_search, FILTER_VALIDATE_EMAIL)){
			$error_message2 = 'Invalid email format.';
		}else if (empty($pwd)) {
			$error_message2 = 'Please enter a password.';
		} 
		else {


		$sql="SELECT Email, Discount_type, password from Customer where Email ='$email_search'";

		$check_result = mysql_query($sql);

		if (!mysql_query($sql)){
		  		die('Error : ' . mysql_error());
		}


        while ($row = mysql_fetch_assoc($check_result)) {  
          $checkEmail = $row['Email'];
          $checkPwd =  $row['password']; 
        } 



		if ($checkEmail != $email_search) {
				$error_message2 = "The user is not Registered.";
		} elseif (password_verify($pwd,$checkPwd) == false) {
            $error_message2 = "The password that you have entered is incorrect.";
        } else {

			// Store the Costumer
			$sql="UPDATE Customer SET Discount_type = '$_POST[discount_type]' WHERE Email= '$email_search' ";

		  	if (!mysql_query($sql)){
		  		 	die('Error : ' . mysql_error());
		  	}

			$sql="INSERT INTO Reservation (RoomID, Email, Checkin, Checkout, TotalCost, guestno)
		  		  	VALUES
		  		  ('$_POST[roomId]', '$_POST[email]','$_POST[datepicker_start]','$_POST[datepicker_end]','$_POST[totalprice]', '$_POST[guests]')";
		  		 	
		  	if (!mysql_query($sql)){
		  		 	die('Error : ' . mysql_error());
		  	}
		  		 		
		  		 	$count_days = 0	;
		  		 	while ( $count_days < $totaldays) {


		  		 		$date = strtotime("+$count_days day", strtotime("$datepicker_start"));
		  		 		echo "<br>";
						$days_reserved = date("Y-m-d", $date);

		  		 			$sql="INSERT INTO RoomSchedule(RoomID, reservedDate, RoomStatus)
		  		  				VALUES
		  		 				('$_POST[roomId]','$days_reserved', 'Reserved')";
					  		 	if (!mysql_query($sql)){
					  		 		die('Error : ' . mysql_error());
					  		 	}

					  	$count_days++;	 	
		  		 	}		
					header("Location: reservation_results.php");
		}
	}
}
      
?>

<!-- End of Error Checking   -->

<!-- Start HTML -->
<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">		
		<title>Chicago Inn</title>
		<!-- Custom CSS -->
	    <link rel="stylesheet" type="text/css" href="css/style.css"/> 

	    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
		<!-- Jquery and JqueryUI Connection -->

	    <script src="//code.jquery.com/jquery-1.10.2.js"></script>

	</head>

	<body>

		<?php 
		include 'navbar.php'
		?>

		<div class="container steps-box">
			<ul class="steps-booking">
				<li id="step1" >
					<div class="text">
						
						 	<span>1</span>
																								
						<span class="text">Select rooms</span>			
					</div>
					<div class="triangle"></div>
					<div class="triangle-white"></div>
				</li>
				<li id="step2" class="active">
					<div class="text">
						<span class="fa-stack fa-lg">
						 	<i class="fa fa-circle-thin fa-stack-2x"></i>
						 	<span>2</span>
						</span>
						<span>Personal details</span>
					</div>
					<div class="triangle"></div>
					<div class="triangle-white"></div>
				</li>
				<li id="step3">
					<div class="text">
						<span class="fa-stack fa-lg">
						 	<i class="fa fa-circle-thin fa-stack-2x"></i>
						 	<span>3</span>
						</span>
						<span>Confirmation</span>
					</div>
					<div class="triangle"></div>
					<div class="triangle-white"></div>
				</li>
			</ul>
		</div>

		<div class="container customer-reservation-holder">

			<div class="col-md-8 customer-reservation-form">
					<div id="content" class="row">
					    <h1>Customer Registration</h1>

					    <?php
					    if(!empty ($error_message)){ ?>
					      <p class="error"> 
					      <?php echo $error_message; ?>
					      </p>
					    <?php } ?>

					   
						    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
						        
							    <div id="data" class="col-md-8 ">
									<!-- Get First Name -->
									<label class="form-label" for="fname">First Name:</label>
									<input type="text" name="fname" id="fname" value= '<?php echo (isset($fname) ? $fname : null); ?>' />
									<br>
									<!-- Get Last Name -->
									<label class="form-label" for="fname">Last Name:</label>
									<input type="text" name="lname" id="lname" value= '<?php echo (isset($lname) ? $lname : null); ?>' />
									<br>
									<!-- Get Email-->	
									<label class="form-label" for="email">Email:</label>	
									<input type="text" name="email" id="email" value= '<?php echo (isset($email) ? $email : null); ?>' />
									<br>
									<!-- Password -->
									<label class="form-label" for="pwd">Password:</label>
				            		<input type="password" name="pwd" id="pwd" value= '<?php echo (isset($pwd) ? $pwd : null); ?>'>
									<br>
									<!-- Get Phone Number -->
									<label class="form-label" for="phonenumber">Phone Number:</label>
									<input type="text" name="phonenumber" id="phonenumber" value= '<?php echo (isset($phonenumber) ? $phonenumber : null); ?>' />
									<br>
									 <!-- Get Discount Type -->
						            <label class="form-label" for="discount_type">Discount Type:</label>
						              <select name='discount_type' id='discount_type'>

						                <option value="None" >None</option>
						                <option value="AAA">AAA</option>
						                <option value="government">Goverment</option>
						                <option value="senior">Senior</option>
						                
						              </select>
									
									<br>
									<input type="text" id="roomId" name="roomId" value="<?php echo $roomId ?>" hidden >
									<input type="text" name="datepicker_start" id="datepicker_start" value="<?php echo $startDate ?>"hidden >
									<input type="text" name="datepicker_end"   id="datepicker_end" value="<?php echo $lastDate ?>" hidden>
									<input type="text" id="totaldays" name="totaldays" value="<?php echo $days ?>"  hidden>
									
					
									<input type="text" id="totalprice" name="totalprice" hidden > 
									<input type="text" id="guests" name="guests" value="<?php echo $guests ?>" hidden >
									<input type="text" id="price" name="price" value="<?php echo $price ?>" hidden > 
									
								</div>
								<div class="total-price col-md-4" >
									<h4>Total price:</h4>
									<span class="value">$</span><p class="value" id="value_d"></p>
								</div>
								<!-- Submit Button -->
									<div class="reservation-btn">
										<input type="submit"  class="reservation-btn btn btn-success btn-lg " name="feedback" value="Submit">  			
									</div>
						</form>
						
						
					

					</div>
					<div id="content" class="row">
						<h1>Already Registered?</h1>

						<?php
					    if(!empty ($error_message2)){ ?>
					      <p class="error"> 
					      <?php echo $error_message2; ?>
					      </p>
					    <?php } ?>

						
							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
						        
							    <div id="data" class="col-md-8">
									<!-- Get Email-->	
									<label class="form-label" for="email">Email:</label>	
									<input type="text" name="email" id="email" value= '<?php echo (isset($email) ? $email : null); ?>' />
									<br>
									<!-- Password -->
									<label class="form-label" for="pwd">Password:</label>
				            		<input type="password" name="pwd" id="pwd" value= '<?php echo (isset($pwd) ? $pwd : null); ?>'>
									<br>
									 <!-- Get Discount Type -->
						            <label class="form-label" for="discount_type">Discount Type:</label>
						            <select name='discount_type' id='discount_type2'>

						                <option value="None" >None</option>
						                <option value="AAA">AAA</option>
						                <option value="government">Goverment</option>
						                <option value="senior">Senior</option>
						                
						            </select>
								
									<input type="text" id="roomId" name="roomId" value="<?php echo $roomId ?>" hidden >
									<input type="text" name="datepicker_start" id="datepicker_start" value="<?php echo $startDate ?>" hidden>
									<input type="text" name="datepicker_end"   id="datepicker_end" value="<?php echo $lastDate ?>" hidden>
									<input type="text" id="totaldays" name="totaldays" value="<?php echo $days ?>"  hidden>
									
									<input type="text" id="totalprice2" name="totalprice" hidden>
									<input type="text" id="guests" name="guests" value="<?php echo $guests ?>"  hidden>
									<input type="text" id="price" name="price" value="<?php echo $price ?>" hidden >
									
									
									
								</div>
								<div class="total-price col-md-4" >
										<h4>Total price:</h4>
										<span class="value">$</span><p class="value" id="value_d_2"></p>
									</div>
								<!-- Submit Button -->
									<div class="reservation-btn">
										<input type="submit"  class="reservation-btn btn btn-success btn-lg" name="user_register" value="Submit">  			
									</div>
									 			
							</form>
							
							
					</div> 
					

			</div>

			<div class="col-md-4 customer-reservation-price">
				<div class="summary">
					<h4>BOOKING SUMMARY</h4>
				</div>
				<div class="summary-details">
					<p>Arrival date: <span><?php echo $startDate ;?></span> </p> 
					<p>Departure Date: <span><?php echo $lastDate;?></span> </p> 
					<p>Number of Guests: <span><?php echo $guests  ;?></span> </p> 
					<p>Room Number: <span><?php echo $roomId  ;?></span> </p> 
				</div>

			</div>
		</div>

		<script src="js/days.js" type="text/javascript" charset="utf-8"></script>

		


	

	</body>
</html>

