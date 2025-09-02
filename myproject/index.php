<?php
$product_name = $category = $price = $stock_quantity = $expiration_date = $status = "";
$product_name_error = $category_error = $price_error = $stock_quantity_error = $expiration_date_error = $status_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = trim(htmlspecialchars($_POST["product_name"]));
    $category = trim(htmlspecialchars($_POST["category"]));
    $price = trim(htmlspecialchars($_POST["price"]));
    $stock_quantity = trim(htmlspecialchars($_POST["stock_quantity"]));
    $expiration_date = trim(htmlspecialchars($_POST["expiration_date"]));
    $status = trim(htmlspecialchars($_POST["status"]??''));

    if (empty($product_name)) {
        $product_name_error = "Product name is required";
    }

    if (empty($category)) {
        $category_error = "Category is required";
    }

    if (empty($price) && $price !== "0") {
        $price_error = "Price is required";
    } else if (!is_numeric($price) || $price<1) {
        $price_error = "Price must be a valid number and should greater than 0";
    }

    if (empty($stock_quantity)) {
        $stock_quantity_error = "Stock is required";
    } else if (!is_numeric($stock_quantity)) {
        $stock_quantity_error = "Stock must be a number";
    } else if (($stock_quantity) < 0) {
        $stock_quantity_error = "Stock cannot be negative";
    }

    if (empty($expiration_date)) {
        $expiration_date_error = "Expiration date is required";
    } else if (strtotime($expiration_date) < strtotime(date("Y-m-d"))) {
        $expiration_date_error = "Expiration date cannot be in the past";
    }

    if (empty($status)) {
        $status_error = "Status is required";
    }

    if (
        empty($product_name_error) && empty($category_error) && empty($price_error) &&empty($stock_quantity_error) && empty($expiration_date_error) && empty($status_error)
    ) {

        header("Location: redirect.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- When I change the form method to POST and submit the form, the data I enter doesn’t appear in the browser’s URL.
        The server still receives the information, but it is sent hidden in the request. The difference between GET and
        POST is that GET shows the data in the URL and is less secure, while POST keeps the data hidden and is more secure. -->
    <form action="" method="POST">
        <div class="form-field">
            <label>Product Name:</label>
            <input type="text" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>"><br>
            <p class="error"><?php echo $product_name_error; ?></p>

            <label>Category:</label><br>
            <select name="category">
                <option value="">-- Select Category --</option>
                <option value="Category A" <?php if ($category == "Category A") echo "selected"; ?>>Category A </option>
                <option value="Category B" <?php if ($category == "Category B") echo "selected"; ?>>Category B </option>
                <option value="Category C" <?php if ($category == "Category C") echo "selected"; ?>>Category C </option>
                <option value="Category D" <?php if ($category == "Category D") echo "selected"; ?>>Category D </option>
            </select> <br>
            <p class="error"><?php echo $category_error; ?></p>

            <label>Price (&#8369;)</label><br>
            <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>"><br>
            <p class="error"><?php echo $price_error; ?></p>

            <label>Stock Quantity</label><br>
            <input type="number" name="stock_quantity" min="0" value="<?php echo htmlspecialchars($stock_quantity); ?>"><br>
            <p class="error"><?php echo $stock_quantity_error; ?></p>

            <label>Expiration Date:</label><br>
            <input type="date" name="expiration_date" value="<?php echo htmlspecialchars($expiration_date); ?>"><br>
            <p class="error"><?php echo $expiration_date_error; ?></p>
        
            <div class="status-group">
            <label>Status:</label><br>
            <input type="radio" name="status" value="active" <?php if ($status == "active") echo "checked" ?>> Active<br>
            <input type="radio" name="status" value="inactive" <?php if ($status == "inactive") echo "checked" ?>> Inactive<br><br>
            <p class="error"><?php echo $status_error; ?></p>
        </div>
        </div>
        <div class="btn-submit">
            <input type="submit" value="Save Product">
        </div>
    </form>


</body>

</html>