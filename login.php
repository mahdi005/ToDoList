<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'to-doist';


$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("connection failed: " . $connection->connect_error);
}


$user_name = $_POST['user_name'];
$pass = $_POST['pass'];

$query = "SELECT * FROM userpass WHERE user_name='$user_name' AND pass='$pass'";
$result = $connection->query($query);


if ($result->num_rows > 0) {
    $htmlContent = "
    <!DOCTYPE html>
    <html lang=\"en\">
    
    <head>
        <meta charset=\"UTF-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel=\"stylesheet\" href=\"style.css\">
    
        <title>Todoist</title>
        <?php include 'login.php'; ?>
    
        <script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
        <script src=\"script.js\" defer></script>
       
    
    
    
    </head>
    
    <body>

        <div class=\"navbar\">
            <a href=\"index.html\">Home</a>
            <a href=\"contactUs.html\">Contact us</a>
            <div class=\"dropdown\">
                <button class=\"dropbtn\">Dropdown
                    <i class=\"fa fa-caret-down\"></i>
                </button>
                <div class=\"dropdown-content\">
                    <a href=\"https://asana.com/resources/get-organized\">how to be organized?</a>
                    <a href=\"https://asana.com/resources/make-better-to-do-lists\">tips to make a good to-do list</a>
                    <a href=\"https://asana.com/resources/best-morning-routine\">build good habits</a>
                </div>
            </div>
            <a href=\"login.html\">Log out</a>
    
        </div>
        <div class=\"bg\"></div>
        <nav class=\"topBar\">
            <p id=\"welcme\">welcome user, wish you a good day!</p>
        </nav>
    
        <main class=\"app\">
            <p class=\"taskListTitle\">Today:</p>
            <button class=\"btnAddTask\" onclick=\"addTaskFun(user)\">add task</button>
            <nav class=\"taskList\">
                <div class=\"task\">
                    <div class=\"taskContainer\">
                        <p class=\"task_name\">water the plants 🪴</p>
                    </div>
                    <input type=\"checkbox\" class=\"task_checkBox\" id=\"c0\">
                    <button class=\"task_remove\" id=\"r0\"></button>
                </div>
    
            </nav>
        </main>
        <p id=\"userNameHtag\" hidden>$user_name</p>
        <nav class=\"botBar\">
            <div class=\"congrats\">Congrats! You've done 1 task so far</div>
        </nav>
    
    
    </body>
    
    
    </html>
";

// ذخیره محتوای HTML در یک فایل به نام index.html
    file_put_contents('index.html', $htmlContent);
    header("Location: index.html"); // هدایت کاربر به صفحه دیگر
    
} else {

    echo "wrong username or password!";
}
$conn->close();
?>


