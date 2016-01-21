<!-- Variables -->
<?php
$startDate = $_GET['datepicker_start'];
$lastDate = $_GET['datepicker_end'];
$category =  $_GET['category'];
$guests = $_GET['guests'];
$days = $_GET['totaldays'];
$available_rooms [] = array();;

$month = date('n', strtotime($startDate) );

	if ( $month == 12 || $month == 1 || $month == 2) {
		$season = 'winter';
	} elseif ( $month == 3 || $month == 4 || $month == 5) {
		$season = 'spring';
	}
	  elseif ( $month == 6 || $month == 7 || $month == 8) {
		$season = 'summer';
	}
	else{
		$season = 'autumn';
	}
?>
<!-- End of Variables -->

<!-- DataBase Connection -->

<?php

include 'db.php';

$sql = "SELECT RoomID FROM Rooms WHERE Rooms.Category='$category' AND Rooms.RoomID not In (SELECT RoomID from RoomSchedule
        where reservedDate >='$startDate' AND reservedDate<='$lastDate') ";

$result = mysql_query($sql);

// Store in Array Available Rooms
$count = 0;

while ($row = mysql_fetch_assoc($result)){
		// echo var_dump($row);
		$available_rooms[$count] = $row['RoomID'];
        $count++;
	}
        
$roomId =  $available_rooms[0]  ;

// Get Price
$pricesql = " SELECT Price FROM Price where Category='$category' and Season='$season' ";

$result_price = mysql_query($pricesql);
	while ($row = mysql_fetch_assoc($result_price)){
        $price = $row["Price"];
    }
?>
<!-- End Of DataBase Connection -->

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
			include 'navbar.php'
		?>

		<div class="container steps-box">
			<ul class="steps-booking">
				<li id="step1" class="active">
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
		<div class="container search-results-box">
			<?php
			if (empty($roomId) || $startDate == '' || $lastDate == '') {
					include 'rooms/norooms.php';
			} else {

				if ( $category == 'double' ) {
					include 'rooms/double.php';
				}  elseif ( $category == 'single' ) {
					include 'rooms/single.php';
				} elseif ( $category == 'twin') {
					include 'rooms/twin.php';
				} else {
					include 'rooms/suite.php';
				}

			?>

			<form action="reservation.php" method="post"> 
				<input type="text" name="datepicker_start" id="datepicker_start" value="<?php echo $startDate ?>" hidden >
				<input type="text" name="datepicker_end"   id="datepicker_end" value="<?php echo $lastDate ?>" hidden>
				<input type="text" id="totaldays" name="totaldays" value="<?php echo $days ?>" hidden >
				<input type="text" id="roomId" name="roomId" value="<?php echo $roomId ?>"   hidden>
				<input type="text" id="guests" name="guests" value="<?php echo $guests ?>"   hidden>
				<input type="text" id="price" name="price" value="<?php echo $price ?>"  hidden >
				<br>
				<input id="room-reserve-button" class="btn btn-success btn-lg btn-block" type="submit" value="Reserve">
			</form>


			<?php
			}
			?>
			</div>
		</div>	
	</body>
</html>



