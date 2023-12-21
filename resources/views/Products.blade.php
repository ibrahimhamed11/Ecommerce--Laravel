<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

        @include('includes._navbar')
    <div class="container mt-5"  id="app">
        <div class="card mx-auto" style="max-width: 800px;">
            <div class="card-header">
                <h2 class="text-center">Product Management</h2>
            </div>
            <div class="card-body">
                <form id="addProductForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <small id="nameError" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity">
                        <small id="quantityError" class="text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                        <small id="imageError" class="text-danger"></small>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="addProduct()">Add Product</button>
                </form>

<h2 class="text-center mb-4 font-weight-bold" style="color: #3490dc; ">Products</h2>
                <ul id="productList" class="list-group mt-3">
                </ul>

                <!-- Success message -->
                <div id="successMessage" class="mt-3" style="display: none;">
                    <div class="alert alert-success" role="alert">
                        Product added successfully!
                    </div>
                </div>

                <!-- Error message -->
                <div id="errorMessage" class="mt-3" style="display: none;">
                    <div class="alert alert-danger" role="alert">
                        There was an error adding the product. Please check the form and try again.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        // Function to extract image name from path
        function getImageNameFromPath(imagePath) {
            // Split the path using '/' and get the last part
            const pathParts = imagePath.split('/');
            const imageName = pathParts[pathParts.length - 1];
            return imageName;
        }






// Function to display a product in the list
function displayProduct(product) {
    const productList = document.getElementById('productList');
    // Check if the image property is null
    const imageName = product.image ? getImageNameFromPath(product.image) : '';
    // Parse the created_at date string
    const createdAtDate = new Date(product.created_at);
    const formattedDate = `${createdAtDate.getDate()} ${monthNames[createdAtDate.getMonth()]} ${createdAtDate.getFullYear()} ${createdAtDate.getHours()}:${createdAtDate.getMinutes()}`;


    // Create list item for the product
    const listItem = document.createElement('li');
    listItem.classList.add('list-group-item');
    listItem.innerHTML = `
        <div class="d-flex justify-content-between">
            <div>
                <h5>${product.name}</h5>
                <p>Quantity: ${product.quantity}</p>
                <p>Created At: ${formattedDate}</p>
                ${product.image ? `<img src="http://127.0.0.1:8000/image/${imageName}" alt="Product Image" style="max-width: 200px; max-height: 200px;">` : 'No image available'}

                <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id})">Delete</button>

            </div>
        </div>
    `;

    productList.appendChild(listItem);
}
const monthNames = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

        function refreshProductList() {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';

            const token = localStorage.getItem('token');
            fetch('/api/products', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(product => {
                    displayProduct(product);
                });
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
        }

        function deleteProduct(productId) {
            const token = localStorage.getItem('token');
            fetch(`/api/products/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
            })
            .then(response => {
                if (response.ok) {
                    refreshProductList();
                } else {
                    console.error('Error deleting product:', response.status);
                }
            })
            .catch(error => {
                console.error('Error deleting product:', error);
            });
        }

        function addProduct() {
            const formData = new FormData(document.getElementById('addProductForm'));

            const token = localStorage.getItem('token');

            fetch('/api/products', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    displayValidationErrors(data.error);
                } else {
                    document.getElementById('successMessage').style.display = 'block';

                    document.getElementById('errorMessage').style.display = 'none';

                    refreshProductList();
                }
            })
            .catch(error => {
                console.error('Error adding product:', error);

                document.getElementById('successMessage').style.display = 'none';

                document.getElementById('errorMessage').style.display = 'block';
            });
        }

        function displayValidationErrors(errors) {
            document.getElementById('nameError').textContent = errors.name ? errors.name[0] : '';
            document.getElementById('quantityError').textContent = errors.quantity ? errors.quantity[0] : '';
            document.getElementById('imageError').textContent = errors.image ? errors.image[0] : '';
        }
        refreshProductList();
    </script>
</body>
</html>
