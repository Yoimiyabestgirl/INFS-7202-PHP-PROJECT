<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">

<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <h1 class="mb-4 text-center" style="font-weight: 700; color: #017bff;">Order List</h1>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Order Number</th>
                        <th>Table Number</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= esc($order['order_id']) ?></td>
                        <td><?= esc($order['table_id']) ?></td>
                        <td><?= esc($order['total_price']) ?></td>
                        <td>
                            <!-- Form to update order status -->
                            <form action="<?= site_url('/business-order-controller/updateOrderStatus') ?>" method="post">
                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                <div class="input-group">
                                    <select name="status" class="form-select form-select-sm status-select" onchange="this.form.submit()">
                                        <option value="Ready to Start" <?= $order['status'] == 'Ready to Start' ? 'selected' : '' ?>>Ready to Start</option>
                                        <option value="On Progress" <?= $order['status'] == 'On Progress' ? 'selected' : '' ?>>On Progress</option>
                                        <option value="Finished" <?= $order['status'] == 'Finished' ? 'selected' : '' ?>>Finished</option>
                                    </select>
                                </div>
                            </form>
                        </td>
                        <td>
                            <!-- Button to view order details -->
                            <button class="btn btn-outline-primary btn-sm" onclick="fetchOrderDetails(<?= $order['order_id'] ?>)" data-bs-toggle="modal" data-bs-target="#orderDetailsModal-<?= $order['order_id'] ?>">
                                View Details
                            </button>
                            <!-- Form to delete order -->
                            <form action="<?= site_url('/business-order-controller/deleteOrder') ?>" method="post" style="display:inline;">
                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination links -->
        <div class="d-flex justify-content-center mt-4 pagination-custom">
            <?= $pager->links('orders', 'default_full') ?>
        </div>

        <?php foreach ($orders as $order): ?>
        <!-- Modal for displaying detailed order information -->
        <div class="modal fade" id="orderDetailsModal-<?= $order['order_id'] ?>" tabindex="-1" aria-labelledby="orderDetailsModalLabel-<?= $order['order_id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header table-primary">
                        <h5 class="modal-title" id="orderDetailsModalLabel-<?= $order['order_id'] ?>">
                            Order Details - Order Number: <?= $order['order_id'] ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="orderDetailsContent-<?= $order['order_id'] ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
/**
 * Fetch and display order details for a given order ID.
 *
 * @param {number} orderId The ID of the order to fetch details for
 */
function fetchOrderDetails(orderId) {
    // Perform an HTTP GET request to fetch order details using the order ID
    fetch('<?= site_url('/business-order-controller/getOrderDetails/') ?>' + orderId)
        .then(response => response.json()) // Parse the JSON response body
        .then(data => {
            const modalContent = document.getElementById('orderDetailsContent-' + orderId); // Locate the modal content area

            if (data.success) {
                // If successful, iterate through the order details and generate HTML content
                const detailsHtml = data.orderDetails.map(detail => `
                    <div class="card mb-2 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3"><strong>Dish:</strong> ${detail.dish_name}</div> 
                                <div class="me-3"><strong>Quantity:</strong> ${detail.quantity}</div> 
                                <div><strong>Unit Price:</strong> ${detail.price}</div> 
                            </div>
                        </div>
                    </div>
                `).join(''); // Join all generated card HTML strings into a single string

                // Insert the newly created HTML into the modal content area
                modalContent.innerHTML = detailsHtml;
            } else {
                // If fetch was not successful, display an error message
                modalContent.innerHTML = '<p>' + data.message + '</p>';
            }
        })
        .catch(error => {
            // Handle any errors that occur during the fetch operation
            modalContent.innerHTML = '<p>Network request failed.</p>';
        });
}
</script>

<style>
    .status-select {
        width: auto;
        min-width: 150px;
    }

    .pagination-custom .pager .page-item {
        margin: 0 5px;
    }

    .pagination-custom .pager .page-item .page-link {
        border-radius: 5px;
        padding: 5px 10px;
        color: #017bff;
        border: 1px solid #017bff;
        margin: 0 5px;
    }

    .pagination-custom .pager .page-item .page-link:hover {
        background-color: #017bff;
        color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .table {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .table th {
        background-color: #017bff;
        color: #fff;
        border-bottom: 2px solid #dee2e6;
    }

    .table td, .table th {
        padding: 15px;
        vertical-align: middle;
    }

    .table thead th {
        text-align: center;
    }

    .btn-outline-primary {
        color: #017bff;
        border-color: #017bff;
    }

    .btn-outline-primary:hover {
        background-color: #017bff;
        color: #fff;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }
</style>

<?= $this->endSection() ?>
