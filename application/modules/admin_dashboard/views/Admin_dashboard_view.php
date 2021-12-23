<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><?php echo $title ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title ?></h4>
            </div>
        </div>
    </div>     
    <style type="text/css">
        .toast {
            max-width: 100% !important;
        }
    </style>
    <!-- end page title --> 
   
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                            <i class="fe-bar-chart-2 font-22 avatar-title text-warning"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $jumlah_pengunjung ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">Pengunjung</p>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                            <i class="fe-book font-22 avatar-title text-danger"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $jumlah_buku ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">Jumlah Buku</p>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 

        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                            <i class="fe-bookmark font-22 avatar-title text-info"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $jenis_buku ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">Jenis Buku</p>
                        </div>
                    </div>
                </div> 
            </div> 
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                            <i class="fe-briefcase font-22 avatar-title text-primary"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $dipinjam ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">Dipinjam</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
        <div class="col-md-6 col-xl-3">
            <div class="widget-rounded-circle card-box">
                <div class="row">
                    <div class="col-6">
                        <div class="avatar-lg rounded-circle bg-soft-blue border-blue border">
                            <i class="fe-corner-left-up font-22 avatar-title text-blue"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $dikembalikan ?></span></h3>
                            <p class="text-muted mb-1 text-truncate">Dikembalikan<br>Hari ini</p>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end widget-rounded-circle-->
        </div> <!-- end col-->
    </div>
    <script src="<?php echo base_url("assets/admin") ?>/chart/highcharts.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/exporting.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/export-data.js"></script>
    <script src="<?php echo base_url("assets/admin") ?>/chart/accessibility.js"></script>
    <script type="text/javascript">
        function get_desa(id,target,dropdown){
           $("#loading").html('Loading data....');
           console.log('id kecamatan' + $(id).val() );
           $.ajax({
            url:'<?php echo site_url(strtolower($controller)."/get_desa2"); ?>/'+$(id).val()+'/'+dropdown,
            success: function(data){
                $("#loading").hide();
                $(target).html('').append(data);
            }
        });
       }
       $(document).ready(function(){
        load_stat_vaksin();
        $('.spinner-grow').hide(); 
        $('#id_pkm,#id_desa_cari,#tahun,#bulan_awal').select2();

    });
       function reset(){
           $('#id_desa_cari,#tahun,#bulan_awal,#id_pkm').val('x').trigger('change');
           load_stat_vaksin();
       }
       function load_stat_vaksin() {
        $('.spinner-grow').show(); 
        $('#tampil_stat').html(""); 
        id_desa_cari = $("#id_desa_cari").val();
        tahun = $("#tahun").val();
        bulan_awal = $("#bulan_awal").val();
        <?php if ($this->session->userdata("admin_level") == "admin") {?> 
            id_pkm = $("#id_pkm").val();
        <?php } ?>
        if (tahun =="" ) {
            swal({   
             title: "Peringatan",   
             type: "warning", 
             text: "Silahkan Pilih Tahun",
             confirmButtonColor: "#22af47",   
         });
            $('.spinner-grow').hide(); 
        } else {
            $.ajax({
                <?php if ($this->session->userdata("admin_level") == "admin") {?> 
                   url :'<?php echo site_url(strtolower($controller)."/load_stat_vaksin"); ?>/'+id_desa_cari+'/'+tahun+'/'+bulan_awal+'/'+id_pkm,
               <?php } else {?>
                   url :'<?php echo site_url(strtolower($controller)."/load_stat_vaksin"); ?>/'+id_desa_cari+'/'+tahun+'/'+bulan_awal,
               <?php } ?>

               success: function(result){
                $("#tampil_stat").html(result);
                $('.spinner-grow').hide(); 

            },

        });
        }
    }
</script>

