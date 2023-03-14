<?php
$servername = "localhost";
$username = "server";
$password = "temppassword";
$dbname = "bank";

$numberOfDesiredBytes = 16;
$cookies = null;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// get username and password from user
$reg_username = readline($prompt = "Enter your username: ");
$reg_password = readline($prompt = "Enter your password: ");

// verify that the username is inside a bound
if (strlen($reg_username) > 20 || strlen($reg_username) < 5) {
  echo "Username must be between 5 and 20 characters";
  exit();
}

// verify that the password is inside a bound
if (strlen($reg_password) > 20 || strlen($reg_password) < 5) {
  echo "Password must be between 5 and 20 characters";
  exit();
}

// verify that the username is not already taken
$sql = "SELECT username FROM users WHERE username = '$reg_username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "Username already taken";
  exit();
}

// initialize a salt value for the user
$salt = random_bytes($numberOfDesiredBytes);

// enter the data into the database
$sql = "INSERT INTO users (username, password, salt, cookies)
VALUES ('$reg_username', '$reg_password', '$salt', '$cookies');";

$conn->exec($sql);
echo "New record created successfully";

// close the connection
$conn->close();

?>