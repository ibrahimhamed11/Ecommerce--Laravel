
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    @include('includes._navbar')

    <div id="app">


    <div class="container mt-5">
        <h1>Users</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>

                </tr>
            </thead>
            <tbody id="usersTableBody">
            </tbody>
        </table>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to fetch users and populate the table
            function fetchUsers() {
                fetch('/api/users', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const usersTableBody = document.getElementById('usersTableBody');
                    usersTableBody.innerHTML = ''; // Clear existing table rows

                    data.data.forEach(user => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.phone}</td>
                            <td>${user.role}</td>
                        `;
                        usersTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching users:', error));
            }



            fetchUsers();
        });


    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

</body>

</html>
