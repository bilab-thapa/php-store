<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Details</title>
    <link rel="stylesheet" href="delivery_details.css">
</head>

<body>
<header>
    <div class="logo">
        <a href="index.php">
            <img src="./images/output.jpg" alt="Ecommerce Logo">
        </a>
    </div>
    <h1>HEALTHY GROCERY</h1>
</header>
    <main>
        <section>
            <h2>Delivery Details</h2>
            <form id="deliveryForm" action="process_order.php" method="post">

                <input type="text" disabled hidden id="productNames" name="productNames">

                <label for="recipientName">Recipient's Name:</label>
                <input type="text" id="recipientName" name="recipientName" required>

                <label for="street">Street:</label>
                <input type="text" id="street" name="street" required>

                <label for="city">City/Suburb:</label>
                <input type="text" id="city" name="city" required>

                <label for="state">State:</label>
                <select id="state" name="state" required>
                    <option value="">Select State</option>
                    <option value="NSW">NSW</option>
                    <option value="VIC">VIC</option>
                    <option value="QLD">QLD</option>
                    <option value="WA">WA</option>
                    <option value="SA">SA</option>
                    <option value="TAS">TAS</option>
                    <option value="ACT">ACT</option>
                    <option value="NT">NT</option>
                    <option value="Others">Others</option>
                </select>

                <label for="mobileNumber">Mobile Number:</label>
                <input type="tel" id="mobileNumber" name="mobileNumber" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>

                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Online FoodShop. All rights reserved.</p>
    </footer>
    <script>
        function getQueryParam(name) {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        var itemNames = getQueryParam('itemNames');
        if (itemNames) {
            itemNames = decodeURIComponent(itemNames).split(',');
        } else {
            itemNames = [];
        }

        document.addEventListener('DOMContentLoaded', function () {
            var itemNames = getQueryParam('itemNames');
            if (itemNames) {
                itemNames = decodeURIComponent(itemNames).split(',');
            } else {
                itemNames = [];
            }

            // Create a read-only input field for displaying the product names
            var cartItemsInput = document.createElement('input');
            cartItemsInput.type = 'text';
            cartItemsInput.value = itemNames.join(', ');
            cartItemsInput.readOnly = true;

            // Find the label for product names and insert the input field right after it
            var productNamesLabel = document.querySelector('label[for="productNames"]');
            if (productNamesLabel) {
                productNamesLabel.parentNode.insertBefore(cartItemsInput, productNamesLabel.nextSibling);
            }

            document.getElementById('productNames').value = itemNames.join(', ');
        });
    </script>
</body>

</html>