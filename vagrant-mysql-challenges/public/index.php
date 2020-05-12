<?php

// setup connection
$db_server = "localhost";
$db_username = "root";
$db_password = "root";
$db_database = "vet_practice";

// Create connection
$db_connection = new mysqli($db_server, $db_username, $db_password, $db_database);

// Check connection
if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
}// else {
//     echo "Database Connected\n\n";
// }

// Build Select Query
$query = 'SELECT full_name AS "Pet Name", dob AS "Birthday",
TIMESTAMPDIFF(YEAR,dob,CURDATE()) AS age
FROM animals ORDER BY age;';

$result = mysqli_query($db_connection, $query);

// if (mysqli_num_rows($result) > 0){
// 	while($row = mysqli_fetch_assoc($result)){
// 		var_dump($row);
// 	}
// }

if (mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		echo $row['Pet Name'].' is '.$row['age'].' years old! He was born '.$row['Birthday'];
echo '<br />';
	}
}