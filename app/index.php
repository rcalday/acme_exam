<!DOCTYPE html>
<html>

<head>
    <title>Acme Widget Basket</title>
    <style>
        .product-button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            border-radius: 5px;
        }

        .red {
            background-color: #e74c3c;
        }

        .green {
            background-color: #27ae60;
        }

        .blue {
            background-color: #2980b9;
        }

        .clear {
            background-color: #7f8c8d;
        }

        #selected-items {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
    <script>
        function addItem(code) {
            const input = document.getElementById('products');
            let current = input.value ? input.value.split(',') : [];

            current.push(code);
            input.value = current.join(',');

            updateDisplay();
        }

        function clearItems() {
            document.getElementById('products').value = '';
            updateDisplay();
        }

        function updateDisplay() {
            const items = document.getElementById('products').value;
            document.getElementById('selected-items').textContent = "Selected: " + (items || "(none)");
        }
    </script>
</head>

<body>
    <h1>Acme Widget Co - Basket</h1>

    <form action="BasketController.php" method="post">
        <div>
            <button type="button" class="product-button red" onclick="addItem('R01')">Red Widget (R01)</button>
            <button type="button" class="product-button green" onclick="addItem('G01')">Green Widget (G01)</button>
            <button type="button" class="product-button blue" onclick="addItem('B01')">Blue Widget (B01)</button>
            <button type="button" class="product-button clear" onclick="clearItems()">Clear</button>
        </div>

        <p id="selected-items">Selected: (none)</p>

        <input type="hidden" name="products" id="products" value="">
        <button type="submit">Calculate Total</button>
    </form>

    <?php if (isset($_GET['total'])): ?>
        <h2 id="total">Total: $<?= htmlspecialchars($_GET['total']) ?></h2>
    <?php elseif (isset($_GET['error'])): ?>
        <h2 style="color:red;"><?= htmlspecialchars($_GET['error']) ?></h2>
    <?php endif; ?>
</body>

</html>