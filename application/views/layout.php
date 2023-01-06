<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, height=device-height, initial-scale=1" name="viewport" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="<?= base_url() ?>resources/img/icons/icon-48x48.png" />

    <title>Email Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>resources/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style type="text/css">
        .content{background-color: #ffffff!important;}
        .btn-color{background-color: #FF0766!important; color: #ffffff!important;}
        .signup-form input{border: 1px solid #B7B7CB;border-radius: 0px;}
        .logo_anchor{
                width: 363px;
        }
        .action_btn a span{
            color: #FF0766!important;
            font-weight: 800!important;
            font-family: 'Arial',Helvetica,Arial,Lucida,sans-serif;
        }
        .header_nav{
            padding-bottom: 41px;
            border: 1px solid lightgray;
        }

        .logo_anchor img{
                height: 48px;
                width: 202px!important;
                margin-left: 112px;
        }

        @media screen and (max-width: 480px)
        {
            .mb-5 {
                margin-bottom: 200px !important;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <?php if (isset($_SESSION['name'])) { ?>
            <nav id="sidebar" class="sidebar js-sidebar">
                <div class="sidebar-content js-simplebar" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: 0px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                    <div class="simplebar-content" style="padding: 0px;">
                                        <a class="sidebar-brand" href="javascript:;">
                                            <span class="align-middle">Email Invoice</span>
                                        </a>

                                        <ul class="sidebar-nav">
                                            <li class="sidebar-header">
                                                Dashboard
                                            </li>

                                            <li class="sidebar-item active">
                                                <a class="sidebar-link" href="<?=site_url('dashboard')?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders align-middle">
                                                        <line x1="4" y1="21" x2="4" y2="14"></line>
                                                        <line x1="4" y1="10" x2="4" y2="3"></line>
                                                        <line x1="12" y1="21" x2="12" y2="12"></line>
                                                        <line x1="12" y1="8" x2="12" y2="3"></line>
                                                        <line x1="20" y1="21" x2="20" y2="16"></line>
                                                        <line x1="20" y1="12" x2="20" y2="3"></line>
                                                        <line x1="1" y1="14" x2="7" y2="14"></line>
                                                        <line x1="9" y1="8" x2="15" y2="8"></line>
                                                        <line x1="17" y1="16" x2="23" y2="16"></line>
                                                    </svg> <span class="align-middle">Settings</span>
                                                </a>
                                            </li>

                                            <!-- <li class="sidebar-item">
                                            <a class="sidebar-link" href="pages-profile.html">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user align-middle">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg> <span class="align-middle">Profile</span>
                                            </a>
                                        </li>

                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="pages-sign-in.html">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-in align-middle">
                                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                                    <polyline points="10 17 15 12 10 7"></polyline>
                                                    <line x1="15" y1="12" x2="3" y2="12"></line>
                                                </svg> <span class="align-middle">Sign In</span>
                                            </a>
                                        </li>

                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="pages-sign-up.html">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus align-middle">
                                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="8.5" cy="7" r="4"></circle>
                                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                                </svg> <span class="align-middle">Sign Up</span>
                                            </a>
                                        </li>

                                        <li class="sidebar-item">
                                            <a class="sidebar-link" href="pages-blank.html">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book align-middle">
                                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                                </svg> <span class="align-middle">Blank</span>
                                            </a>
                                        </li> -->


                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: auto; height: 955px;"></div>
                    </div>
                </div>
            </nav>
        <?php } ?>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg header_nav">
                <a class="sidebar-toggle js-sidebar-toggle logo_anchor">
                   <img src="<?=base_url('resources/img/logo.png')?>">
                </a>

                <?php if (isset($_SESSION['name'])) { ?>
                    <div class="navbar-collapse collapse">
                        <ul class="navbar-nav navbar-align">
                            <li class="nav-item dropdown action_btn">
                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                    <span class="text-dark"><?= $_SESSION['name'] ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">Log out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php } else if ($this->uri->segment(2) == 'signin') { ?>
                    <div class="navbar-collapse collapse">
                        <ul class="navbar-nav navbar-align">
                            <li class="nav-item dropdown action_btn">
                                <a class="nav-link d-inline-block" href="<?= site_url('auth/create_user') ?>">
                                    <span class="text-dark">Signup</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <div class="navbar-collapse collapse">
                        <ul class="navbar-nav navbar-align">
                            <li class="nav-item dropdown action_btn">
                                <a class="nav-link d-inline-block" href="<?= site_url('auth/signin') ?>">
                                    <span class="text-dark">Login</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

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