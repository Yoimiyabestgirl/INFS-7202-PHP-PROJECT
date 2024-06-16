<?= $this->extend('client_template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Order Menu</h2>
    <!-- Dish Display Section -->
    <div class="row">
        <?php foreach ($dishes as $dish): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow">
                <img src="<?= base_url('uploads/' . $dish['image']); ?>" class="card-img-top" alt="<?= $dish['name']; ?>" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= $dish['name']; ?></h5>
                    <p class="card-text">$<?= number_format($dish['price'], 2); ?></p>
                    <div class="d-flex align-items-center">
                        <input type="number" class="form-control w-25 me-2" min="1" value="1" id="quantity-<?= $dish['id']; ?>">
                        <button class="btn btn-primary" style="flex-grow: 1; max-width: 65%;" onclick="addToCart(<?= $dish['id']; ?>, '<?= $dish['name']; ?>', <?= $dish['price']; ?>)">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- Order Section -->
    <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-center align-items-center">
                <div class="card p-3 bg-light">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="me-3">Total: $<span id="totalAmount" class="text-success">0.00</span></h5>
                        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#cartModal">View Cart</button>
                        <button class="btn btn-success" onclick="submitOrder()">Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Dish</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cartItems">
                        <!-- Cart items will be added here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
let cart = {}; // Global cart object to keep track of selected dishes

// Parsing URL parameters to retrieve 'table_id' and 'merchant_id'
const urlParams = new URLSearchParams(window.location.search);
const tableId = urlParams.get('table_id');
const merchantId = urlParams.get('merchant_id');

/**
 * Add items to the cart.
 *
 * @param {number} dishId - The ID of the dish.
 * @param {string} dishName - The name of the dish.
 * @param {number} price - The price of the dish.
 */
function addToCart(dishId, dishName, price) {
    let quantity = parseInt(document.getElementById('quantity-' + dishId).value);
    if (cart[dishId]) {
        cart[dishId].quantity += quantity; // Update quantity if item already exists
    } else {
        cart[dishId] = { name: dishName, id: dishId, price: price, quantity: quantity };
    }
    updateCartTotal();
    updateCartItems();
}

/**
 * Calculate and update the total price in the cart.
 */
function updateCartTotal() {
    let total = 0;
    Object.values(cart).forEach(item => {
        total += item.price * item.quantity;
    });
    document.getElementById('totalAmount').innerText = total.toFixed(2);
}

/**
 * Dynamically update the cart modal with items.
 */
function updateCartItems() {
    let cartItems = document.getElementById('cartItems');
    cartItems.innerHTML = ''; // Clear existing cart items
    Object.keys(cart).forEach((id) => {
        let item = cart[id];
        let row = `<tr>
            <td>${item.name}</td>
            <td>$${item.price.toFixed(2)}</td>
            <td><input type="number" value="${item.quantity}" min="1" class="form-control w-50" onchange="updateItemQuantity(${id}, this.value)"></td>
            <td>$${(item.price * item.quantity).toFixed(2)}</td>
            <td><button class="btn btn-danger" onclick="removeItem(${id})">Remove</button></td>
        </tr>`;
        cartItems.innerHTML += row;
    });
}

/**
 * Update quantity of an item in the cart.
 *
 * @param {number} dishId - The ID of the dish.
 * @param {number} quantity - The new quantity of the dish.
 */
function updateItemQuantity(dishId, quantity) {
    cart[dishId].quantity = parseInt(quantity);
    updateCartTotal();
    updateCartItems();
}

/**
 * Remove an item from the cart.
 *
 * @param {number} dishId - The ID of the dish to remove.
 */
function removeItem(dishId) {
    delete cart[dishId];
    updateCartTotal();
    updateCartItems();
}

/**
 * Submit the order to the server.
 */
function submitOrder() {
    let totalAmount = parseFloat(document.getElementById('totalAmount').innerText);
    const orderData = {
        table_id: tableId,
        merchant_id: merchantId,
        items: Object.values(cart).map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.price
        })),
        total_price: totalAmount
    };

    fetch("<?= site_url('order/submitOrder') ?>", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(orderData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Order submitted successfully!");
            cart = {}; // Reset the cart
            updateCartTotal();
            updateCartItems();
        } else {
            throw new Error(data.message || 'Unknown error occurred');
        }
    })
    .catch(error => {
        alert("Error submitting order: " + error.message);
    });
}
</script>

<?= $this->endSection() ?>
