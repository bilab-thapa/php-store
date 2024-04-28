<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>

<body>
<header>
    <div class="logo">
        <a href="index.php">
            <img src="./images/output.jpg" alt="Ecommerce Logo">
        </a>
    </div>
    <h1>Shopping Cart</h1>
</header>
    <main>
        <div class="cart-items">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Count</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="controllers">
            <div class = "clear-cart">
                <button id="clear-cart-btn">Clear Cart</button>
            </div>
            <div class="cart-total">
                <h2>Total: <span class="total-price">$0</span></h2>
                <button class="checkout-btn">Checkout</button>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: 'fetch_cart_items.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('.cart-items tbody').empty();

                    var uniqueItems = {};

                    response.forEach(function (item) {
                        if (uniqueItems.hasOwnProperty(item.name)) {
                            uniqueItems[item.name].quantity = parseInt(uniqueItems[item.name].quantity) + parseInt(item.quantity);
                        } else {
                            uniqueItems[item.name] = item;
                        }
                    });

                    Object.values(uniqueItems).forEach(function (item) {
                        var row = $('<tr>');
                        var imageCell = $('<td>').append($('<img>', {
                            src: item.image,
                            alt: item.name
                        }));
                        var nameCell = $('<td>').text(item.name);
                        var countCell = $('<td>').text(item.quantity);
                        var priceCell = $('<td>').text('$' + item.price);

                        var incrementBtn = $('<button>', {
                            text: '+',
                            class: 'increment-btn'
                        });
                        var decrementBtn = $('<button>', {
                            text: '-',
                            class: 'decrement-btn'
                        });

                        row.append(imageCell, nameCell, countCell, priceCell, incrementBtn, decrementBtn);
                        $('.cart-items tbody').append(row);
                    });

                    updateTotalPrice();
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching cart items:', error);
                }
            });

            $('.cart-items').on('click', '.increment-btn', function () {
                var row = $(this).closest('tr');
                var quantityCell = row.find('td:nth-child(3)');
                var quantity = parseInt(quantityCell.text());
                quantityCell.text(quantity + 1);
                updateTotalPrice();
                updateQuantityInDatabase(row, quantity + 1);
            });

            $('.cart-items').on('click', '.decrement-btn', function () {
                var row = $(this).closest('tr');
                var quantityCell = row.find('td:nth-child(3)');
                var quantity = parseInt(quantityCell.text());
                if (quantity > 0) {
                    quantityCell.text(quantity - 1);
                    updateTotalPrice();
                    updateQuantityInDatabase(row, quantity - 1);
                    if (parseInt(quantityCell.text()) === 0) {
                        row.remove();
                        updateTotalPrice();
                    }
                }
            });

            function updateQuantityInDatabase(row, newQuantity) {
                var nameCell = row.find('td:nth-child(2)');
                var name = nameCell.text();

                $.ajax({
                    url: 'update_cart_quantity.php',
                    method: 'POST',
                    data: {
                        name: name,
                        quantity: newQuantity
                    },
                    success: function (response) {
                        if (response.success) {
                            console.log('Quantity updated successfully');
                        } else {
                            console.error('Error updating quantity:', response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error updating quantity:', error);
                    }
                });
            }


            function updateTotalPrice() {
                var totalPrice = 0;
                $('.cart-items tbody tr').each(function () {
                    var priceCell = $(this).find('td:nth-child(4)');
                    var quantityCell = $(this).find('td:nth-child(3)');
                    var price = parseFloat(priceCell.text().replace('$', ''));
                    var quantity = parseInt(quantityCell.text());
                    totalPrice += price * quantity;
                });
                $('.total-price').text('$' + totalPrice.toFixed(2));
            }

            function getCartItemNames() {
                var itemNames = [];
                $('.cart-items tbody tr').each(function () {
                    var nameCell = $(this).find('td:nth-child(2)');
                    itemNames.push(nameCell.text());
                });
                return itemNames;
            }

            $('.checkout-btn').click(function (event) {
                event.preventDefault();
                if ($('.cart-items tbody tr').length === 0) {
                    alert('Your cart is empty. Please add items before checking out.');
                    return;
                }
                var itemNames = getCartItemNames();
                var itemNamesQueryParam = 'itemNames=' + encodeURIComponent(itemNames.join(','));
                window.location.href = 'delivery_details.php?' + itemNamesQueryParam;
            });



            $('#clear-cart-btn').click(function () {
                $.ajax({
                    url: 'clear_cart.php',
                    method: 'POST',
                    success: function (response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            alert('Error clearing cart: ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error clearing cart:', error);
                        console.error('Response text:', xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>