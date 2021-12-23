<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8" />
    <title>itle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta content="Onhacker CMS" name="description" />
    <meta content="Onhacker" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <link rel="shortcut icon" href="<?php echo base_url('upload/gambar/favicon.ico') ?>">
    
    <link href="<?php echo base_url('assets/admin') ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/admin') ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/admin') ?>/css/app.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>assets/admin/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo base_url("assets/admin") ?>/js/jquery-3.1.1.min.js"></script>
    
    <style type="text/css">
        html {
          scroll-behavior: smooth;
      }

  </style>
</head>
<body class="menubar-gradient gradient-topbar">

 <div id="preloader">
    <div id="status">
        <div class="spinner">Loading...</div>
    </div>
</div>


<header id="topnav">

    <div class="navbar-custom">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li class="dropdown notification-list">

                    <a class="navbar-toggle nav-link">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>

                </li>

                   
                        
            </div> 
        </div>


        <div class="topbar-menu">
            <div class="container-fluid">
                <div id="navigation">

                    <ul class="navigation-menu">

                        <li class="has-submenu">
                            <a href="<?php echo site_url("admin_dashboard") ?>"><i class="fe-monitor"></i>Dashboard </a>
                        </li>


                       

           
            </li>
        </ul>
    </li>

                    
                           
                
                        </ul>


                        <div class="clearfix"></div>
                    </div>

                </div>

            </div>


        </header>






        <div class="wrapper">
            <?php echo $content ?>
        </div>







        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        Coder by <a href="#">Onhacker</a> 
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-right footer-links d-none d-sm-block">
                            <a href="javascript:void(0);">Version 1.0.0</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>



       

        <div class="rightbar-overlay"></div>
        <script src="<?php echo base_url("assets/admin") ?>/js/jquery-3.1.1.min.js"></script>

        <script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>

        <script src="<?php echo base_url('assets/admin') ?>/libs/sweetalert2/sweetalert2.min.js"></script>

        <script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
       

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>
        <script src="<?php echo base_url('assets/admin') ?>/js/jquery.form.js"></script>


        <script src="<?php echo base_url("assets/admin/") ?>libs/select2/select2.min.js"></script>

        <script type="text/javascript">
           
           

            function logout(){
                Swal.fire({
                    title: "Yakin ingin Keluar ?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Keluar",
                    cancelButtonText: "Batal",
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.value) {
                        window.location.href = "<?php echo site_url("on_login/logout") ?>";                    } 
                    })
            }

        </script>
    </body>

    </html>