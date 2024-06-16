<!-- app/Views/template.php -->
<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Scan Order System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .site {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        #content {
            flex: 1 0 auto;
        }
        #footer {
            flex-shrink: 0;
        }
    </style>
</head>

<body class="site">
    <header>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url('/'); ?>">MenuScanOrderSystem</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= service('router')->getMatchedRoute()[0] == '/' ? 'active' : ''; ?>" href="<?= base_url('/'); ?>">Home</a>
                        </li>
                        <?php if (session()->get('is_logged_in')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('/dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('/logout'); ?>">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link <?= service('router')->getMatchedRoute()[0] == '/login' ? 'active' : ''; ?>" href="<?= base_url('/login'); ?>">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main id="content" role="main" class="flex-shrink-0">
        <!-- Dynamic Content -->
        <?= $this->renderSection('content') ?>
    </main>

    <footer id="footer" class="footer mt-auto bg-dark text-white py-4">
        <div class="container text-center">
            <small>© 2024 MenuScanOrderApp. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>
