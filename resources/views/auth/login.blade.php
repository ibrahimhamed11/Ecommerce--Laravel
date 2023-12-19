<!-- login.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Login</h4>
                </div>

                <div class="card-body">
                    <form id="loginForm">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <button type="button" class="btn btn-primary btn-block mt-3" onclick="login()">Login</button>
                    </form>
                    <div id="errorMessages" class="text-danger mt-3"></div>

                    <!-- Add a registration link -->
                    <p class="mt-3">Don't have an account? <a href="/register">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    // inline script containing the login function
    function login() {
        const form = document.getElementById('loginForm');
        const errorMessages = document.getElementById('errorMessages');

        // Reset error messages
        errorMessages.innerHTML = '';

        // Create FormData object to send form data
        const formData = new FormData(form);

        // Make a POST request to the login API endpoint
        fetch('http://localhost:8000/api/login', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // Display validation errors or login failure message
                if (data.error instanceof Object) {
                    for (const key in data.error) {
                        if (data.error.hasOwnProperty(key)) {
                            errorMessages.innerHTML += `<p>${data.error[key][0]}</p>`;
                        }
                    }
                } else {
                    errorMessages.innerHTML = `<p>${data.error}</p>`;
                }
            } else {

                // Successful login, store token in local storage
localStorage.setItem('token', data.token);

                // Successful login, redirect or handle as needed
                confirm('Login successful');
                 window.location.href = '/dashboard';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>
