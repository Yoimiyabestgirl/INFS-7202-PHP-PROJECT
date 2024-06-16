<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<?php if (session()->has('error')): ?>
    <!-- Error Message -->
    <div class="alert alert-danger text-center">
        <?= session('error') ?>
    </div>
<?php endif; ?>

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
    .text-decoration-none {
        color: #888;
    }
    .alert-danger {
        border-radius: 20px;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <!-- Welcome Message -->
            <div class="text-center mb-4">
                <h2>Welcome Back :)</h2>
                <p>To keep connected with us please login with your personal information by email address and password</p>
            </div>
            <!-- Login Form Card -->
            <div class="card shadow">
                <div class="card-body">
                    <form action="<?= base_url('/auth/validate'); ?>" method="post">
                        <!-- Email Input -->
                        <div class="mb-4">
                            <label for="email" class="form-label visually-hidden">Email Address</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" required placeholder="Email Address">
                        </div>
                        <!-- Password Input -->
                        <div class="mb-4">
                            <label for="password" class="form-label visually-hidden">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" required placeholder="Password">
                        </div>
                        <!-- Remember Me and Forgot Password -->
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe" value="on">
                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                            </div>
                            <a href="#" class="text-decoration-none">Forgot Password?</a>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100">Login Now</button>
                    </form>
                    <!-- Social Login and Register Links -->
                    <div class="text-center mt-3">
                        <p>Or you can join with</p>
                        <div>
                            <a href="#" class="text-decoration-none me-2"><i class="bi bi-google"></i></a>
                            <a href="#" class="text-decoration-none me-2"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="text-decoration-none"><i class="bi bi-twitter"></i></a>
                        </div>
                        <a href="<?= base_url('/register'); ?>" class="text-decoration-none mt-3 d-block">Create Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<!-- Include Bootstrap Icons -->
<?= $this->section('additional-scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
<?= $this->endSection() ?>
