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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="header-title">Form row</h4> -->
                    <p class="text-muted font-13">
                        Gunakan filter pencarian untuk mencetak laporan
                    </p>

                    <form>
                        <div class="row">


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cwebsite">Tahun </label>
                                    <?php 
                                    $tahun = isset($tahun)?$tahun:date("Y");
                                    echo form_dropdown("tahun",$this->dm->arr_tahun(),$tahun,'id="tahun" class="form-control" data-toggle="select2"') 
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label for="inputPassword4" >Penandatangan</label>
                                   <select name="ttd" id="ttd" data-toggle="select2" class="form-control">
                                        <option value="x">== Pilih Penandatangan ==</option>
                                        <option value="kadis" selected="">Kepala Dinas</option>
                                        <option value="kasi"> Ka.Seksi surveilans dan Imunisasi</option>
                                        <option value="kabid"> Kabid P2P</option>
                                    </select>
                                </div>
                            </div>



                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                 <a href="javascript:void(0);" onclick="cetak()" class="btn btn-blue btn-sm ">
                                    <i class="fa fa-search"></i> Cetak
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
    

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('.spinner-grow').hide(); 
         $('#tahun,#bulan_awal,#ttd').select2();
    })
    function cetak() {
        ttd = $("#ttd").val();
        tahun = $("#tahun").val();
        // bulan_awal = $("#bulan_awal").val();
        if (tahun =="" ) {
            swal({   
               title: "Peringatan",   
               type: "warning", 
               text: "Silahkan Pilih Tahun",
               confirmButtonColor: "#22af47",   
           });
            $('.spinner-grow').hide(); 
        } else {
        window.open("<?php echo site_url(strtolower($controller)."/pdf_laporan_dinas"); ?>/"+tahun+"/"+ttd);
              
        }
    }
</script>


