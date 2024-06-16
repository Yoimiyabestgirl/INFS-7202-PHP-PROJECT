<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<!-- Main Content Section -->
<section class="py-5">
    <div class="container">
        <!-- Heading and Subheading Row -->
        <div class="row align-items-start mb-5">
            <!-- Text Column -->
            <div class="col-md-6 text-center">
                <h1>Welcome to Scan & Order Platform</h1>
                <p class="lead">Offering a fast and convenient online ordering experience for both merchants and customers.</p>
                <!-- Buttons for Merchant and Admin Entrance -->
                <div class="my-3">
                    <a href="<?= base_url('/login'); ?>" class="btn btn-success btn-lg me-2">Merchant Entrance</a>
                    <a href="<?= base_url('/admin'); ?>" class="btn btn-primary btn-lg">Admin Entrance</a>
                </div>
            </div>
            <!-- Image Column -->
            <div class="col-lg-6 mb-5">
                <img src="<?= base_url('images/ilustration.png'); ?>" alt="APP illustration" class="img-fluid rounded shadow">
            </div>
        </div>

        <hr>
        
        <!-- Features Section -->
        <div class="row text-center pt-5">
            <!-- Feature 1 -->
            <div class="col-md-4 mb-5">
                <h3>Easy to Use</h3>
                <p>Quick registration and effortless menu management without the need for specialized knowledge.</p>
            </div>
            <!-- Feature 2 -->
            <div class="col-md-4 mb-5">
                <h3>Instant Updates</h3>
                <p>Update your menu and prices in real-time to ensure information accuracy.</p>
            </div>
            <!-- Feature 3 -->
            <div class="col-md-4 mb-5">
                <h3>Data Analytics</h3>
                <p>Gain insights into customer preferences and optimize inventory management.</p>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
