<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4 text-center">Menu Management</h1>
    <!-- Category Filter Dropdown and Add Dish Button -->
    <div class="mb-3 text-end">
        <select class="form-select w-auto" onchange="filterByCategory(this.value)" style="display: inline-block;">
            <option value="">All Categories</option>
            <option value="Appetizers">Appetizers</option>
            <option value="Mains">Mains</option>
            <option value="Desserts">Desserts</option>
            <option value="Beverages">Beverages</option>
        </select>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDishModal">Add New Dish</button>
    </div>

    <!-- Dishes Container -->
    <div class="row" id="dishContainer">
        <?php foreach ($dishes as $dish): ?>
        <div class="col-md-4 mb-3 dish-card" data-category="<?= $dish['category']; ?>">
            <div class="card h-100 shadow">
                <img src="<?= base_url('uploads/' . $dish['image']); ?>" class="card-img-top" alt="<?= $dish['name']; ?>" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?= $dish['name']; ?></h5>
                    <p class="card-text">$<?= number_format($dish['price'], 2); ?></p>
                    <p class="card-text"><?= $dish['description']; ?></p>
                    <div class="text-center">
                        <button onclick="editDish(<?= $dish['id']; ?>)" class="btn btn-success">Edit</button>
                        <button class="btn btn-danger" onclick="confirmDelete(<?= $dish['id']; ?>)">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal for Adding Dishes -->
<div class="modal fade" id="addDishModal" tabindex="-1" aria-labelledby="addDishModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDishModalLabel">Add New Dish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/menu/saveDish'); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Choose a category</option>
                            <option value="Appetizers">Appetizers</option>
                            <option value="Mains">Mains</option>
                            <option value="Desserts">Desserts</option>
                            <option value="Beverages">Beverages</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Add Dish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Dishes -->
<div class="modal fade" id="editDishModal" tabindex="-1" aria-labelledby="editDishModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDishModalLabel">Edit Dish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/menu/updateDish'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="editDishId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <select class="form-select" id="editCategory" name="category" required>
                            <option value="">Choose a category</option>
                            <option value="Appetizers">Appetizers</option>
                            <option value="Mains">Mains</option>
                            <option value="Desserts">Desserts</option>
                            <option value="Beverages">Beverages</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="editImage" name="image">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Dish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Fetch dish details and populate the edit modal form.
 *
 * @param {number} id - The ID of the dish to edit.
 */
function editDish(id) {
    fetch(`<?= base_url('/menu/getDish/') ?>${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editDishId').value = id;
            document.getElementById('editName').value = data.name;
            document.getElementById('editPrice').value = data.price;
            document.getElementById('editDescription').value = data.description;
            document.getElementById('editCategory').value = data.category;

            var editModal = new bootstrap.Modal(document.getElementById('editDishModal'));
            editModal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });
}

/**
 * Confirm and process dish deletion.
 *
 * @param {number} dishId - The ID of the dish to delete.
 */
function confirmDelete(dishId) {
    if (confirm("Are you sure you want to delete this dish?")) {
        fetch(`<?= base_url('/menu/deleteDish/') ?>${dishId}`, {
            method: 'POST',
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Failed to delete dish.');
        })
        .then(() => {
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}

/**
 * Filter dishes displayed based on the selected category.
 *
 * @param {string} category - The selected category to filter by.
 */
function filterByCategory(category) {
    let dishes = document.querySelectorAll('.dish-card');
    dishes.forEach(dish => {
        if (category === "" || dish.getAttribute('data-category') === category) {
            dish.style.display = '';
        } else {
            dish.style.display = 'none';
        }
    });
}
</script>

<?= $this->endSection() ?>
