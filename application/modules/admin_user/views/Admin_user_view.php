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
                            <span class="btn-label"><i class="fe-user-plus"></i></span>Tambah Member
                        </button>
                        <button type="button" onclick="edit()" class="btn btn-info btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button>
                         <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                        <button type="button" onclick="pdf()" class="btn btn-blue btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-credit-card"></i></span>Kartu Perpustakaan
                        </button>
                        <button type="button" onclick="bio()" class="btn btn-primary btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-user"></i></span>Biodata
                        </button>
                    </div>
                    <hr>
                    <table id="datable_1" class="table table-striped table-bordered table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="float-center">
                                    <div class="checkbox checkbox-primary checkbox-single">
                                        <input id="check-all" type="checkbox">
                                        <label></label>
                                    </div>
                                </th>
                                <th width="5%" ><strong>No.</strong>    </th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>No. Hp</th>
                                <th>Email</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Prodi</th>
                                <th>Angkatan</th>

                                
                                           
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
                         <div class="form-group mb-3">
                            <label class="text-primary"><?php echo $this->om->engine_nama_menu("Admin_fakultas") ?></label>
                            <select name="id_fakultas" id="id_fakultas" class="form-control">
                                <option value="">== Pilih Fakultas ==</option>
                                <?php foreach($fakultas->result() as $row):?>
                                    <option value="<?php echo $row->id_fakultas;?>"><?php echo $row->nama_fakultas;?></option>
                                <?php endforeach;?>
                            </select>
 
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary"><?php echo $this->om->engine_nama_menu("Admin_jurusan") ?></label>
                           
                            <select name="id_jurusan" id="id_jurusan" class="id_jurusan form-control">
                                <option value="">== Pilih Jurusan</option>
                            </select>
                            <small id="loading"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary"><?php echo $this->om->engine_nama_menu("Admin_prodi") ?></label>
                           
                            <select name="id_prodi" id="id_prodi" class="id_prodi form-control">
                                <option value="">== Pilih Program Studi</option>
                            </select>
                            <small id="loading"></small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Angkatan</label>
                            <input class='form-control' name="angkatan" type="number" id="angkatan" autocomplete="off">
                     
                        </div>

                         <div class="form-group mb-3">
                            <label class="text-primary">NIM</label>
                            <input class='form-control' name="nim" type="number" id="nim" autocomplete="off">
                        </div> 
                         <div class="form-group mb-3">
                            <label class="text-primary">Nama Mahasiswa</label>
                            <input class='form-control' name="nama_lengkap" type="text" id="nama_lengkap" autocomplete="off">
                     
                        </div>
                         <div class="form-group mb-3">
                            <label class="text-primary">No. Hp</label>
                            <input class='form-control' name="no_telp" type="number" id="no_telp" autocomplete="off">
                     
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Email</label>
                            <input class='form-control' name="email" type="text" id="email" autocomplete="off">
                     
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Alamat</label>
                            <input class='form-control' name="alamat" type="text" id="alamat" autocomplete="off">
                     
                        </div>
                        <div class="form-group mb-3" id="usernamex">
                            <label class="text-primary">Username</label>
                            <input class='form-control' name="username" type="text" id="username" autocomplete="off">
                     
                        </div>

                        <div class="form-group mb-3" >
                            <label class="text-primary">Password Baru</label>
                            <input type="password" class="form-control" id="password_baru" name="password_baru" ?>
                            <small id="pass1"></small>
                        </div>


                        <div class="form-group mb-3" >
                            <label class="text-primary">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_baru_lagi" name="password_baru_lagi" ?>
                            <small id="pass2"></small>
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

