<?php   
require_once 'config.php';
session_start();


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $admin_email = $_POST['username'];
    $password = $_POST['password'];


    $query = "SELECT * FROM administrator WHERE Admin_Email = '$admin_email'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);

    if(!empty($admin_email) || !empty($password))
      {
        if($password == $row['Password']){
            $_SESSION['email'] = $row['Admin_Email'];
            $_SESSION['username'] = $row['Admin Name'];
            
            $email = $_SESSION['email'];
            $user = $_SESSION['username'];
            $response = array('message' => 'You are successfully logged in', 'email' => $email, 'username' => $user);

    
            

        }else{
            $response = array('message' => 'Your password is incorrect');
        }  
      }
      else{
        $response = array('message' => "Email or password empty");
      }    
    mysqli_close($connect);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
</head>
<body>

<form>
    <label for="Username">Email</label>
    <input type="text" id="inputed">
    <label for="password">Password</label>
    <input id="password"type="password">
    <button>ADMIN LOGIN</button>
</form>
    
</body>
<script>
$(document).ready(()=>{
   $('button').click((e)=>{
       e.preventDefault();
        
    var username = document.getElementById('inputed').value;
    var password = document.getElementById('password').value;
    console.log(username, password)

    $.ajax({
                    dataType: 'JSON',
                    url: 'admin.php',
                    type: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    beforeSend: function (xhr) {

                    },
                    success: function (response) {
                        console.log(response.message)
                        console.log(response.email)
                        console.log(response.username)
                         if(response.email){
                             window.location.href = "/admin/dashboard.php";
                         }


                        //var done = $('.balance_database').text(response.databaseBalance);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("AJAX Error: " + textStatus + ", " + errorThrown);
                    },
                    complete: function () {
                    }
                });
   })
});
</script>
</html>