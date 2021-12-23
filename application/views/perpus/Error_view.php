
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title><?php echo $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta name="robots" content="noindex">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('assets') ?>/images/favicon.ico">

		<!-- App css -->
		<link href="<?php echo base_url('assets/admin') ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="<?php echo base_url('assets/admin') ?>/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<link href="<?php echo base_url('assets/admin') ?>/css/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
		<link href="<?php echo base_url('assets/admin') ?>/css/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

		<!-- icons -->
		<link href="<?php echo base_url('assets/admin') ?>/css/icons.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="loading authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card">

                            <div class="card-body">

                                <div class="error-text-box">
                                    <svg viewBox="0 0 400 200">
                                        <!-- Symbol-->
                                        <symbol id="s-text">
                                            <text text-anchor="middle" x="50%" y="50%" dy=".35em">404!</text>
                                        </symbol>
                                        <!-- Duplicate symbols-->
                                        <use class="text" xlink:href="#s-text">sdds</use>
                                        <use class="text" xlink:href="#s-text">sdds</use>
                                        <use class="text" xlink:href="#s-text">sdds</use>
                                        <use class="text" xlink:href="#s-text">sdds</use>
                                        <use class="text" xlink:href="#s-text">sdds</use>
                                    </svg>
                                </div>

                                <div class="text-center">
                                    <h3 class="mt-4">Page not found </h3>
                                    <p class="text-muted mb-0"><?php echo $title; ?></p>
                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50"><a href="<?php echo site_url() ?>" class="text-white ml-1 btn btn-info"><i class="fe-globe"></i>Kembali</a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <footer class="footer footer-alt">
            <?php echo date("Y") ?> &copy; Coder By <a href="https://onhacker.net" class="text-black-50">Onhacker.net</a> 
        </footer> 

        <!-- Vendor js -->
        <script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>

    </body>

</html>