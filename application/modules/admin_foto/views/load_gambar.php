<link href="<?php echo base_url(); ?>assets/admin/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
<p>&nbsp;</p>
 <div class="col-sm-12 col-xl-12">
	<div class="d-flex justify-content-center">
		<h4 class="header-title" >Gallery <?php echo $subtitle ?></h4></h4>
	</div>
</div>
<div class="col-sm-12 col-xl-12">
	<div class="d-flex justify-content-center">
		<h4 class="header-title" id="title_gal"><code><?php echo $jum_ga ?></code></h4>
	</div>
</div>
<div class="row filterable-content" >
<?php foreach ($gal->result() as $row) : ?>
	<div class="col-sm-6 col-xl-3 filter-item all web illustrator">
		<div class="gal-box">
			<a href="<?php echo base_url("upload/gambar/").$row->gbr_gallery ?>" class="image-popup" title="<?php echo $row->keterangan ?>">
				<img src="<?php echo base_url("upload/gambar/").$row->gbr_gallery ?>" class="img-fluid" alt="work-thumbnail">
			</a>
			&nbsp;<a href="javascript: void(0);" onclick="hapus_gambar_thumb(<?php echo $row->id_gallery ?>)" class="gal-like-btn"><i class="fa fa-trash text-danger"></i> Hapus</a>
		</div>
	</div> <!-- end col -->
<?php endforeach ?>
</div>
<script src="<?php echo base_url("assets/admin") ?>/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/js/pages/gallery.init.js"></script>


<script type="text/javascript">
	function loader() {
		Swal.fire({
			title: "Prosess...",
			html: "Jangan tutup halaman ini",
			allowOutsideClick: false,
			onBeforeOpen: function() {
				Swal.showLoading()
			},
			onClose: function() {
				clearInterval(t)
			}
		})
	}

	function hapus_gambar_thumb(id) {
	        Swal.fire({
            title: "Yakin ingin menghapus ?",
            text: "Anda tidak dapat mengembalikan data terhapus",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya Hapus",
            cancelButtonText: "Batal",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                loader();
                $.ajax({
                    type: "POST",
                    url : "<?php echo site_url(strtolower($controller).'/hapus_gambar_thumb')?>/",
                    data : {id:id},
                    cache : false,
                    dataType: "json",
                    success: function(result) {
                        Swal.close();
                        if(result.success == false){
                            Swal.fire(result.title,result.pesan, "error");
                            return false;
                        } else {
                        	load_gambar();
                            Swal.fire(result.title,result.pesan, "success");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        Swal.fire("Berhasil","Gambar Berhasil dihapus", "success");
                    }
                });
            } else {
                // $('#summernote').summernote("insertImage", src);
            }
        })
    }
</script>