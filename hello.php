<html>
 	<head>
  		<title>PHP Test</title>
 	</head>
 	<body>
		<?php
			// Connects to the XE service (i.e. database) on the "localhost" machine
			$conn = oci_connect('s100608129', '-------', 'db.nicholaslvella.com/DBITCS');
			if (!$conn) {
			    $e = oci_error();
			    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			} else { 
				echo "Connected to Database";
			}
		
			$stid = oci_parse($conn, 'SELECT * FROM Employee');
			oci_execute($stid);
			
			echo "<table border='1'>\n";
			echo "<tr> <td><strong>EmpId</strong></td> <td>FirstName</td> <td>Surname</td> <td>Email</td> <td>Phone</td> </tr> ";
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


