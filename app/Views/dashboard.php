<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">

<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<section class="dashboard py-3" style="background-color: #f4f7fc;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center align-items-center" style="height: 80px;">
                    <h2 class="welcome-title">Welcome, <span class="merchant-name"><?= esc(session()->get('merchant_name')) ?></span></h2>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Statistics Area -->
            <div class="col-lg-2 col-md-12 mb-4">
                <h3 class="text-secondary ms-4 mt-4 mb-3">Sales Overview</h3>
                <div class="p-4 bg-white rounded-lg shadow-sm mb-2 stat-card">
                    <h4 class="text-success">Today</h4>
                    <p class="fs-4 fw-bold text-dark">$<?= number_format($todaySales, 2) ?></p>
                </div>
                <div class="p-4 bg-white rounded-lg shadow-sm mb-2 stat-card">
                    <h4 class="text-secondary">Yesterday</h4>
                    <p class="fs-4 fw-bold text-dark">$<?= number_format($yesterdaySales, 2) ?></p>
                </div>
                <div class="p-4 bg-white rounded-lg shadow-sm stat-card">
                    <h4 class="text-info">This Month</h4>
                    <p class="fs-4 fw-bold text-dark">$<?= number_format($thisMonthSales, 2) ?></p>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-10 col-md-12">
                <h3 class="text-secondary ms-4 mt-4 mb-3">Management Tools</h3>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                            <div class="card-header" style="background-color: #007bff; color: white;">
                                <h5 class="card-title">Manage Orders</h5>
                            </div>
                            <div class="card-body" style="background-color: #f9f9f9;">
                                <p class="card-text">View and process current orders.</p>
                                <a href="<?= base_url('/merchant/view-orders'); ?>" class="btn btn-primary">View Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                            <div class="card-header" style="background-color: #007bff; color: white;">
                                <h5 class="card-title">Manage Tables</h5>
                            </div>
                            <div class="card-body" style="background-color: #f9f9f9;">
                                <p class="card-text">Organize and assign tables.</p>
                                <a href="<?= base_url('/tables'); ?>" class="btn btn-primary">Go to Tables</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-lg" style="border-radius: 15px; overflow: hidden;">
                            <div class="card-header" style="background-color: #007bff; color: white;">
                                <h5 class="card-title">Manage Menu</h5>
                            </div>
                            <div class="card-body" style="background-color: #f9f9f9;">
                                <p class="card-text">Update your menu items.</p>
                                <a href="<?= base_url('/menu-manage'); ?>" class="btn btn-primary">Go to Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Body and Font Styling */
    body {
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        color: #333;
        background-color: #f4f7fc;
    }

    h2, h3, h4, h5 {
        font-weight: 500;
    }

    /* Welcome Title Styling */
    .welcome-title {
        color: #0056b3;
        font-size: 1.75rem; /* Increased font size */
        font-weight: 700; /* Bold font */
    }

    /* Merchant Name Styling */
    .merchant-name {
        color: #024978; /* A darker shade of blue to make it pop */
        font-size: 2rem; /* Slightly larger size for emphasis */
    }

    /* Card Header Styling */
    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 1.25rem;
    }

    /* Card Body Styling */
    .card-body {
        background-color: #f9f9f9;
        color: #333;
    }

    /* Button Primary Styling */
    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Background White Styling */
    .bg-white {
        background-color: #ffffff;
        box-shadow: 0 12px 24px -4px rgba(0,0,0,0.1);
    }

    /* Stat Card Styling */
    .stat-card {
        transition: box-shadow 0.3s ease-in-out;
    }

    .stat-card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
</style>

<?= $this->endSection() ?>
