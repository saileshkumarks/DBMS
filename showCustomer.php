<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSCI 5333.2 DBMS Spring 2016 HW #6 1447242</title>
</head>

<body>
<?php
   include('dbconfig_sakila.php');
   
   if (array_key_exists('customerId', $_GET)) 
   {
	   $customerId = $_GET['customerId'];
   }
   
   $query0 = "SELECT
	CONCAT(A.FIRST_NAME, ' ', A.LAST_NAME) AS CUSTOMER_NAME
	FROM  CUSTOMER A
	WHERE A.CUSTOMER_ID = ?;";

	if ($stmt0 = $mysqli->prepare($query0)) 
	{
		$stmt0->bind_param('i', $customerId);
		$stmt0->execute();
		$stmt0->bind_result($customerName);
		$stmt0->store_result();
		
		if ($stmt0->num_rows > 0) 
		{
			while ($stmt0->fetch()) 
			{
				echo "The customer $customerName (id $customerId) has rented ";
			}
	
			$stmt0->free_result();
		}
	}
    $query1 = <<<__QUERY
	SELECT COUNT(Y.CATEGORY) AS CAETGORIES, SUM(Y.NUMBER_RENTED) AS FILMS FROM
	(SELECT A.NAME AS Category, COUNT(B.FILM_ID) AS NUMBER_RENTED
	FROM CATEGORY A, FILM B,  RENTAL C, INVENTORY D, FILM_CATEGORY E
	WHERE C.INVENTORY_ID = D.INVENTORY_ID
	AND D.FILM_ID = B.FILM_ID
	AND B.FILM_ID = E.FILM_ID
	AND E.CATEGORY_ID = A.CATEGORY_ID
	AND C.CUSTOMER_ID = ?
	GROUP BY A.NAME
	ORDER BY 2 DESC, 1 ASC)Y;
__QUERY;

	if ($stmt1 = $mysqli->prepare($query1)) 
	{
		$stmt1->bind_param('i', $customerId);
		$stmt1->execute();
		$stmt1->bind_result($category, $count);
		$stmt1->store_result();
    
		if ($stmt1->num_rows > 0) 
		{
			while ($stmt1->fetch()) 
			{
				echo "$count films in $category categories.";
			}

			$stmt1->free_result();
		}
	}
?>
	<br>
<?php
   //  Get category name, film counts and actor counts
   $query = <<<__QUERY
	SELECT A.NAME AS Category, COUNT(B.FILM_ID) AS NUMBER_RENTED
	FROM CATEGORY A, FILM B,  RENTAL C, INVENTORY D, FILM_CATEGORY E
	WHERE C.INVENTORY_ID = D.INVENTORY_ID
	AND D.FILM_ID = B.FILM_ID
	AND B.FILM_ID = E.FILM_ID
	AND E.CATEGORY_ID = A.CATEGORY_ID
	AND C.CUSTOMER_ID = ?
	GROUP BY A.NAME
	ORDER BY 2 DESC, 1 ASC;
__QUERY;

	if ($stmt = $mysqli->prepare($query)) 
	{
		$stmt->bind_param('i', $customerId);
		$stmt->execute();
		$stmt->bind_result($category, $count);
		$stmt->store_result();
    
		if ($stmt->num_rows > 0) 
		{
			echo "<table border=\"1\"><tr><th>Actor</th><th>Number of films rented</th></tr>\n";
			while ($stmt->fetch()) 
			{
				echo "<tr><td>$category</td><td>$count</td></tr>\n";
			}
			echo "</table>";
			$stmt->free_result();
		}
	}

	$mysqli->close();
?>

</body>
</html>