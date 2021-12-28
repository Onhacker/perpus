<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo "Login ".$rec->nama_website ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta content="Onhacker.net" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="<?php echo base_url('assets') ?>/images/favicon.ico">
    <!-- Sweet Alert-->
    <link href="<?php echo base_url('assets/admin') ?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="<?php echo base_url('assets/admin') ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/admin') ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/admin') ?>/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">

                        <div class="card-body p-2">

                            <div class="text-center">

                               <span><img src="<?php echo base_url('assets/images/').$rec->gambar ?>" alt="<?php echo base_url('assets/images/').$rec->gambar ?>" height="80"></span>

                               <p class="text-muted mb-2 mt-2"><?php echo $rec->nama_website."<br> ".ucwords(strtolower($rec->universitas)) ?></p>
                           </div>

                           <form id="frm" method="post" class="text-left">

                            <div class="form-group mb-2">
                                <label class="text-primary" for="emailaddress" style="color: #00a192 !important ;">Username/ Email</label>
                                <input class="form-control" type="text" name="member" id="member" required="" placeholder="Masukkan Username/Email" autocomplete="off">
                            </div>

                            <div class="form-group mb-2">
                                <label class="text-primary" for="password" style="color: #00a192 !important ;">Password</label>
                                <input class="form-control" type="password" required="" name="kode" id="kode" placeholder="Masukkan Password" autocomplete="off"> 
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input form-checkbox" id="customCheck11">
                                    <label class="custom-control-label text-primary" for="customCheck11">Tampilkan Password</label>
                                </div>
                            </div>

                            <input type="hidden" name="password2" id="password2" />
                            
                            <div class="form-group mb-2">
                                <label class="text-primary" for="password" style="color: #00a192 !important ;">Captcha</label><br>
                                <span class="text-primary"><code id="Capctha"><?php echo $kode ?></code></span>
                                <input class="form-control" type="text" required="" name="captcah" id="captcah" placeholder="Masukkan angka" autocomplete="off">
                            </div>
                            <div class="form-group mb-0 text-center">
                                <a href="javascript:;" onclick="go_login()" id="btn-login" class="btn btn-primary btn-block " style="background-color: #00a192; border: none;">LOGIN</a>
                                <div class="spinner-border text-primary m-2" id="btn-loader" role="status" style="display: none;"></div>
                            </div>

                        </form>

                        <div class="row">
                            <div class="col-md-6">
                             <div class="text-left">
                                
                                <h5 class="mt-3 text-muted"><a href="<?php echo site_url() ?>" ><button class="btn btn-blue waves-effect waves-light btn-xs">Kembali Ke Home</button></a></h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                
                                <h5 class="mt-3 text-muted"><a href="#" data-toggle="modal" data-target="#con-close-modal" data-backdrop="static" data-keyboard="false"><button class="btn btn-danger waves-effect waves-light btn-xs">Lupa Password</button></a></h5>
                            </div>
                        </div>
                    </div>

                    

                </div> <!-- end card-body -->
            </div>
            <!-- end card -->

            

        </div> <!-- end col -->
    </div>
    <!-- end row -->
</div>
<!-- end container -->
</div>
<!-- end page -->

<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card" style="-webkit-box-shadow : none;">
                <div class="card-body">
                    <div class="text-center w-75 m-auto">
                        
                        <span><img src="<?php echo base_url('assets/images/').$rec->gambar ?>" alt="<?php echo base_url('assets/images/').$rec->gambar ?>" height="80"></span>
                        
                        <!-- <p class="text-muted mb-4 mt-3">Konfirmasi E-mail anda</p> -->
                    </div>

                    <form id="reset" method="post" class="text-left">

                        <div class="form-group mb-3">
                            <label for="emailaddress">Email</label>
                            <input class="form-control" type="text" id="email" name="email" autocomplete="off" placeholder="Masukkan Email">
                        </div>

                        <div class="form-group mb-0 text-center">
                         <a href="javascript:;" onclick="reset_password()" id="btn-login-reset" class="btn btn-primary btn-block" style="background-color: #00a192; border: none;">Reset Password</a>
                         <div class="spinner-border text-primary m-2" id="btn-loader-reset" role="status" style="display: none;"></div>
                     </div>
                     

                 </form>

             </div> <!-- end card-body -->
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>
</div><!-- /.modal -->

<footer class="footer footer-alt">
    <span class="text-white"><?php echo date("Y") ?> &copy; Coder By </span><a href="#" class="text-white-50">Andi Azwar Saman</a> 
</footer> 
<script src="<?php echo base_url("assets/admin") ?>/js/jquery-3.1.1.min.js"></script>

<!-- Vendor js -->
<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>
<!-- Sweet Alerts js -->
<script src="<?php echo base_url('assets/admin') ?>/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- App js -->
<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
<!-- jqyery form-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/jquery.form.js"></script>
<?php $this->load->view("on_login_js") ?>
<script src="<?php echo base_url("assets/admin") ?>/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/js/pages/gallery.init.js"></script>
</body>


</html>