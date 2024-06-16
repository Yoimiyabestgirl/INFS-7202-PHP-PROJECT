<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Scan Order System - Client View</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Header Section with Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">MenuScanOrderSystem</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Main Content Area -->
    <main role="main" class="container mt-5">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer Section -->
    <footer class="footer mt-auto bg-dark text-white py-4">
        <div class="container text-center">
            <small>© 2024 MenuScanOrderApp. All rights reserved.</small>
        </div>
    </footer>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
