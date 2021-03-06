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
    <!-- end page title --> 

    <!-- end row-->
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="header-title"><?php echo $title ?> </h4>
                    </div>
                </div> <!-- end row -->
               <!--  <p class="text-muted font-13">
                    Gunakan filter pencarian untuk menampilkan grafik
                </p> -->
                <p></p>
                    <?php if ($this->session->userdata("admin_level") != "admin") {
                        $md = "4";
                    } else {
                        $md = "4";
                    } ?>
                    <form>
                        <div class="row">
                        
                      

                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Tahun </label>
                                <?php 
                                $tahun = isset($tahun)?$tahun:"";
                                echo form_dropdown("tahun",$this->ma->arr_tahun(),$tahun,'id="tahun" class="form-control" data-toggle="select2"') 
                                ?>
                            </div>
                        </div>
                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Bulan</label>
                                <?php 
                                $bulan_awal = isset($bulan_awal)?$bulan_awal:"";
                                echo form_dropdown("bulan_awal",$this->ma->arr_bulan(),$bulan_awal,'id="bulan_awal" class="form-control" data-toggle="select2"') 
                                ?>
                            </div>
                        </div>
                         <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Vaksin</label>
                                <?php 
                                $jenis_vaksin = isset($jenis_vaksin)?$jenis_vaksin:"";
                                echo form_dropdown("jenis_vaksin",$this->ma->arr_vaksin(),$jenis_vaksin,'id="jenis_vaksin"  class="form-control" data-toggle="select2"') 
                                ?>
                                <small id="loading" class="text-danger"></small>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                            <a href="javascript:void(0);" onclick="reset()" class="btn btn-danger btn-sm ">
                                <i class="fa fa-undo"></i> Reset
                            </a>
                             <a href="javascript:void(0);" onclick="load_stat_vaksin()" class="btn btn-blue btn-sm ">
                                <i class="fa fa-search"></i> Tampilkan
                            </a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <div class="d-flex justify-content-center"><div class="spinner-grow text-primary m-2" role="status"></div></div>
                <div id="tampil_stat"></div>
            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div>


    </div>
</div>
<script src="<?php echo base_url("assets/admin") ?>/chart/highcharts.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/exporting.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/export-data.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/accessibility.js"></script>
<script type="text/javascript">
 
    $(document).ready(function(){
            load_stat_vaksin();
        $('.spinner-grow').hide(); 
        $('#jenis_vaksin,#tahun,#bulan_awal').select2();

    });
    function reset(){
         $('#jenis_vaksin,#tahun,#bulan_awal').val('x').trigger('change');
            load_stat_vaksin();  
    }
    function load_stat_vaksin() {
        $('.spinner-grow').show(); 
        $('#tampil_stat').html(""); 
        jenis_vaksin = $("#jenis_vaksin").val();
        tahun = $("#tahun").val();
        bulan_awal = $("#bulan_awal").val();
        if (tahun == "" ) {
                swal({   
                 title: "Peringatan",   
                 type: "warning", 
                 text: "Silahkan Pilih Tahun",
                 confirmButtonColor: "#22af47",   
            });
                $('.spinner-grow').hide(); 
            } else {
                $.ajax({
                       url :'<?php echo site_url(strtolower($controller)."/load_stat_vaksin_pkm"); ?>/'+jenis_vaksin+'/'+tahun+'/'+bulan_awal,
               
                   success: function(result){
                    $("#tampil_stat").html(result);
                    $('.spinner-grow').hide(); 

                    },

                });
            }  
        
    }
</script>


