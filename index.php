<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Frontpage</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
    <div class="logo">
    <a href="index.php">
        <img src="./images/output.jpg" alt="Ecommerce Logo">
    </a>
    </div>

        <h1 class="brand-name">Healthy Grocery</h1>
        <div class="cart">
            <a class="cart-link"><i class="fas fa-shopping-cart"></i></a>
            <p class="cart-count"> 0 </p>
        </div>
    </header>


    <nav>
        <ul class="main-nav">
            <li class="main-category">
                <a href="#" tabindex="0">Root Vegetables</a>
                <ul class="sub-categories">
                    <li><a href="#">Carrot</a></li>
                    <li><a href="#">Potato</a></li>
                    <li><a href="#">Beetroot</a></li>
                    <li><a href="#">Okra</a></li>
                </ul>
            </li>
            <li class="main-category">
                <a href="#">Fruits</a>
                <ul class="sub-categories">
                    <li><a href="#">Tomato</a></li>
                    <li><a href="#">Bell Pepper</a></li>
                    <li><a href="#">Pumpkin</a></li>
                    <li><a href="#">Zucchini</a></li>
                    <li><a href="#">Cucumber</a></li>
                    <li><a href="#">Capsicum</a></li>
                </ul>
            </li>
            <li class="main-category">
                <a href="#">Allium Vegetables</a>
                <ul class="sub-categories">
                    <li><a href="#">Onion</a></li>
                    <li><a href="#">Garlic</a></li>
                    <li><a href="#">Ginger</a></li>
                </ul>
            </li>
            <li class="main-category">
                <a href="#">Legumes</a>
                <ul class="sub-categories">
                    <li><a href="#">Green Beans</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <form action="javascript:void(0);" method="GET">
        <div class="search-container">
            <input type="text" name="query" id="search-input" placeholder="Search for products...">
            <button type="submit" id="search-button"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <main>
        <div class="product-container"></div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            fetchAndDisplayProducts();
            $('.main-category a').click(function (event) {
                event.preventDefault();
                var category = $(this).text().trim().toLowerCase();
                fetchAndDisplayProducts(category);
            });

            $('.sub-categories a, .sub-summer-categories a, .sub-winter-categories a, .sub-sub-sub-categories a').click(function (event) {
                event.preventDefault();
                var subcategory = $(this).text().trim().toLowerCase();
                fetchAndDisplayProducts('', subcategory);
            });
            $('#search-button').click(function () {
                var query = $('#search-input').val();
                fetchAndDisplayProducts('', '', query);
            });
            function fetchAndDisplayProducts(category = '', subcategory = '', query = '') {
                $.ajax({
                    url: 'fetch_products.php',
                    method: 'GET',
                    data: {
                        category: category,
                        subcategory: subcategory,
                        query: query
                    },
                    dataType: 'json',
                    success: function (response) {
                        var productContainer = $('.product-container');
                        productContainer.empty();
                        response.forEach(function (product) {
                            var card = $('<div>', {
                                class: 'product-card'
                            });
                            var productImage = $('<div>', {
                                class: 'product-image'
                            });
                            var image = $('<img>', {
                                src: product.image,
                                alt: product.name
                            });
                            var productInfo = $('<div>', {
                                class: 'product-info'
                            });
                            var productName = $('<h3>').text(product.name);
                            var productDescription = $('<p>').text(product.category + " " + product.subcategory);
                            var productPrice = $('<p>').text('$' + product.price).addClass('product-price');
                            var productCount = $('<p>').text('Count: ' + product.count).addClass('product-count');
                            var addToCartButton = $('<button>').text('Add to Cart').addClass('add-to-cart-btn'); // Add class here
                            if (product.count === 0) {
                                addToCartButton.prop('disabled', true);
                            }
                            productImage.append(image);
                            productInfo.append(productName, productDescription, productPrice, productCount, addToCartButton);
                            card.append(productImage, productInfo);
                            productContainer.append(card);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching products: " + error);
                    }
                });
            }
            var cartCount = 0;
            // Attach click event listener to dynamically created "Add to Cart" buttons
            $('.product-container').on('click', '.add-to-cart-btn', function () {
                var productCard = $(this).closest('.product-card');
                var productName = productCard.find('h3').text();
                var productImage = productCard.find('.product-image img').attr('src');
                var priceText = productCard.find('.product-price').text();
                var productPrice = parseFloat(priceText.replace('$', ''));
                var productUnit = 1;


                $.ajax({
                    url: 'add_to_cart.php',
                    method: 'POST',
                    data: {
                        name: productName,
                        image: productImage,
                        price: productPrice.toFixed(2),
                        quantity: productUnit
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log('Item added to cart:', response);
                        cartCount++;
                        $('.cart-count').text('( ' + cartCount + ' )');
                    },
                    error: function (xhr, status, error) {
                        console.error("Error adding item to cart:", error);
                    }
                });
            });


            $('.cart-link').click(function (event) {
                event.preventDefault();
                window.open('cart.php', '_blank');
            });

        });
    </script>
    <script>
  document.write(
    '<script src="http://' +
      (location.host || '${1:localhost}').split(':')[0] +
      ':${2:35729}/livereload.js?snipver=1"></' +
      'script>'
  );
</script>


</body>

</html>