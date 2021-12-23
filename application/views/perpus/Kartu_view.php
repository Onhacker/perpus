<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?php echo $title ?></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <?php if ($this->session->userdata("admin_login") == true and $this->session->userdata("admin_level") == "user") { ?>
                     
                    <?php if ($res >= 0) { ?>
                        <?php 
                         $i = 0;
                            $i++; ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="button-list ">
                                        <a href="javascript:void(0);" onclick="cetak()" class="btn btn-block btn-lg btn-blue waves-effect waves-light rounded">
                                            <i class="fa fa-search"></i> Cetak Kartu Bebas Pustaka
                                        </a>

                                    </div>
                                </div>
                            </div>
                        
                    <?php } else { ?>
                        <div class="alert alert-light bg-danger text-white border-0" role="alert">
                            Anda Masih Ada Buku Pinjaman
                        </div>
                    <?php } ?>   


                <?php  } else { ?>
                    <div class="alert alert-light bg-danger text-white border-0" role="alert">
                        Info. Silahkan login sebagai member untuk melihat daftar pinjaman anda
                    </div>
                <?php  } ?>
                
               
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div>


<script type="text/javascript">
     function cetak() {
        awal = <?php echo  $this->session->userdata("admin_pkm","nim") ?>;
        window.open("<?php echo site_url("kartu/pdf/"); ?>/"+awal)
    }
</script>
    <style type="text/css">
        @media only screen and (max-width: 480px) {
          img {
            width: 100%;
        }
    }
</style>

</div>