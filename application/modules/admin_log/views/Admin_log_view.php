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
                       
                        <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                         <button type="button" onclick="reload_table()" class="btn btn-primary btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fe-rotate-ccw"></i></span>Refresh
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
                                <th width="70%">Query</th>
                                <th width="20%">Waktu</th>
                                <?php if($this->session->userdata("admin_level") == "admin"){?>
                                   <th>Eksekutor</th>
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
        <div class="modal-dialog  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">??</button>
                </div>
                <div class="modal-body">
                    <form id="form_app" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" name="id_kategori" id="id_kategori">
                        <div class="form-group mb-3">
                            <label class="text-primary">Nama Kategori</label>
                            <input class='form-control' name="nama_kategori" type="text" id="nama_kategori" autocomplete="off">
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-box">
                                            <h4 class="header-title mb-3 text-primary">Gambar Utama</h4>
                                            <div class="col-sm-12 col-xl-12 filter-item all graphic illustrator">
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
                                                        <input type="file" name="gambar_utama" id="gambar" onchange="return previewImage_click()" />
                                                    </div>
                                                </div> 
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
    $this->load->view($controller."_js");
    ?>
  
</div>
