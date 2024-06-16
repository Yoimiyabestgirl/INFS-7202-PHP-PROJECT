<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Open Sans', sans-serif;
        background-color: #f4f7fa;
        color: #444;
    }
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .card-body {
        padding: 35px;
    }
    .card-title {
        font-weight: 600;
        color: #333;
    }
    .form-control {
        border-radius: 20px;
        border: 1px solid #ddd;
        box-shadow: none;
    }
    .form-control:focus {
        border-color: #a2d3c2;
        box-shadow: none;
    }
    .btn-primary {
        border-radius: 20px;
        background-color: #a2d3c2;
        border: none;
        box-shadow: none;
        padding: 10px;
    }
    .btn-primary:hover {
        background-color: #96c0ad;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Registration Card -->
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Register Merchant Account</h3>
                    <!-- Registration Form -->
                    <form action="<?= base_url('/auth/register'); ?>" method="post">
                        <!-- Merchant Name Input -->
                        <div class="mb-4">
                            <label for="merchantName" class="form-label">Merchant Name</label>
                            <input type="text" class="form-control" id="merchantName" name="merchantName" required placeholder="Enter your business name">
                        </div>
                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="you@example.com">
                        </div>
                        <!-- Password Input -->
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Create a password">
                        </div>
                        <!-- Confirm Password Input -->
                        <div class="mb-4">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required placeholder="Confirm your password">
                        </div>
                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript to handle form validation
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');

    form.addEventListener('submit', function (event) {
        // Check password length
        if (password.value.length < 8) {
            alert('The password needs to be at least 8 characters.');
            event.preventDefault();
            return false;
        }

        // Check password match
        if (password.value !== confirmPassword.value) {
            alert('The passwords entered do not match, please check.');
            event.preventDefault();
            return false;
        }
    });
});
</script>

<?= $this->endSection() ?>
