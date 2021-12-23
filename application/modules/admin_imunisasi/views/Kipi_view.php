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
                        $md = "2";
                        $md2 ="4";
                    } else {
                        $md = "2";
                        $md2 ="2";
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
                            <span class="btn-label"><i class="fa fa-print"></i></span>Cetak Bukti Pelaporan
                        </button>
                    </div>
                    
                    <?php } else {?>
                       <div class="button-list">
                            <button type="button" onclick="cetak()" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                <span class="btn-label"><i class="fa fa-print"></i></span>Cetak Bukti Pelaporan
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
                                    echo form_dropdown("tahun",$this->dm->arr_tahun(),$tahun,'id="tahun_cari"  class="form-control" data-toggle="select2"') 
                                    ?>
                                </div>
                            </div>

                             <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">Bulan Vaksin</label>
                                    <?php 
                                    $bulan = isset($bulan)?$bulan:"";
                                    echo form_dropdown("bulan",$this->dm->arr_bulan(),$bulan,'id="bulan_cari"  class="form-control" data-toggle="select2"') 
                                    ?>
                                </div>
                            </div>

                            <?php if ($this->session->userdata("admin_level") == "admin") {?>

                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">PKM</label>
                                    <?php 
                                    $id_pkm = isset($id_pkm)?$id_pkm:"";
                                    echo form_dropdown("id_pkm",$this->dm->arr_pkm(),$id_pkm,'id="id_pkm" onchange="get_desa(this,\'#id_desa_cari\',1)" class="form-control"') 
                                    ?>
                                </div>
                            </div>
                             <?php } ?>

                             <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">Wilayah</label>
                                    <select class="form-control"  id="wilayah_cari">
                                        <option value="">Semua Wilayah</option>
                                        <option value="1">Dalam Wilayah</option>
                                        <option value="2">Luar Wilayah</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label >Jenis Kelamin</label>
                                    <select class="form-control" name="jk" id="jk_cari">
                                        <option value="">Semua Jenis Kelamin</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>

                                </div>
                            </div> 
    
                          
                            <div class="col-md-<?php echo $md2 ?>">
                                <div class="form-group">
                                    <label >Nama Anak</label>
                                    <input class='form-control' name="nama" type="text" id="nama_cari" autocomplete="off">
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
                                <th><strong>No.</strong>    </th>
                                <th >Nama/Nama Ortu</th>
                                <th >JK</th>
                                <th >Tempat, Tgl Lahir</th>
                                <th >Waktu Suntik/ Vaksin Umur</th>
                                <th >Jenis, No Batch/<br>Exp Date Vaksin 1</th>
                                <th >Jenis, No Batch/<br>Exp Date Vaksin 2</th>
                                <th >Gejala</th>
                                
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
                        <input type="hidden" name="urutan" id="urutan">
                        <input type="hidden" name="id_kipi" id="id_kipi">
                        <input type="hidden" name="id_anak" id="id_anak">
                        <input type="hidden" name="tgl_suntik" id="tgl_suntik">

                        <div class="form-group mb-3">
                            <label class="text-primary">Wilayah Anak </label>
                            <select class="form-control" name="wilayah" id="wilayah">
                                <option value="1">Dalam Wilayah</option>
                                <option value="2">Luar Wilayah</option>

                            </select>
                        </div>
                        <div class="wilayah_detail">
                            <div class="col-12" id="btnshow">
                                <div class="row ">
                                    <label class="text-primary">Pilih Anak</label>
                                    <div class="input-group  mb-3"> 
                                        <span class="input-group-append">
                                            <button type="button" onclick="show_dialog('id_anak');" class="btn btn-blue btn"><i class="fa fa-search "></i></button>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Cari Nama Anak"  id="nama" readonly="">    
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none;" id="detail">
                                <div class="col-12">

                                    <div class="card-box">
                                        <span id="isi_detail"></span>
                                        <h5 class="mb-3 text-uppercase text-white bg-primary p-2"><i class="mdi mdi-account"></i> Data Anak <span id="namacc"></span></h5>
                                        <div class="row align-items-center">
                                            <div class="col-sm-3">
                                                <div class="media">
                                                    <div class="media-body">
                                                    <p class="mb-1"><b><code>Tgl Suntik :</code> </b> <span id="tgl_suntik_det"></span></p>
                                                    <p class="mb-1"><b><code>Jenis Vaksin 1 :</code> </b> <span id="jenis_vaksin_1_det"></span></p>
                                                    <p class="mb-1"><b><code>Jenis Vaksin 2 :</code> </b> <span id="jenis_vaksin_2_det"></span></p>
                                                    <p class="mb-1"><b><code>Pemberi Imunisasi :</code> </b> <span id="pemberi_imunisasi_det"></span></p>
                                                    <p class="mb-0"><b><code>Tempat Pelayanan :</code> </b> <span id="tempat_pelayanan_det"></span></p>


                                                 </div>
                                             </div>
                                         </div>
                                        <div class="col-sm-3">
                                                <div class="media">
                                                    <div class="media-body">
                                                     <p class="mb-1 mt-3 mt-sm-0"><b>Nama : </b> <span id="namac"></span></p>
                                                     <p class="mb-1 mt-3 mt-sm-0"><b>No KIA : </b> <span id="no_kia"></span></p>
                                                     <p class="mb-1 mt-3 mt-sm-0"><b>Jenis Kelamin : </b> <span id="jk"></span></p>
                                                     <p class="mb-1 mt-3 mt-sm-0"><b>Tempat, Tgl Lahir : </b> <span id="ttl"></span></p>
                                                     <p class="mb-0 mt-3 mt-sm-0"><b>Umur Saat ini : </b> <span id="umur"></span></p>


                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-sm-3">
                                            <p class="mb-1 mt-3 mt-sm-0"><b>Golongan Darah : </b> <span id="golda"></span></p>
                                            <p class="mb-1 mt-3 mt-sm-0"><b>Alamat : </b> <span id="alamat"></span></p>
                                            <p class="mb-1 mt-3 mt-sm-0"><b>Desa : </b> <span id="desa"></span></p>
                                            <p class="mb-1 mt-3 mt-sm-0"><b>Agama : </b> <span id="agama"></span></p>
                                            <p class="mb-1 mt-3 mt-sm-0"><b>NIK Ayah : </b> <span id="nik_ayah"></span></p>
                                            
                                            

                                        </div>
                                        <div class="col-sm-3">
                                            <p class="mb-0 mt-3 mt-sm-0"><b>Nama Ayah : </b> <span id="nama_ayah"></span></p>
                                            <p class="mb-1 mt-3 mt-sm-0"><b>Pekerjaan Ayah : </b> <span id="pekerjaan_ayah"></span></p>
                                            <p class="mb-1 mt-3 mt-sm-0"><b>NIK IBU : </b> <span id="nik_ibu"></span></p>
                                            <p class="mb-1 mt-3 mt-sm-0"><b>Nama IBU : </b> <span id="nama_ibu"></span></p>
                                            <p class="mb-0 mt-3 mt-sm-0"><b>Pekerjaan Ibu : </b> <span id="pekerjaan_ibu"></span></p>
                                        <!-- </div> -->
                                        <!-- <div class="col-sm-1"> -->
                                            <div class="text-center mt-3 mt-sm-0">
                                                <a href="javascript:void(0);" onclick="show_dialog('id_anak');" class="action-icon"> <div class="badge font-14 bg-danger text-white p-1"> <i class="mdi mdi-square-edit-outline"></i> Ganti</div></a>
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>

                            </div> <!-- end col -->
                        </div>
                    </div>

                    <div class="luar_wilayah_detail">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="text-primary">Nama</label>
                                    <input class='form-control' name="nama_l" type="text" id="nama_l">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="text-primary">Jenis Kelamin</label>
                                    <select class="form-control" name="jk_l" id="jk_l">
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="text-primary">Tempat Lahir</label>
                                    <input class='form-control' name="tempat_lahir_l" type="text" id="tempat_lahir_l" autocomplete="off">
                                </div>
                            </div> <!-- end col -->

                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                   <label class="text-primary">Tanggal Lahir</label>
                                   <input class='form-control' data-date-autoclose="true" name="tgl_lahir_l" type="text" id="tgl_lahir_l" autocomplete="off">
                               </div>
                            </div> 
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="text-primary">NIK IBU</label>
                                    <input class='form-control' name="nik_ibu_l" type="text" id="nik_ibu_l" autocomplete="off">
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="text-primary">Nama  IBU</label>
                                    <input class='form-control' name="nama_ibu_l" type="text" id="nama_ibu_l" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="text-primary">Alamat Lengkap</label>
                                    <input class='form-control' name="alamat_l" type="text" id="alamat_l" autocomplete="off">
                                    <small>Contoh : Jalan Kedamaian Selatan No. 140 B</small>
                                </div>
                            </div>

                                
                          <div class="col-md-3">
                              <div class="form-group mb-3">
                                 <label class="text-primary">Tanggal Penyuntikan</label>
                                 <input class='form-control' data-date-autoclose="true" name="tgl_suntik_l" type="text" id="tgl_suntik_l" autocomplete="off">
                              
                             </div>
                          </div>
                   <div class="col-md-3">
                      <div class="form-group mb-3">
                          <label class="text-primary">Pemberi Imunisasi</label>
                          <input class='form-control' name="pemberi_imunisasi_l" type="text" id="pemberi_imunisasi_l">
                      </div>
                  </div> <!-- end col -->
                  
                    <div class="col-md-3">
                      <div class="form-group mb-3">
                          <label class="text-primary">Tempat pelayanan</label>
                          <input class='form-control' name="tempat_pelayanan_l" type="text" id="tempat_pelayanan_l">
                      </div>
                  </div> <!-- end col -->


                        </div>

                    </div>



                <div class="row">
                    <div class="col-md-3 luar_wilayah_detail">
                        <div class="form-group mb-3">
                            <label class="text-primary">Jenis Vaksin 1</label>
                            <?php 
                            $jenis_vaksin_1 = isset($jenis_vaksin_1)?$jenis_vaksin_1:"";
                            echo form_dropdown("jenis_vaksin_1",$this->dm->arr_vaksin(),$jenis_vaksin_1,'id="jenis_vaksin_1" class="form-control" data-toggle="select2"') 
                            ?>
                        </div>
                    </div>
                   <div class="col-md-3">
                      <div class="form-group mb-3">
                          <label class="text-primary">No Batch / Exp Date Vaksin 1</label>
                          <input class='form-control' name="no_vaksin_1" type="text" id="no_vaksin_1">
                      </div>
                  </div>
                  <div class="col-md-3 luar_wilayah_detail">
                    <div class="form-group mb-3">
                        <label class="text-primary">Jenis Vaksin 2</label>
                        <?php 
                        $jenis_vaksin_2 = isset($jenis_vaksin_2)?$jenis_vaksin_2:"";
                        echo form_dropdown("jenis_vaksin_2",$this->dm->arr_vaksin(),$jenis_vaksin_2,'id="jenis_vaksin_2" class="form-control" data-toggle="select2"') 
                        ?>
                    </div>
                </div>
                  <div class="col-md-3">
                      <div class="form-group mb-3">
                          <label class="text-primary">No Batch / Exp Date Vaksin 2</label>
                          <input class='form-control' name="no_vaksin_2" type="text" id="no_vaksin_2">
                      </div>
                  </div>
                  <div class="col-md-12">
                        <label class="text-danger">GEJALA YANG DIALAMI</label>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label class="text-primary">Demam</label>
                        <select class="form-control" name="demam" id="demam">
                            
                            <option value="N">Tidak</option>
                            <option value="Y">Ya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label class="text-primary">Bengkak</label>
                        <select class="form-control" name="bengkak" id="bengkak">
                            
                            <option value="N">Tidak</option>
                            <option value="Y">Ya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label class="text-primary">Merah</label>
                        <select class="form-control" name="merah" id="merah">
                            
                            <option value="N">Tidak</option>
                            <option value="Y">Ya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label class="text-primary">Muntah</label>
                        <select class="form-control" name="muntah" id="muntah">
                            
                            <option value="N">Tidak</option>
                            <option value="Y">Ya</option>
                        </select>
                    </div>
                </div>

                 <div class="col-md-4">
                      <div class="form-group mb-3">
                          <label class="text-primary">Gejala Lainnya. Sebutkan</label>
                          <input class='form-control' name="lainnya" type="text" id="lainnya">
                      </div>
                  </div>

                  
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




<div class="modal fade bs-example-modal-lg" id="modal_anak" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full modal-dialog-scrollable" role="document">
        <div class="modal-content" style="background-color: #E4F3FD">
            <div class="modal-header">
                <h5 class="modal-title-cari mt-0" id="myLargeModalLabel">Large modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
             
                  <div class="form-group row">
                   <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="hidden" name="target" id="target" />
                        <input class="form-control" type="text" name="search_nama_table"  id="search_nama_table" autocomplete="off" >
                        <!-- <small>Cari nama dengan cara hanya mengetikkan sebagian</small> -->
                      </div>
                </div>
               
                <div class="modal-footer">
                   <a href="javascript:search_cari();" class="btn btn-primary" > Cari </a>  
                   <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
               </div> 

               <div id="kotak_pencarian">

               </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->       

    <?php
    $this->load->view("Kipi_js");
    ?>
</div>

