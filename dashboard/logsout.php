<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include iziToast CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iziToast/1.4.0/iziToast.min.css">
    <!-- Include iziToast JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iziToast/1.4.0/iziToast.min.js"></script>
</head>
<body>
    <!-- <button id="logout-button">Logout</button> -->

    <script>
        $(document).ready(function() {
            console.log("Document ready!");
            if (confirm("Are you sure you want to log out?")) {
                    // If user clicks "Yes," call the logout function
                    logout();
                }

            // Attach click event to the logout button
            $('#logout-button').click(function() {
                // Show confirmation dialog
                if (confirm("Are you sure you want to log out?")) {
                    // If user clicks "Yes," call the logout function
                    logout();
                }
            });
        });

        // Logout function
        function logout() {
            $.ajax({
                url: 'logout.php', // Path to the logout script
                method: 'POST',
                data: {}, // No additional data needed for logout
                success: function(response) {
                    // Parse the JSON response
                    var responseData = $.parseJSON(response);
                    console.log(responseData.message);

                    // Show success notification using iziToast
                    iziToast.show({
                        title: 'Notification',
                        message: responseData.message,
                        position: 'topRight',
                        color: 'green',
                    });

                    // Redirect to the login page after a short delay
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000); // 2-second delay before redirect
                },
                error: function(xhr, status, error) {
                    // Show error notification using iziToast
                    iziToast.error({
                        title: 'Error',
                        message: 'An error occurred: ' + error,
                        position: 'topRight',
                    });
                }
            });
        }
    </script>
</body>
</html>