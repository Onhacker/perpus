<link href="<?php echo base_url(); ?>assets/admin/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
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
                    <?php if ($this->session->userdata("admin_level") != "admin") {
                        $md = "3";
                        $md2 ="3";
                    } else {
                        $md = "2";
                        $md2 ="4";
                    } ?>
                    <?php if ($this->session->userdata("admin_level") != "admin") { ?>
                     <div class="button-list">
                        <button type="button" onclick="add()" class="btn btn-success btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                        </button>
                        <button type="button" onclick="edit()" class="btn btn-info btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button>
                        <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                        <button type="button" onclick="cetak()" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-print"></i></span>Cetak Bukti Vaksin
                        </button>
                    </div>
                    
                    <?php } else {?>
                       <div class="button-list">
                            <button type="button" onclick="cetak()" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                <span class="btn-label"><i class="fa fa-print"></i></span>Cetak Bukti Vaksin
                            </button>
                        </div>
                    <?php } ?>
                    <hr>
                    <form id="form-filter">
                        <div class="row">
                             <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">Tahun Vaksin</label>
                                    <?php 
                                    $tahun = isset($tahun)?$tahun:"";
                                    echo form_dropdown("tahun",$this->km->arr_tahun(),$tahun,'id="tahun_cari"  class="form-control" data-toggle="select2"') 
                                    ?>
                                </div>
                            </div>

                             <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">Bulan Vaksin</label>
                                    <?php 
                                    $bulan = isset($bulan)?$bulan:"";
                                    echo form_dropdown("bulan",$this->km->arr_bulan(),$bulan,'id="bulan_cari"  class="form-control" data-toggle="select2"') 
                                    ?>
                                </div>
                            </div>

                            <?php if ($this->session->userdata("admin_level") == "admin") {?>

                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">PKM</label>
                                    <?php 
                                    $id_pkm = isset($id_pkm)?$id_pkm:"";
                                    echo form_dropdown("id_pkm",$this->dm->arr_pkm(),$id_pkm,'id="id_pkm" class="form-control"') 
                                    ?>
                                </div>
                            </div>
                             <?php } ?>
      
                             <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label >No. Imunisasi</label>
                                    <input class='form-control' type="text" id="no_kia_cari" autocomplete="off">
                                </div>
                            </div> 
                            <div class="col-md-<?php echo $md2 ?>">
                                <div class="form-group">
                                    <label >Nama</label>
                                    <input class='form-control' type="text" id="nama_cari" autocomplete="off">
                                </div>
                            </div> 


                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <a href="javascript: void(0);"  id="btn-filter" class="btn btn-blue btn-sm mr-1">
                                    <i class="fa fa-search"></i> Cari
                                </a>
                                <a href="javascript: void(0);" id="btn-reset" class="btn btn-danger btn-sm ">
                                    <i class="fa fa-undo"></i> Reset
                                </a> 
                            </div>
                        </div>
                    </div>
                    </form>
                    
                    <hr>
                    <span id="nama_f"></span>
                    <table id="datable_1" class="table table-striped table-bordered" style="width:100%">
                         <thead>
                            <tr>
                                <th width="2%" class="float-center">
                                    <div class="checkbox checkbox-primary checkbox-single">
                                        <input id="check-all" type="checkbox">
                                        <label></label>
                                    </div>
                                </th>
                                <th width="3%" ><strong>No.</strong>    </th>
                                <th width="5%">No. Imunisasi</th>
                                <th width="10%">Jenis Vaksin</th>
                                <!-- <th width="10%">No. Reg Kia</th> -->
                                <th width="15%">Nama Bayi</th>
                                <th width="2%">JK</th>
                                <th width="15%">Tgl Lahir</th>
                                <th width="15%">Waktu Suntik/ Vaksin Umur</th>
                                <th width="15%">Alamat</th>
                               
                                <?php if ($this->session->userdata("admin_level") == "admin") {?>
                                    <th width="10%">Puskesmas</th>
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
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                   <form id="form_app" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" name="id_imunisasi" id="id_imunisasi">
                       
                          <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Nama Anak</label>
                                            <input class='form-control' name="nama" type="text" id="nama" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Jenis Kelamin</label>
                                             <select class="form-control" name="jk" id="jk">
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-12">
                                        <div class="form-group mb-3">
                                           <label class="text-primary">Tanggal Lahir</label>
                                           <input class='form-control' data-date-autoclose="true" name="tgl_lahir" type="text" id="tgl_lahir" autocomplete="off">
                                       </div>
                                    </div> 
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Alamat Lengkap (Desa/Dusun/RT/RW/Kelurahan)</label>
                                            <input class='form-control' name="alamat" type="text" id="alamat" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Nama Ibu/Ayah</label>
                                            <input class='form-control' name="nama_ibu" type="text" id="nama_ibu" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-primary" >Jenis Vaksin</label>
                                            <?php 
                                            $jenis_vaksin = isset($jenis_vaksin)?$jenis_vaksin:"";
                                            echo form_dropdown("jenis_vaksin",$this->dm->arr_vaksin_form(),$jenis_vaksin,'id="jenis_vaksin_form" class="form-control" data-toggle="select2"') 
                                            ?>

                                        </div>
                                    </div>    
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                           <label class="text-primary">Tanggal Penyuntikan</label>
                                           <input class='form-control' data-date-autoclose="true" name="tgl_suntik" type="text" id="tgl_suntik" autocomplete="off">
                                           <small class="text-danger">Mengatur Tanggal Penyuntikan akan mengolah data umur  saat divaksin berdasarkan tanggal penyuntikan. Umur Vaksin terhitung mulai tanggal lahir sampai tanggal penyuntikan</small>
                                       </div>
                                   </div> <!-- end col --> 

                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Pemberi Imunisasi</label>
                                            <input class='form-control' name="pemberi_imunisasi" type="text" id="pemberi_imunisasi">
                                        </div>
                                    </div> <!-- end col -->

                                   <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Tempat pelayanan</label>
                                            <input class='form-control' name="tempat_pelayanan" type="text" id="tempat_pelayanan">
                                        </div>
                                    </div> <!-- end col -->
                               

                       
                              </div> <!-- end row -->
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
                    <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    <?php
    $this->load->view($controller."_luar_js");
    ?>
</div>

