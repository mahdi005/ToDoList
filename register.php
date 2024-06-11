

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "to-doist";

// ساخت اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// چک کردن اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// دریافت اطلاعات از فرم
$user_name = $_POST['user_name'];
$pass = $_POST['pass'];
$e_mail = $_POST['e_mail'];

// Query برای درج اطلاعات در دیتابیس
$sql = "INSERT INTO userpass (user_name, pass, e_mail) VALUES ('$user_name', '$pass', '$e_mail')";

if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$sql = "INSERT INTO usertasks (user_name) VALUES ('$user_name')";

$result = $conn -> query($sql);


// بستن اتصال
$conn->close();
?>