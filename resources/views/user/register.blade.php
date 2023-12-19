<!-- registration.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-bottom: 0;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    /* Add a style for success messages */
    .text-success {
        color: #28a745;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Register</h4>
                </div>

                <div class="card-body">
                    <!-- Container for success messages -->
                    <div id="successMessage" class="text-success mt-3"></div>

                    <form id="registerForm">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <!-- Container for validation errors -->
                            <div id="nameError" class="text-danger"></div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            <div id="emailError" class="text-danger"></div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                            <div id="phoneError" class="text-danger"></div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <div id="passwordError" class="text-danger"></div>
                        </div>

                        <button type="button" class="btn btn-primary btn-block mt-3" onclick="register()">Register</button>
                    </form>

                    <div id="errorMessages" class="text-danger mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    function register() {
        const registerForm = document.getElementById('registerForm');
        const successMessage = document.getElementById('successMessage');
        const errorMessages = document.getElementById('errorMessages');

        // Reset messages
        successMessage.innerHTML = '';
        errorMessages.innerHTML = '';

        // Create FormData object to send form data
        const formData = new FormData(registerForm);

        // Make a POST request to the register API endpoint
        fetch('http://localhost:8000/api/register', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // Display validation errors or registration failure message
                if (data.error instanceof Object) {
                    for (const key in data.error) {
                        if (data.error.hasOwnProperty(key)) {
                            // Display validation errors under each input field
                            const errorContainer = document.getElementById(`${key}Error`);
                            if (errorContainer) {
                                errorContainer.innerHTML = `<p>${data.error[key][0]}</p>`;
                            }
                        }
                    }
                } else {
                    // Display overall registration failure message
                    errorMessages.innerHTML = `<p>${data.error}</p>`;
                }
            } else {
                // Successful registration, display success message
                successMessage.innerHTML = '<p>Registration successful! Redirecting to login page.</p>';

                // Redirect to the login page after a short delay
                setTimeout(() => {
// Redirect to the login page immediately
window.location.href = '/login';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>
