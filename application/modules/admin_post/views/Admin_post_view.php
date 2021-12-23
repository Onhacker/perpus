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
                        <button type="button" onclick="add()" class="btn btn-success btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                        </button>
                        <button type="button" onclick="edit()" class="btn btn-info btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button>
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
                                <th>Judul</th>
                                <th><?php echo $this->om->engine_nama_menu("Admin_kategori") ?></th>
                                <th>Waktu Post</th>
                                <th width="12%">Status/ Link/ Copy</th>
                                <?php if($this->session->userdata("admin_level") == "admin"){?>
                                   <th>Penulis</th>
                                <?php } ?>                 
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
                        <input type="hidden" name="id_berita" id="id_berita">
                        <div class="form-group mb-3">
                            <label class="text-primary">Judul</label>
                            <input class='form-control' name="judul" type="text" id="judul" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Sub Judul</label>
                            <input class='form-control' name="sub_judul" type="text" id="sub_judul"autocomplete="off" >
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary"><?php echo $this->om->engine_nama_menu("Admin_kategori") ?></label>
                            <?php 
                            $id_kategori = isset($id_kategori)?$id_kategori:"";
                            echo form_dropdown("id_kategori",$this->dm->arr_kategori(),$id_kategori,'id="id_kategori" class="form-control"') 
                            ?>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Headline</label>
                                            <select name="headline" id="headline" class="form-control">
                                                
                                                <option value="N" class="text-danger">Tidak</option>
                                                <option value="Y">Ya</option>
                                            </select>
                                        </div>
                                    </div> <!-- end col -->
                                    
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Pilihan</label>
                                            <select name="pilihan" id="pilihan" class="form-control">
                                                
                                                <option value="N">Tidak</option>
                                                <option value="Y">Ya</option>
                                            </select>
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Utama</label>
                                            <select name="utama" id="utama" class="form-control">
                                               
                                                <option value="N">Tidak</option>
                                                <option value="Y">Ya</option>
                                            </select>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div> <!-- end col -->
                        </div>


                       <div class="row">
                            <div class="col-12">
                                <div class="row">

                                    <div class="col-md-9">
                                        <div class="card-box">
                                            <div class="form-group mb-3">
                                                <label class="text-primary">Isi Post</label>
                                                <textarea id='summernote' class='form-control' name='isi_berita'></textarea>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="card-box" >
                                            <h4 class="header-title mb-3 text-primary">Tag</h4>
                                            <div class="todoapp">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 id="todo-message"><span id="todo-remaining"></span><span id="todo-total"></span> Cek Tag</h5>
                                                    </div>
                                                    <?php $cek = $this->om->engine_akses_menu("Admin_tag",$this->session->userdata("admin_session")); 
                                                    if($cek == 1 OR $this->session->userdata("admin_level") == "admin"){ ?>
                                                    <div class="col-auto">
                                                        <h5 id="todo-message" class="float-right"><span id="todo-remaining"></span><span id="todo-total"></span> Hapus</h5>
                                                    </div>
                                                    <?php } ?>
                                                </div>

                                                <ul id="load_tag" class="list-group list-group-flush" style="max-height: 330px; overflow: scroll;" >
                                              
                                                </ul>
                                                <?php $cek = $this->om->engine_akses_menu("Admin_tag",$this->session->userdata("admin_session")); 
                                                if($cek == 1 OR $this->session->userdata("admin_level") == "admin"){ ?>
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="text"  id="tag_val" class="form-control" placeholder="Tambah Tag" autocomplete="off">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button onclick="add_tag()" class="btn-primary btn-md btn-block btn waves-effect waves-light" type="button" id="todo-btn-submit"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card-box">
                                            <h4 class="header-title mb-3 text-primary">Gambar Utama</h4>
                                            <div class="col-sm-6 col-xl-12 filter-item all graphic illustrator">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5  id="text_upload">Klik gambar untuk untuk mengganti</h5>
                                                    </div>
                                                    <div class="col-auto" id="hapus_gambar"  style="display: none;">
                                                        <a href="javascript: void(0);" class="float-right btn btn-light btn-xs waves-effect waves-light" onclick="hapus_gambar_thumb()" ><i class="fa fa-trash text-danger"></i> hapus gambar</a>
                                                    </div>
                                                </div>
                                                <div class="gall-info">
                                                    <div class="image-upload" >
                                                        <label for="gambar">
                                                            <img  id="previewImage" class="img-fluid img-thumbnail" alt="" style="cursor: pointer;">
                                                        </label>
                                                        <input type="file" name="gambar" id="gambar" onchange="return previewImage_click()" />
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label class="text-primary">Keterangan Gambar</label>
                                                    <input class='form-control' name="keterangan_gambar" type="text" id="keterangan_gambar" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-box">
                                            <div class="form-group mb-3">
                                                <label class="text-primary">Video Youtube</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="youtube"  id="youtube" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-danger waves-effect waves-light"  onclick="load_you()" type="button"><i class="fe-video"></i>  Preview</button>
                                                    </div>

                                                </div>
                                                <small>Masukkan link youtube. Contoh <code><a href="https://youtu.be/ZXPymFxxi7c" target="_BLANK">https://youtu.be/ZXPymFxxi7c</a> lalu klik tombol preview untuk memastikan video tampil.</code></small>
                                                
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="text-primary">Tanggal Posting</label>
                                                <input type="text" class="form-control" data-provide="datepicker" name="tanggal" id="tanggal" data-date-autoclose="true" autocomplete="off">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="text-primary">Pukul Posting</label>
                                                <input type="text" class="form-control" name="jam"  id="jam" autocomplete="off">
                                                <small>Format Pukul Jam:menit:detik</small>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <?php if ($this->session->userdata("admin_permisson") == "Y") {?>
                        <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
                        <button type="button" onclick="simpan('N')" class="btn btn-warning waves-effect waves-light">Simpan Sebagai Draft</button>
                        <button type="button" onclick="simpan('Y')" class="btn btn-primary waves-effect waves-light">Simpan dan Publish</button>
                    <?php } else {?>
                        <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
                        <button type="button" onclick="simpan('N')" class="btn btn-primary waves-effect waves-light">Simpan</button>
                    <?php } ?>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <?php
    $this->load->view("backend/global_css");
    $this->load->view("backend/global_js");
    $this->load->view($controller."_js");
    ?>
</div>


<div id="video_modal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog border border-primary  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="video-title" id="myModalLabel">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border avatar-lg text-primary m-2" role="status" id="loader_video" ></div>
                </div>
                <div class="embed-responsive embed-responsive-16by9" id="load_you"><span style="display: none;"></span></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Tutup Preview</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->