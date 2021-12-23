<link href="<?php echo base_url(); ?>assets/admin/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $title ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $subtitle ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $subtitle ?></h4>
            </div>
        </div>
    </div>     

    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <h4 class="header-title mb-4"> <a href="<?php echo site_url(strtolower($controller)) ?>">
                    <button type="button" class="btn btn-danger btn-xs    waves-effect waves-light">
                        <span class="btn-label"><i class="fe-arrow-left"></i></span>Kembali ke Semua Album</button>
                    </a></h4>

                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item">
                        <a href="#home1" data-toggle="tab" onclick="load_gambar()" aria-expanded="false" class="nav-link active">
                            Gallery <?php echo $subtitle ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link ">
                            Upload
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="home1">
                        <div class="d-flex justify-content-center">
                            <div class="row">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <label>Tampilkan</label>
                                    </div>
                                    <div class="form-group mx-sm-3">
                                       <select class="form-control" id="jumlah_gambar">
                                            <option value="5">5 gambar</option>
                                            <option value="10">10 gambar</option>
                                            <option value="20">20 gambar</option>
                                            <option value="40">40 gambar</option>
                                            <option value="50">50 gambar</option>
                                            <option value="all">Semua</option>
                                        </select>
                                    </div>
                                    <button onclick="load_gambar()" class="btn btn-primary waves-effect waves-light">Lihat Gallery</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border avatar-lg text-primary m-2" role="status" id="loader" style="display: none;"></div>
                        </div>
                        <div id="load_gambar"></div>
                    </div>


                    <div class="tab-pane " id="profile1">
                         <h4 id="ab" class="header-title">Proses Upload ke <?php echo $subtitle ?></h4>
                         <p id="ac" class="sub-header">
                            Kecepatan upload gambar tergantung dari jaringan.
                        </p>
                        <form action="#" method="post" class="dropzone" id="myAwesomeDropzone">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                            <div class="dz-message needsclick">
                                <i class="h1 text-muted dripicons-cloud-upload"></i>
                                <h3>Drop File atau klik untuk upload</h3>
                                <span class="text-muted font-13">(Maksimal gambar 3 Mb)</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div><!-- end col-->
</div>
<!-- end row-->
<script src="<?php echo base_url("assets/admin") ?>/libs/dropzone/dropzone.min.js"></script>

<script type="text/javascript">
     $(document).ready(function(){
        load_gambar();
    });
	Dropzone.autoDiscover = false;

	var foto_upload= new Dropzone(".dropzone",{
		url : "<?php echo site_url(strtolower($controller).'/proses_upload')?>/",
		maxFilesize: 3,
		method:"post",
		acceptedFiles:"image/*",
		paramName:"userfile",
		dictInvalidFileType:"Type file ini tidak dizinkan, Pilih tipe file gambar",
		dictFileTooBig:"File gambar Maksimal 3 Mb",
		addRemoveLinks:true,
		dictRemoveFile : "Hapus",
        success: function(file, response){
            // load_gambar_succes();
        }
       
    });

	//Event ketika Memulai mengupload
	foto_upload.on("sending",function(a,b,c,){
        id_album = <?php echo $id_album ?>;
        a.token = Math.random()+'onhacker'+id_album;
		c.append("token_foto",a.token); //Menmpersiapkan token untuk masing masing foto
	});


	foto_upload.on("error", function(file, errorMessage) {     
		Swal.fire({
			title: "Gagal ",
			text: errorMessage,
			type: "error",
			confirmButtonClass: "btn btn-confirm mt-2",
		});
	});

//Event ketika foto dihapus
foto_upload.on("removedfile",function(a){
	var token=a.token;
	$.ajax({
		type:"post",
		data:{token:token},
		url : "<?php echo site_url(strtolower($controller).'/remove_mul')?>/",
		cache:false,
		dataType: 'json',
		success: function(){
            console.log("Foto terhapus");
        },
        error: function(){
         console.log("Error");

     }
 });
});

function upload(){
}

function load_gambar(){
    $("#load_gambar").html("");
    $("#loader").show();
    jumlah_gambar = $("#jumlah_gambar").val();
    id = <?php echo $id_album; ?>;
    $.ajax({
        url : "<?php echo site_url(strtolower($controller)) ?>/load_gambar/" + id +'/'+ jumlah_gambar,
        success: function(result){
            swal.close();
            $("#loader").hide();
            $("#load_gambar").html(result);

        }
    })
}

// $(window).bind('beforeunload', function(){
//   return 'Are you sure you want to leave?';
// });

</script>

</div>

