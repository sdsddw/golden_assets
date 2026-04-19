<?php
// Development database configuration with full privileges
$host = "localhost";
$user = "goldoejd_dev";
$password = "DevPassword123";
$database = "goldoejd_app";
$charset = "UTF8";

$connect = mysqli_connect($host, $user, $password, $database);
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($connect, $charset);

echo "Database connection successful!<br>";
echo "User: $user<br>";
echo "Database: $database<br>";
echo "Server info: " . mysqli_get_server_info($connect) . "<br>";

// Test basic privileges
$result = mysqli_query($connect, "SHOW TABLES");
if ($result) {
    echo "<br>Tables in database:<br>";
    while ($row = mysqli_fetch_array($result)) {
        echo "- " . $row[0] . "<br>";
    }
} else {
    echo "Error showing tables: " . mysqli_error($connect);
}

mysqli_close($connect);
?> 