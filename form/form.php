
<!--DataBase Connection-->
<?php

$link = mysql_connect('cnaiman.com', '4e1e1c335c7c', '2f73cca080ee7e56');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

mysql_select_db('fall15-groupsix', $link);

$sql="INSERT INTO Customer (Fname, Lname, Phone, Email, Discount_type)
VALUES
('$_POST[Fname]', '$_POST[Lname]','$_POST[phonenumber]','$_POST[email]','$_POST[discounttype]')";
 
if (!mysql_query($sql,$link))
  {
  die('Error: ' . mysql_error());
  }
echo "Record successfully added!";
 
mysql_close($link)
//End Of DataBase Connection 

?>

<?php 
	$Fname = $_POST['Fname'];
	$Lname = $_POST['Lname'];
	$phonenumber = $_POST['phonenumber'];
	$email = $_POST['email'];
	$discounttype = $_POST['discounttype'];
    
	//check if each field has a text value - give error message if they don't.
	//https://forums.adobe.com/thread/1159264
	$string_exp = "/^[A-Za-z .'-]+$/";
 	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	//Reference for preg-match: http://www.php.net/function.preg-match
	
	
	
	if (empty($Fname)) {
      $error_message = 'Please enter a valid first name';
	}else if (!preg_match($string_exp, $Fname) ){
		$error_message = 'The first name you entered does not appear to be valid';
	} 
	
	else if (empty($Lname)) {
		$error_message = 'Please enter a valid last name';
	}else if (!preg_match($string_exp, $Lname) ){
		$error_message = 'The last name you entered does not appear to be valid';
	} 
    
    else if (empty($phonenumber)) {
    	$error_message = 'Please enter a valid 10 digit phone number';
	}else if (!is_numeric($phonenumber)){
		$error_message = 'You must enter a valid phonenumber';
	}elseif (strlen($phonenumber)!= 10 ) {
       $error_message = 'Your phonenumber needs to be 10 digits';
    }
	//validate email address format - reference = http://www.w3schools.com/php/filter_validate_email.asp
	else if (empty($email)) {
		$error_message = 'Please enter a valid email';
	}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$error_message = 'Invalid email format';
	} 
	else if (empty($discounttype)) {
		$error_message = 'Please enter a valid discount type';
	//}else if (!preg_match_all('#\b(AAA|government|senior)\b#', $discounttype) ){
		//$error_message = 'The discount type you entered does not exist';
	}	
	
	else {
        $error_message = ''; }

	
	// if an error message exists, go to the index page and give error message
    if ($error_message != '') {
     include('index.php');
        exit();
    }
       
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Hotel Reservation Form</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
   	<div id="content">
        <h1>Hotel Reservation System</h1>
    <table width="300" border="3" cellpadding="5" cellspacing="2">
		
		<tr bgcolor="#FAFAFA">
	       	<td>
	       		<h5> First Name: </h5>
	       	</td>
	       	<td>
	       		<p><?php echo ($Fname) ?></p>
	       	</td>
	    </tr>
	    <tr bgcolor="#DFDFDF">
	       	<td>
	       		<h5> Last Name: </h5>
	       	</td>
	       	<td>
	       		<p><?php echo ($Lname) ?></p>
	       	</td>
	    </tr>
	    <tr bgcolor="#FAFAFA">
			<td>
	       		<h5> Phone Number: </h5>
	       	</td>
	       	<td>
	       		<p><?php echo ($phonenumber) ?></p>
	       	</td>
	    </tr>
	    <tr bgcolor="#DFDFDF">
			<td>
	       		<h5> Email: </h5>
	       	</td>
	       	<td>
	       		<p><?php echo ($email) ?></p>
	       	</td>
	    </tr>
		<tr bgcolor="#FAFAFA">
	       	<td>
	      		<h5> Discount Type: </h5>
	      	</td>
	       	<td>
	      		<p><?php echo ($discounttype) ?></p>
	       	</td>
		</tr>
	</table>
	<br><br>
	<div>
		<a href="index.php"><input type="button" value="Return To Form " /></a>
	</div>
	</div>

</body>
</html>
