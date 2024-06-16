<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<!-- Admin Content -->
<section class="py-5">
    <div class="container">
        <h1>Welcome to Admin Panel</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Restaurant Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through each merchant and display their information -->
                    <?php foreach ($merchants as $merchant) : ?>
                        <tr>
                            <td><?= $merchant['id']; ?></td>
                            <td><?= $merchant['restaurant_name']; ?></td>
                            <td><?= $merchant['email']; ?></td>
                            <td>
                                <!-- Edit button triggers the edit modal with merchant details -->
                                <button type="button" class="btn btn-sm btn-primary editBtn" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $merchant['id']; ?>" data-name="<?= $merchant['restaurant_name']; ?>" data-email="<?= $merchant['email']; ?>">Edit</button>
                                <!-- Delete button triggers a confirmation prompt before deletion -->
                                <a href="<?= base_url('/admin/delete/' . $merchant['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this merchant?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Edit Merchant Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Merchant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form for editing merchant details -->
            <form action="<?= base_url('/admin/update'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="merchantId">
                    <div class="mb-3">
                        <label for="restaurantName" class="form-label">Restaurant Name</label>
                        <input type="text" class="form-control" id="restaurantName" name="restaurant_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="merchantEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="merchantEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="merchantPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="merchantPassword" name="password">
                        <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Event listener to populate the edit modal with merchant details when the edit button is clicked
    document.addEventListener('DOMContentLoaded', (event) => {
        const editButtons = document.querySelectorAll('.editBtn');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const email = button.getAttribute('data-email');

                // Populate the modal fields with the merchant's data
                document.getElementById('merchantId').value = id;
                document.getElementById('restaurantName').value = name;
                document.getElementById('merchantEmail').value = email;
                document.getElementById('merchantPassword').value = ''; // Clear password field
            });
        });
    });
</script>

<?= $this->endSection() ?>
