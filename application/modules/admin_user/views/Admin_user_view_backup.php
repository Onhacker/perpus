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
                                <th>Foto</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Tgl Reg</th>
                                <th>Blokir</th>
                                
                                           
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
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="form_app" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" name="username" id="username">
                        <div id="add_member" style="display: none">
                         <div class="form-group mb-3" >
                            <label class="text-primary">Username</label>
                            <input class='form-control' name="member" type="text" id="member" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Password</label>
                            <input class='form-control' name="pass_member" type="password" id="pass_member" autocomplete="off">
                        </div>
                         <div class="form-group mb-3">
                            <label class="text-primary">Konfirmasi Password</label>
                            <input class='form-control' name="konfirmasi" type="password" id="konfirmasi" autocomplete="off">
                        </div>
                          <div class="form-group mb-3">
                            <label class="text-primary">Level</label>
                            <select name="posisi" id="posisi" class="form-control">
                                <option value="user" class="text-danger">User</option>
                                <option value="admin">Admin</option>
                            </select>
                            <small>Anda dapat mengatur hak akses untuk level user. Jika memilih level admin, semua modul di sistem dapa diakses, silahkan pilih level admin ke orang yang terpercaya</small>
                        </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Nama Lengkap</label>
                            <input class='form-control' name="nama_lengkap" type="text" id="nama_lengkap" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Email</label>
                            <input class='form-control' name="email" type="text" id="email" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">No Telp</label>
                            <input class='form-control' name="no_telp" type="text" id="no_telp" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Blokir</label>
                            <select name="blokir" id="blokir" class="form-control">

                                <option value="N" class="text-danger">Tidak</option>
                                <option value="Y">Ya</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Permission Publish</label>
                            <select name="permission_publish" id="permission_publish" class="form-control">

                                <option value="N">Tidak</option>
                                <option value="Y">Ya</option>
                            </select>
                            <small>Pilih ya jika user diizinkan untuk langsung menerbitkan posting. Pilih tidak jika postingan user harus diverifikasi oleh admin terlebih dahulu</small>
                        </div>

                     

                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-box">
                                            <h4 class="header-title mb-3 text-primary">Foto</h4>
                                            <div class="col-sm-12 col-xl-12 filter-item all graphic illustrator">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5  id="text_upload">Klik gambar untuk untuk mengganti</h5>
                                                    </div>
                                                    <div class="col-auto" id="hapus_gambar"  style="display: none;">
                                                        <a href="javascript: void(0);" class="float-right btn btn-light btn-xs waves-effect waves-light" onclick="hapus_gambar_thumb()" ><i class="fa fa-trash text-danger"></i> hapus foto</a>
                                                    </div>
                                                </div>
                                                <div class="gall-info">
                                                    <div class="image-upload" >
                                                        <label for="gambar">
                                                            <img  id="previewImage" class="img-fluid img-thumbnail" alt="" style="cursor: pointer;">
                                                        </label>
                                                        <input type="file" name="foto" id="gambar" onchange="return previewImage_click()" />
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
                   
                        <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
                     
                        <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
                  
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

