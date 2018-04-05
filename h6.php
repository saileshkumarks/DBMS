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

<p>Please enter the first character of the last name or the first character of the first name of the customer:</p>

<form id="NamesForm" name="NamesForm" method="get" action="customer.php">
	<label for="LastName">First character of the last name:  </label>
		<select name="lastnameChar" id="LastNamesCharList">
			<option value="" selected></option>
  
			<?php  
				/* Populate drop down menu list  */
			$query = <<<__QUERY
			SELECT DISTINCT LEFT(A.LAST_NAME, 1) AS LNAME
			FROM CUSTOMER A
			ORDER BY 1 ASC;
__QUERY;

			$stmt = $mysqli->prepare($query);
			$stmt->execute();
			$stmt->bind_result($LastNameFirstLetter);
			while ($stmt->fetch())
			{
				// Assume no special HTML character
				echo "<option value=\"" . $LastNameFirstLetter . "\">$LastNameFirstLetter</option>\n";
			}
			$stmt->close();
			?>	
		</select>
	<p>or</p>
	<label for="FirstName">First character of the first name:  </label>
		<select name="firstnameChar" id="FirstNamesCharList">
			<option value="" selected></option>
		
			<?php  
			/* Populate drop down menu list  */
			$query = <<<__QUERY
			SELECT DISTINCT LEFT(A.FIRST_NAME, 1) AS FNAME
			FROM CUSTOMER A
			ORDER BY 1 ASC;
__QUERY;
	
			$stmt = $mysqli->prepare($query);
			$stmt->execute();
			$stmt->bind_result($firstnameChar);
		
			while ($stmt->fetch()) 
			{
				// Assume no special HTML character
				echo "<option value=\"" . $firstnameChar . "\">$firstnameChar</option>\n";
			}
			$stmt->close();
			?>	
		</select>
  
	<input type="submit" value="Submit"/>
</form>

</body>
</html>