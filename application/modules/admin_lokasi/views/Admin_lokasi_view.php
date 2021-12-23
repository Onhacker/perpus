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
                                    <label class="text-primary" for="simpleinput">Lintang</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->lintang))?$record->lintang:"";  ?>"  id="lintang" name="lintang" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="simpleinput">Bujur</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->bujur))?$record->bujur:"";  ?>"  id="bujur" name="bujur" placeholder="">
                                </div>


                                <div class="row">
                                  <div class="col-12">
                                    <p class="text-info">Silahkan masukkan lintang dan bujur berdasarkan google maps. Sinkronisasi dengan aplikasi PPDB dilakukan tgl 12 Juli Pukul 08.00. Silahkan cek perubahan koordinat lokasi di aplikasi PPDB pukul 08.05</p>
                                    <a href="javascript:;" onclick="update()" id="btn-login" class="btn btn-primary btn-block">Update</a>
                                </div>
                                  <!-- <div class="col-6">
                                    <a href="https://www.google.com/maps?q=<?php echo $record->lintang ?>,<?php echo $record->bujur ?>" target="_BLANK" id="btn-login" class="btn btn-info btn-block">Lihat di peta</a>
                                </div> -->
                               
                            </div>
                            </form>
                        </div>

                    </div>
                    
                </div>
                
            </div>
           
            </div>
        </div>
    </div>

<?php $this->load->view($controller."_js"); ?>

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
