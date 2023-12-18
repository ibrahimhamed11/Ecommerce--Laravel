<!-- resources/views/add-product.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <div style="max-width: 600px; margin: auto; padding: 20px;">
        <h1 style="text-align: center; font-size: 24px; margin-bottom: 20px;">Add Product</h1>

        <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; font-size: 16px;">Product Name</label>
                <input type="text" name="name" id="name" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="quantity" style="display: block; font-size: 16px;">Quantity</label>
                <input type="number" name="quantity" id="quantity" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="image" style="display: block; font-size: 16px;">Product Image</label>
                <input type="file" name="image" id="image" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <button type="submit" style="background-color: #3490dc; color: #ffffff; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Add Product</button>
        </form>
    </div>
</body>
</html>
