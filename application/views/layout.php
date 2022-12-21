<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="<?= base_url() ?>resources/img/icons/icon-48x48.png" />

    <title>Email Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>resources/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <span class="text-dark">Charles Hall</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0 mb-5">
                    <?= $content ?>
                </div>
            </main>
        </div>
    </div>



    <script src="<?= base_url() ?>resources/js/app.js"></script>

</body>

</html>