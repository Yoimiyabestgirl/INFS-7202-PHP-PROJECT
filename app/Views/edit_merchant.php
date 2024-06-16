<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Edit Merchant</h1>
    <!-- Form to edit merchant details -->
    <form action="<?= base_url('/admin/update'); ?>" method="post">
        <!-- Hidden input to store the merchant ID -->
        <input type="hidden" name="id" value="<?= $merchant['id']; ?>">
        
        <!-- Input field for restaurant name -->
        <div class="mb-3">
            <label for="restaurant_name" class="form-label">Restaurant Name</label>
            <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" value="<?= $merchant['restaurant_name']; ?>" required>
        </div>
        
        <!-- Input field for email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $merchant['email']; ?>" required>
        </div>
        
        <!-- Submit button to save changes -->
        <button type="submit" class="btn btn-primary">Save changes</button>
    </form>
</div>
<?= $this->endSection() ?>
