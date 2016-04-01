<html>
 	<head>
  		<title>PHP Test</title>
 	</head>
 	<body>
		<?php
			//establishes connection to the database, and outputs either 'Connected' or an Oracle exception
			$conn = oci_connect('s100608129', 'jxAsPZN2', 'db.nicholaslvella.com/DBITCS');
			if (!$conn) {
			    $e = oci_error();
			    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			} else { 
				echo "Connected to Database";
			}
		
			//prepares and executes the SQL Statement
			$stid = oci_parse($conn, 'SELECT * FROM Employee');
			oci_execute($stid);
			
			//creates a table, populating it with data from the SQL statement
			echo "<table border='1'>\n";
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			    echo "<tr>\n";
			    foreach ($row as $item) {
			        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES	) : "&nbsp;") . "</td>\n";
			    }
			    echo "</tr>\n";
			}
			echo "</table>\n";
			
			?>
		
		
		<?php echo '<p>Hello World</p>'; ?> 
 	</body>
</html>


