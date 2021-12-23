<link href="<?php echo base_url("assets/admin") ?>/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><?php echo $title ?></li>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="form_app" method="post"  enctype="multipart/form-data" >

                             

                              
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="simpleinput">Nama System</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->nama_website))?$record->nama_website:"";  ?>"  id="nama_website" name="nama_website" placeholder="">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Provinsi</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->propinsi))?$record->propinsi:"";  ?>"  id="propinsi" name="propinsi" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Kabupaten/Kota</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->kabupaten))?$record->kabupaten:"";  ?>"  id="kabupaten" name="kabupaten" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Universitas</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->universitas))?$record->universitas:"";  ?>"  id="universitas" name="universitas" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Alamat</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->alamat))?$record->alamat:"";  ?>"  id="alamat" name="alamat" placeholder="">
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Telepon</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->no_telp))?$record->no_telp:"";  ?>"  id="no_telp" name="no_telp" placeholder="">
                                </div>
                               
                                
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Email</label>
                                     <input type="text" class="form-control" value="<?php echo (isset($record->email))?$record->email:"";  ?>"  id="email" name="email" placeholder="">
                                    <small class="text-info">Email ini digunakan sebagai pengirim pesan otomatis (Seperti mengirim link reset password otomatis) .</small>
                                </div>
                             
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Waktu Lokasi</label>
                                    <?php    
                                    $arr_waktu = array("Asia/Jakarta"=>"WIB",
                                      "Asia/Makassar" => "WITA",
                                      "Asia/Jayapura" => "WIT");
                                    $waktu = isset($record->waktu)?$record->waktu:"";
                                    echo form_dropdown("waktu",$arr_waktu,$waktu,'class="form-control"') ?>
                                 
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-group mb-3">
                                        <label class="text-primary">Profil</label>
                                        <textarea id='summernote' class='form-control summernote' name='profil'><?php echo $record->profil ?></textarea>
                                    </div>
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Visi</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->visi))?$record->visi:"";  ?>"  id="visi" name="visi" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-group mb-3">
                                        <label class="text-primary">Misi</label>
                                        <textarea id='summernote_misi' class='form-control summernote_misi' name='misi'><?php echo $record->misi ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-group mb-3">
                                        <label class="text-primary">Struktur Organisasi</label>
                                        <textarea id='summernote_str' class='form-control summernote_str' name='str'><?php echo $record->str ?></textarea>
                                    </div>
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Denda Jika Melewati batas Pengembalian Buku (Rp)/ Hari</label>
                                    <input type="number" class="form-control" value="<?php echo (isset($record->denda))?$record->denda:"";  ?>"  id="denda" name="denda" placeholder="">
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Deskripsi Web</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->meta_deskripsi))?$record->meta_deskripsi:"";  ?>"  id="meta_deskripsi" name="meta_deskripsi" placeholder="">
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Kata Kunci Google</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->meta_keyword))?$record->meta_keyword:"";  ?>"  id="meta_keyword" name="meta_keyword" placeholder="">
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="text-primary" for="example-email">Favicon</label>
                                                    <input type="file" name="favicon" id="favicon" onchange="return validasiFile()" class="dropify" data-default-file="<?php echo base_url() ?>assets/images/<?php echo(isset($record->favicon))?$record->favicon:""; ?>" />
                                                 
                                                </div>
                                            </div> 

                                        </div> 
                                    </div>
                                </div>

                                <div class="row">
                                  <div class="col-6">
                                    <a href="javascript:;" onclick="update()" id="btn-login" class="btn btn-primary btn-block">Update</a>
                                </div>
                                <div class="col-6">
                                    <button type="reset" onclick="home()" class="btn btn-block  btn-secondary waves-effect m-l-5">
                                        Batal
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view($controller."_js"); ?>
<?php $this->load->view("backend/global_js"); ?>

<div id="md" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog border border-primary  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="video-title" id="myModalLabel">Cara mendapatkan kode lokasi di maps</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <ol type="1">
                    <li>Buka <a href="https://www.google.com/maps/preview" target="_BLANK">Google Maps</a> </li>
                    <li>Pada kotak pencarian, masukkan lokasi yang ingin dicari</li>
                    <li>Di kiri atas, Klik menu atau icon <i class="fa fa-bars"></i> </li>
                    <li>Klik Bagikan</li>
                    <li>Klik Sematkan Peta</li>
                    <li>Klik Salin HTML</li>
                    <li>Terakhir, Paste kode yang disalin tadi ke form isian </li>
                </ol> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

   


    
</div>
