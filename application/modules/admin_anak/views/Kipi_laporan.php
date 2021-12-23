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
    	$md = "4";
    	$md2 ="4";
    } else {
    	$md = "3";
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
	                    <form >
	                    	<div class="row">
	                    		<div class="col-md-<?php echo $md ?>">
	                    			<div class="form-group">
	                    				<label for="cwebsite">Tahun Vaksin</label>
	                    				<?php 
	                    				$tahun = isset($tahun)?$tahun:date("Y");
	                    				echo form_dropdown("tahun",$this->dm->arr_tahun(),$tahun,'id="tahun_cari"  class="form-control" data-toggle="select2"') 
	                    				?>
	                    			</div>
	                    		</div>

	                    		<?php if ($this->session->userdata("admin_level") == "admin") {?>

	                    			<div class="col-md-<?php echo $md ?>">
	                    				<div class="form-group">
	                    					<label for="cwebsite">PKM</label>
	                    					<?php 
	                    					$id_pkm = isset($id_pkm)?$id_pkm:"";
	                    					echo form_dropdown("id_pkm",$this->dm->arr_pkm(),$id_pkm,'id="id_pkm" onchange="get_desa(this,\'#id_desa_cari\',1)" class="form-control"') 
	                    					?>
	                    				</div>
	                    			</div>
	                    		<?php } ?>

	                    		<div class="col-md-<?php echo $md ?>">
	                    			<div class="form-group">
	                    				<label for="cwebsite">Desa</label>
	                    				<?php 
	                    				$desa = isset($desa)?$desa:"";
	                    				echo form_dropdown("id_desa",$this->dm->arr_desa2(),$desa,'id="id_desa_cari"  class="form-control" data-toggle="select2"') 
	                    				?>
	                    				<small id="loading" class="text-danger"></small>
	                    			</div>
	                    		</div>
	                    		<div class="col-md-<?php echo $md ?>">
	                    			<div class="form-group">
	                    				<label >Jenis Kelamin</label>
	                    				<select class="form-control" name="jk" id="jk_cari">
	                    					<option value="x">Semua Jenis Kelamin</option>
	                    					<option value="L">Laki-Laki</option>
	                    					<option value="P">Perempuan</option>
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
    	$('#id_desa_cari,#tahun_cari,#id_pkm').select2();
        $('.spinner-grow').hide(); 
         $('#tahun,#bulan_awal,#ttd').select2();
    })
    function cetak() {
        <?php 
        if ($this->session->userdata("admin_level") != "admin") {?>
            id_pkm = <?php echo $this->session->userdata("admin_pkm"); ?>
        <?php } else {?>
            id_pkm = $("#id_pkm").val();
        <?php }
        ?>
        
        tahun = $("#tahun_cari").val();
        id_desa = $("#id_desa_cari").val();
        jk = $("#jk_cari").val();
        if (tahun == ""  || id_pkm == "" ) {
            <?php if ($this->session->userdata("admin_level") == "admin") {?>
                swal({   
                     title: "Peringatan",   
                     type: "warning", 
                     text: "Silahkan Pilih Tahun, PKM",
                     confirmButtonColor: "#22af47",   
                });
            <?php } else {?>
                swal({   
                     title: "Peringatan",   
                     type: "warning", 
                     text: "Silahkan Pilih Tahun",
                     confirmButtonColor: "#22af47",   
                });
            <?php } ?>
            
            $('.spinner-grow').hide(); 
        } else {
        window.open("<?php echo site_url(strtolower($controller)."/laporan_bayi_pdf"); ?>/"+tahun+'/'+id_pkm+'/'+id_desa+'/'+jk);
              
        }
    }
</script>


