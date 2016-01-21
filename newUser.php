<!-- DataBase Connection -->
     <?php
		  include 'db.php';
	?>
<!-- End Of DataBase Connection -->
<!-- Error Checking for First Form -->
<?php 

	if($_POST && isset($_POST['feedback'],
						$_POST['fname'], 
						$_POST['lname'], 
						$_POST['phonenumber'], 
						$_POST['email'], 
						$_POST['pwd'], 
						$_POST['discount_type']
					   )) {

	    $fname = $_POST['fname'];
	    $lname = $_POST['lname'];
	    $email = $_POST['email'];
	    $pwd = $_POST['pwd'];
		$phonenumber = $_POST['phonenumber'];
		$discount_type = $_POST['discount_type'];

  		$pwdHash=password_hash($pwd,PASSWORD_DEFAULT);


	    //  Set Regular Expressions
	    $string_exp = "/^[A-Za-z .'-]+$/";
 		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	
		if (empty($fname)) {
	      $error_message = 'Please enter a valid first name';
		} else if (!preg_match($string_exp, $fname) ){
			$error_message = 'The first name you entered has an unexpected character.';  
		} else if (empty($lname)) {
				$error_message = 'Please enter a valid last name';
		} else if (!preg_match($string_exp, $lname) ){
			$error_message = 'The last name you entered has an unexpected character.';
		} else if (empty($phonenumber)) {
	    	$error_message = 'Please enter a valid 10 digit phone number';
		} else if (!is_numeric($phonenumber)){
			$error_message = 'You must enter a valid phonenumber';
		} elseif (strlen($phonenumber)!= 10 ) {
	        $error_message = 'Your phonenumber needs to be 10 digits';
	    } else if (empty($pwd)) {
			$error_message = 'Please enter a password';
		} else if (empty($lname)) {
				$error_message = 'Please enter a valid last name';
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$error_message = 'Invalid email format';
		} 
		else {

			// Store the Costumer
			$sql="INSERT INTO Customer (Fname, Lname, Phone, Email, Discount_type, password)
		  		  VALUES
		  		  ('$_POST[fname]', '$_POST[lname]','$_POST[phonenumber]','$_POST[email]','$_POST[discount_type]','$pwdHash')";
		  	

		  	if (!mysql_query($sql)){
		  		if (mysql_errno() == 1062) {
    				$error_message = "That email already exits";
				}	
			}  else{ 		
					header("Location: userAccount.php");
				} 	
    	}
	 } //Eror Checking First form.
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

  		<?php
      		include 'navbar.php';
   		?> 
		
   		<div class="login container">
			<h3>Customer Registration</h3>

				    <?php
				    if(!empty ($error_message)){ ?>
				      <p class="error"> 
				      <?php echo $error_message; ?>
				      </p>
				    <?php } ?>

				    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
				        
					    <div id="data">
							<!-- Get First Name -->
							<label class="form-label" for="fname">First Name:</label>
							<input type="text" name="fname" id="fname" value= '<?php echo (isset($fname) ? $fname : null); ?>' />
							<br>
							<!-- Get Last Name -->
							<label class="form-label" for="fname">Last Name:</label>
							<input type="text" name="lname" id="lname" value= '<?php echo (isset($lname) ? $lname : null); ?>' />
							<br>
							<!-- Get Email-->	
							<label  class="form-label" for="email">Email:</label>	
							<input type="text" name="email" id="email" value= '<?php echo (isset($email) ? $email : null); ?>' />
							<br>
							<!-- Get Password -->
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
						
							<!-- Submit Button -->
							<input  class="login-btn btn btn-primary btn-lg" type="submit" name="feedback" value="Submit">  			
						</div>
					</form>
		</div>
	</body>
</html>
