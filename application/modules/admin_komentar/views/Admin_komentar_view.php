<link href="<?php echo base_url(); ?>assets/admin/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url("assets/admin") ?>/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <div class="button-list">
                       <!--  <button type="button" onclick="add()" class="btn btn-success btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                        </button>
                        <button type="button" onclick="edit()" class="btn btn-info btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button> -->
                        <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                    </div>
                    <hr>
                    <table id="datable_1" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="float-center">
                                    <div class="checkbox checkbox-primary checkbox-single">
                                        <input id="check-all" type="checkbox">
                                        <label></label>
                                    </div>
                                </th>
                                <th width="5%" ><strong>No.</strong>    </th>
                                <th width="15%">Nama</th>
                                <th width="15%">Waktu</th>
                                <th width="10%">Email</th>
                                <th width="25%" >Komentar</th>
                                <th width="30%"><?php echo $this->om->engine_nama_menu("Admin_post") ?></th>
                                <th >Aksi</th>
                               
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->



    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-full modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                   <form id="form_app" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" name="id_halaman" id="id_halaman">
                        <div class="form-group mb-3">
                            <label class="text-primary">Judul</label>
                            <input class='form-control' name="judul" type="text" id="judul" placeholder="Judul">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Isi Halaman</label>
                            <textarea id='summernote' class='form-control' name='isi_halaman'></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Gambar Utama</label>
                            <div class="col-sm-6 col-xl-3 filter-item all graphic illustrator">
                                <div class="gal-box">
                                    <div class="gall-info">
                                        <div class="image-upload">
                                            <label for="gambar">
                                                <img  id="previewImage" class="img-fluid" alt="" style="cursor: pointer;">
                                            </label>
                                            <input type="file" name="gambar" id="gambar" onchange="return previewImage_click()" />
                                            <span class="text-muted ml-1" id="text_upload">Klik gambar untuk untuk mengganti</span>
                                        </div>
                                    </div> 
                                    <div class="gall-info" id="hapus_gambar" onclick="hapus_gambar_thumb()" style="display: none;">
                                        <h4 class="font-16 mt-0"  ><a href="javascript: void(0);" ><i class="fa fa-trash text-danger"></i> hapus</a></h4>
                                    </div> 
                                </div> 
                            </div>
                        </div> 
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
                    <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




<div id="gambar_preview" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-animation="fadein" style="display: none;">
        <div class="modal-dialog img-fluid img-thumbnail modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodalpreview-title" id="full-width-modalLabel">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                        <img  id="preview_gambar" class="img-fluid" alt="work-thumbnail">
                      
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Tutup </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php
    $this->load->view("backend/global_css");
    $this->load->view("backend/global_js");
    $this->load->view($controller."_js");
    ?>
</div>

