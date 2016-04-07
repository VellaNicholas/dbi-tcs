<html>
	<head>
		<title>PHP Test</title>
	</head>
	<body>
		<?php
			// Connects to the DBITCS database
			$conn = oci_connect('web_app', 'password', 'dbi-tcs.c0nvd8yryddn.us-west-2.rds.amazonaws.com/DBITCS');

			$sql = 'BEGIN INSERT_STUDENT(:stuid, :firstname, :lastname, :email, :contactno); END;';

			$stuid = '100608129';
			$firstname = 'Nicholas';
			$lastname = 'Vella';
			$email = 'nicholas.vella@me.com';
			$contactno = '0400123456';

			$stmt = oci_parse($conn,$sql);
			
			//  Bind the input parameter
			oci_bind_by_name($stmt,':stuid',$stuid,32);
			oci_bind_by_name($stmt,':firstname',$firstname,32);
			oci_bind_by_name($stmt,':lastname',$lastname,32);
			oci_bind_by_name($stmt,':email',$email,32);
			oci_bind_by_name($stmt,':contactno',$contactno,32);
			
			oci_execute($stmt);
			oci_commit($conn);
		?>

		<?php echo '<p>Hello World</p>'; ?> 
	</body>
</html>
