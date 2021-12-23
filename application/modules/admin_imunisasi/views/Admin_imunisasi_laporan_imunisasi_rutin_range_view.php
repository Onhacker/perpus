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
    <?php if ($this->session->userdata("admin_level") != "admin") {
    	$md = "6";
    	$md2 ="3";
    } else {
    	$md = "4";
    	$md2 ="2";
    } ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="header-title">Form row</h4> -->
                    <p class="text-muted font-13">
                        Gunakan filter pencarian untuk mencetak laporan
                    </p>
                    <?php 
                                     $hari_ini = date('Y-m-d',strtotime("-1 days"));
                                ?>
	                    <form >
	                    	<div class="row">
                                <?php if ($this->session->userdata("admin_level") == "admin") {?>

                                    <div class="col-md-<?php echo $md ?>">
                                        <div class="form-group">
                                            <label for="cwebsite">PKM</label>
                                            <?php 
                                            $id_pkm = isset($id_pkm)?$id_pkm:"";
                                            echo form_dropdown("id_pkm",$this->dm->arr_pkm(),$id_pkm,'id="id_pkm" class="form-control"') 
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-md-<?php echo $md ?>">
                                    <div class="form-group">
                                        <label for="cwebsite">Waktu Awal</label>
                                         <input class='form-control' value="<?php echo tgl_view($hari_ini) ?>" data-date-autoclose="true"  type="text" id="range_awal"  autocomplete="off">
                                      
                                    </div>
                                </div>
                                <style type="text/css">
                                    .datepicker{ z-index:99999 !important; }
                                </style>


                                <div class="col-md-<?php echo $md ?>">
                                    <div class="form-group">
                                        <label for="cwebsite">Waktu Akhir</label>
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
            $('#id_pkm').select2();
            $('#range_awal,#range_akhir').datepicker({
            format: 'dd-mm-yyyy',
         
        });
    
    })
    function cetak() {
        <?php 
        if ($this->session->userdata("admin_level") != "admin") {?>
            id_pkm = <?php echo $this->session->userdata("admin_pkm"); ?>
        <?php } else {?>
            id_pkm = $("#id_pkm").val();
        <?php }
        ?>
    

        awal = $("#range_awal").val();
        akhir = $("#range_akhir").val();

        if (awal == ""  || id_pkm == "" || akhir == "" ) {
            <?php if ($this->session->userdata("admin_level") == "admin") {?>
                swal({   
                     title: "Peringatan",   
                     type: "warning", 
                     text: "Silahkan Pilih Waktu, PKM",
                     confirmButtonColor: "#22af47",   
                });
            <?php } else {?>
                swal({   
                     title: "Peringatan",   
                     type: "warning", 
                     text: "Silahkan Pilih Waktu",
                     confirmButtonColor: "#22af47",   
                });
            <?php } ?>
            $('.spinner-grow').hide(); 
        } else {
            // alert(awal1[0]);;
        window.open("<?php echo site_url(strtolower($controller)."/laporan_imunisasi_rutin_range_pdf"); ?>/"+awal+'/'+akhir+'/'+id_pkm);
              
        }
    }
</script>


