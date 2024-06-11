<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "to-doist";
// ایجاد connection
$conn = new mysqli($servername, $username, $password, $dbname);

// // چک کردن ارتباط
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$user__name = $_POST['username']; 

// ساخت query
$sql = "SELECT tasks FROM usertasks WHERE user_name = '$user__name'";

$result = $conn -> query($sql);

if ($result->num_rows > 0) {
  // دریافت داده و قرار دادن آن در یک متغیر
  $row = $result->fetch_assoc();
  $tasksSTR = $row["tasks"];
  echo $tasksSTR; // ارسال مقدار به برنامه JavaScript
} else {
  
}
$conn->close();
?>
