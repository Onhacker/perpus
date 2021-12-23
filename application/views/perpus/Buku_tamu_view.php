<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?php echo $title ?></h4>
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
                                    <label class="text-primary" for="simpleinput">Nama</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($nama))?$nama:"";  ?>"  id="nama" name="nama" autocomplete="off">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Email</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($email))?$email:"";  ?>"  id="email" name="email" autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Alamat</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($alamat))?$alamat:"";  ?>"  id="alamat" name="alamat" autocomplete="off">
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Pesan</label>
                                    <textarea  class='form-control' name='pesan' id="pesan"><?php echo $pesan ?></textarea>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="password" style="color: #00a192 !important ;">Captcha</label><br>
                                    <span class="text-primary"><code id="Capctha"><?php echo $kode ?></code></span>
                                    <input class="form-control" type="text" required="" name="captcah" id="captcah" placeholder="Masukkan angka" autocomplete="off">
                                </div>
                                <div class="row">
                                  <div class="col-6">
                                    <a href="javascript:;" onclick="send()" id="btn-login" class="btn btn-primary btn-block">Kirim</a>
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
<?php $this->load->view("Buku_tamu_js"); ?>


    
</div>
