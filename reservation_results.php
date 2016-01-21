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
				<li id="step2">
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
				<li id="step3" class="active">
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

		<div class=" container reservation-results-box ">
					<div >
						<h4>CONFIRMATION</h4>
					</div>
					<div class="summary-details">
						<p>Your reservation has been confirmed!</p>

						<p>Thank you for booking with us!</p>

						<p>Check you Reservation, <a href="login.php">Sign In</a> </p>
					</div>
		</div>
	    
	</body>
</html>



