<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSCI 5333.2 DBMS Spring 2016 HW #6 1447242</title>
</head>

<?php
	//  Minimally documented.
	include('dbconfig_sakila.php');
?>
<body>

<?php
	if (array_key_exists('lastnameChar', $_GET)) 
	{
		// Checking is not actually needed as the HTTP parameter 
        // is assumed to be validly valued.
		$lastNameChar = $_GET['lastnameChar'];
	}
	
	if (array_key_exists('firstnameChar', $_GET)) 
	{
		// Checking is not actually needed as the HTTP parameter 
        // is assumed to be validly valued.
		$firstNameChar = $_GET['firstnameChar'];
	}

	echo "<p>Please click the customer link to see brief information of the customer.";
  
	/* Get all films with the specified first char of the last name / first name.  */
	if(empty($firstNameChar))
	{
		$query="SELECT 
		DISTINCT A.CUSTOMER_ID, 
		CONCAT(A.FIRST_NAME, ' ', A.LAST_NAME) AS NAME, 
		CASE A.ACTIVE WHEN 1 THEN 'active' WHEN 0 THEN 'inactive' END AS STATUS 
		FROM CUSTOMER A 
		WHERE A.LAST_NAME LIKE '$lastNameChar%' 
		ORDER BY 1 ASC;";
		goto A;	
	}
	elseif(empty($lastNameChar))
	{
		$query="SELECT 
		DISTINCT A.CUSTOMER_ID, 
		CONCAT(A.FIRST_NAME, ' ', A.LAST_NAME) AS NAME, 
		CASE A.ACTIVE WHEN 1 THEN 'active' WHEN 0 THEN 'inactive' END AS STATUS 
		FROM CUSTOMER A WHERE A.FIRST_NAME LIKE '$firstNameChar%' ORDER BY 1 ASC;";
		goto A;
	}

	A:
		$stmt = $mysqli->prepare($query);
		$stmt->bind_result($customerId, $name, $status);
		$stmt->execute();
		$stmt->store_result();
		echo "<ul>";
		while ($stmt->fetch()) 
		{
			// Assume no special HTML character
			echo "<li><a href=\"showCustomer.php?customerId=$customerId\">$name</a>: $status</li>";
		}
		$stmt->close();
		echo "</ul>";
?>

</body>
</html>