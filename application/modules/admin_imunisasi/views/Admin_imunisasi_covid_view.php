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
                                    <label >NIK</label>
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
                                <th width="5%">NIK</th>
                                <th width="15%">Nama</th>
                                <th width="2%">JK</th>
                                <th width="15%">Tgl Lahir</th>
                                <!-- <th width="2%">JK</th> -->
                                <th width="15%">Alamat</th>
                                <th width="15%">No. Hp</th>
                                <th width="15%">Tgl. Suntik</th>
                               
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
        <div class="modal-dialog modal-full modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                   <form id="form_app" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" name="id_imunisasi_covid" id="id_imunisasi_covid">
                       
                          <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">NIK</label>
                                            <input class='form-control' name="no_kia" type="text" id="no_kia" autocomplete="off">
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Nama</label>
                                            <input class='form-control' name="nama" type="text" id="nama" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Jenis Kelamin</label>
                                             <select class="form-control" name="jk" id="jk">
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group mb-3">
                                           <label class="text-primary">Tanggal Lahir</label>
                                           <input class='form-control' data-date-autoclose="true" name="tgl_lahir" type="text" id="tgl_lahir" autocomplete="off">
                                       </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Alamat</label>
                                            <input class='form-control' name="alamat" type="text" id="alamat" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">No Hp</label>
                                            <input class='form-control' name="no_hp" type="text" id="no_hp" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Pekerjaan</label>
                                            <?php 
                                            $id_pekerjaan = isset($id_pekerjaan)?$id_pekerjaan:"";
                                            echo form_dropdown("id_pekerjaan",$this->km->arr_pek(),$id_pekerjaan,'id="id_pekerjaan" class="form-control" data-toggle="select2"') 
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Detail Pekerjaan</label>
                                            <?php 
                                            $id_detail_pekerjaan = isset($id_detail_pekerjaan)?$id_detail_pekerjaan:"";
                                            echo form_dropdown("id_detail_pekerjaan",$this->km->arr_detail_pekerjaan(),$id_detail_pekerjaan,'id="id_detail_pekerjaan" class="form-control" data-toggle="select2"') 
                                            ?>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Komorbid </label>
                                             <select class="form-control" name="komorbid" id="komorbid">
                                                <option value="2">Tidak Ada</option>
                                                <option value="1">Ada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 komorbid_detail">
                                         <label class="text-danger">Pilih Jenis Komorbid </label>
                                        <div class="form-group mb-3">
                                            <div class="checkbox checkbox-pink form-check-inline">
                                                <input type="checkbox" name="hipertensi" id="Hipertensi" value="1">
                                                <label for="Hipertensi"> Hipertensi </label>
                                            </div>
                                            <div class="checkbox checkbox-pink form-check-inline">
                                                <input type="checkbox" name="diabetes" id="Diabetes" value="1">
                                                <label for="Diabetes"> Diabetes </label>
                                            </div>
                                            <div class="checkbox checkbox-pink form-check-inline">
                                                <input type="checkbox" name="jantung" id="Jantung" value="1">
                                                <label for="Jantung"> Penyakit Jantung </label>
                                            </div>
                                            <div class="checkbox checkbox-pink form-check-inline">
                                                <input type="checkbox" name="ginjal" id="Ginjal" value="1">
                                                <label for="Ginjal"> Penyakit Ginjal </label>
                                            </div>
                                            <div class="checkbox checkbox-pink form-check-inline">
                                                <input type="checkbox" name="paru" id="Paru" value="1">
                                                <label for="Paru"> Penyakit Paru Kronid </label>
                                            </div>
                                            <div class="checkbox checkbox-pink form-check-inline">
                                                <input type="checkbox" name="lainnya" id="Lainnya" value="1">
                                                <label for="Lainnya"> Lainnya </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Kepesertaan BPJS</label>
                                             <select class="form-control" name="bpjs" id="bpjs">
                                                <option value="1">BPJS PBI</option>
                                                <option value="2">BPJS NON PBI</option>
                                                <option value="3">NON ANGGOTA</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Tempat Pemberian Imunisasi</label>
                                             <select class="form-control" name="tempat_imunisasi" id="tempat_imunisasi">
                                                <option value="1">Pusk/Pusk Pembantu</option>
                                                <option value="2">Puskesmas Keliling/Pelayanan Kesehatan Bergerak</option>
                                                <option value="3">FKTP Swasta</option>
                                                <option value="4">RS Pemerintah</option>
                                                <option value="5">RS Swasta</option>
                                            </select>
                                        </div>
                                    </div>

                                      <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Tempat pelayanan</label>
                                            <input class='form-control' name="tempat_pelayanan" type="text" id="tempat_pelayanan">
                                        </div>
                                    </div> <!-- end col -->
                               
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                     <label class="text-primary">Tanggal Penyuntikan</label>
                                     <input class='form-control' data-date-autoclose="true" name="tgl_suntik" type="text" id="tgl_suntik" autocomplete="off">
                                     <small class="text-danger">Mengatur Tanggal Penyuntikan akan mengolah data umur  saat divaksin berdasarkan tanggal penyuntikan. Umur Vaksin terhitung mulai tanggal lahir sampai tanggal penyuntikan</small>
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
    $this->load->view($controller."_covid_js");
    ?>
</div>

