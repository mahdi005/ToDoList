<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "to-doist";

$conn = new mysqli($servername, $username, $password, $dbname);

// چک کردن اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// دریافت مقادیر ارسال شده از طریق POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['userName'];
    $newTask = $_POST['task'];

    // گرفتن مقدار قبلی از دیتابیس برای userName
    $sql = "SELECT tasks FROM usertasks WHERE user_name = '$userName'"; // yourTableName نام جدول مربوطه است
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $previousTasks = $row['tasks'];

        // اضافه کردن عنصر جدید به مقدار قبلی با جداکننده comma
        if (!empty($previousTasks)) {
            $newTasks = $previousTasks . ',' . $newTask;
        } else {
            $newTasks = $newTask;
        }

        // بروزرسانی مقدار در دیتابیس برای userName
        $updateSql = "UPDATE usertasks SET tasks = '$newTasks' WHERE user_name = '$userName'";
        if ($conn->query($updateSql) === TRUE) {
            echo "Task added successfully";
        } else {
            echo "Error: " . $updateSql . "<br>" . $conn->error;
        }
    } else {
        echo "No results found for the user";
    }
}

$conn->close();
?>
