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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="header-title">Form row</h4> -->
                    <p class="text-muted font-13">
                        Gunakan filter tanggal pencarian untuk mencetak laporan berdasarkan waktu
                    </p>
                    <?php 
                    $hari_ini = date('Y-m-d',strtotime("-1 days"));
                    ?>
                    <form >
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cwebsite">Tanggal Awal</label>
                                <input class='form-control' value="<?php echo tgl_view($hari_ini) ?>" data-date-autoclose="true"  type="text" id="range_awal"  autocomplete="off">

                            </div>
                        </div>
                        <style type="text/css">
                            .datepicker{ z-index:99999 !important; }
                        </style>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cwebsite">Tanggal Akhir</label>
                                <input class='form-control' data-date-autoclose="true" value="<?php echo tgl_view(date("Y-m-d")) ?>"  type="text" id="range_akhir"  autocomplete="off">
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
        $('#range_awal,#range_akhir').datepicker({
            format: 'dd-mm-yyyy',

        });

    })
    function cetak() {
        awal = $("#range_awal").val();
        akhir = $("#range_akhir").val();

        if (awal == ""  || akhir == "" ) {
                swal({   
                   title: "Peringatan",   
                   type: "warning", 
                   text: "Silahkan Pilih Waktu",
                   confirmButtonColor: "#22af47",   
               });
            $('.spinner-grow').hide(); 
        } else {
            window.open("<?php echo site_url(strtolower($controller)."/laporan_buku_tamu_pdf"); ?>/"+awal+'/'+akhir);

        }
    }
</script>


