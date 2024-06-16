<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Manage Tables</h1>
    <!-- Button to Open Add Table Modal -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTableModal">Add New Table</button>
    </div>

    <!-- Tables List -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Table #</th>
                    <th>Seats</th>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $table): ?>
                <tr>
                    <td><?= $table['id']; ?></td>
                    <td><?= $table['capacity']; ?></td>
                    <td>
                        <img src="<?= base_url($table['qr_code']); ?>" class="img-fluid" style="width: 100px; height: 100px;" alt="QR Code">
                    </td>
                    <td>
                        <button onclick="confirmDelete(<?= $table['id']; ?>)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Adding Tables -->
<div class="modal fade" id="addTableModal" tabindex="-1" aria-labelledby="addTableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTableModalLabel">Add New Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/table/add'); ?>" method="post">
                    <!-- Input for Table Capacity -->
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Seats</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Table</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * Confirm and delete a table.
 *
 * @param {number} tableId - The ID of the table to delete.
 */
function confirmDelete(tableId) {
    if (confirm("Are you sure you want to delete this table?")) {
        window.location.href = '<?= base_url('/table/delete/'); ?>' + tableId;
    }
}
</script>

<?= $this->endSection() ?>
