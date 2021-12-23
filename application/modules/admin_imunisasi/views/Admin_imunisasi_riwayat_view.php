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
                        $md2 ="12";
                    } else {
                        $md = "2";
                        $md2 ="10";
                    } ?>
                    
                    <label class="text-danger">Pencarian</label>
                    <form id="form-filter">
                        <div class="row">
                             <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label for="cwebsite">Tahun Vaksin</label>
                                    <?php 
                                    $tahun = isset($tahun)?$tahun:date("Y");
                                    echo form_dropdown("tahun",$this->dm->arr_tahun(),$tahun,'id="tahun_cari"  class="form-control" data-toggle="select2"') 
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
                                    <label for="cwebsite">Desa</label>
                                    <?php 
                                    $desa = isset($desa)?$desa:"";
                                    echo form_dropdown("id_desa",$this->dm->arr_desa(),$desa,'id="id_desa_cari"  class="form-control" data-toggle="select2"') 
                                    ?>
                                     <small id="loading" class="text-danger"></small>
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
    
                          
                            <div class="col-md-<?php echo $md ?>">
                                <div class="form-group">
                                    <label >Nama Bayi</label>
                                    <input class='form-control' name="nama" type="text" id="nama_cari" autocomplete="off">
                                </div>
                            </div> 


                    </div>
                    <div class="row">
                        <div class="col-md-<?php echo $md2 ?>">
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
                               <!--  <th width="2%" class="float-center">
                                    <div class="checkbox checkbox-primary checkbox-single">
                                        <input id="check-all" type="checkbox">
                                        <label></label>
                                    </div>
                                </th> -->
                                <th width="3%" ><strong>No.</strong>    </th>
                                <th width="10%">No. Reg Kia</th>
                                <th width="20%">Nama Bayi</th>
                                <th width="2%">JK</th>
                                <th width="20%">Tempat, Tgl Lahir</th>
                                <th width="10%">Desa</th>
                                <th width="10%">Nama Ibu</th>
                                
                                <?php if ($this->session->userdata("admin_level") == "admin") {?>
                                    <th width="10%">Puskesmas</th>
                                <?php } ?>
                              <th width="10%">Cetak</th>
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
                        <input type="hidden" name="id_imunisasi" id="id_imunisasi">
                        <input type="hidden" name="id_anak" id="id_anak">
                        
                        <div class="col-12" id="btnshow">
                            <div class="row ">
                                <label class="text-primary">Pilih Bayi</label>
                                <div class="input-group  mb-3"> 
                                    <span class="input-group-append">
                                        <button type="button" onclick="show_dialog('id_anak');" class="btn btn-blue btn"><i class="fa fa-search "></i></button>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Cari Nama Bayi" name="nama" id="nama" readonly="">    
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display: none;" id="detail">
                            <div class="col-12">

                                <div class="card-box">
                                <span id="isi_detail"></span>
                                   <h5 class="mb-3 text-uppercase text-white bg-primary p-2"><i class="mdi mdi-account"></i> Data Bayi <span id="namacc"></span></h5>
                                    <div class="row align-items-center">
                                        <div class="col-sm-3">
                                            <div class="media">
                                                <div class="media-body">
                                                   <p class="mb-1"><b>Nama : </b> <span id="namac"></span></p>
                                                    <p class="mb-1"><b>No KIA : </b> <span id="no_kia"></span></p>
                                                    <p class="mb-1"><b>Jenis Kelamin : </b> <span id="jk"></span></p>
                                                    <p class="mb-1"><b>Tempat, Tgl Lahir : </b> <span id="ttl"></span></p>
                                                    <p class="mb-0"><b>Umur Saat ini : </b> <span id="umur"></span></p>
                                                    
                                                    
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
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="text-center mt-3 mt-sm-0">
                                                <a href="javascript:void(0);" onclick="show_dialog('id_anak');" class="action-icon"> <div class="badge font-14 bg-warning text-white p-1"> <i class="mdi mdi-square-edit-outline"></i> Edit</div></a>
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>
                              
                            </div> <!-- end col -->
                        </div>
                          <div class="row">
                              <!--       <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Bulan Imunisasi</label>
                                             <select class="form-control" name="bulan" id="bulan">
                                                <?php
                                                $bln=array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
                                                
                                                for($bulan=1; $bulan<=12; $bulan++){
                                                    if (date("m") == $bulan) {
                                                       $select = "selected";
                                                    } else {
                                                        $select ="";
                                                    }
                                                    echo "<option value='$bulan' $select >$bln[$bulan]</option>"; 
                                                   
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>  -->

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                           <label class="text-primary">Tanggal Penyuntikan</label>
                                           <input class='form-control' data-date-autoclose="true" name="tgl_suntik" type="text" id="tgl_suntik" autocomplete="off">
                                           <small class="text-danger">Mengatur Tanggal Penyuntikan akan mengolah data umur  Bayi saat divaksin berdasarkan tanggal penyuntikan. Umur Vaksin terhitung mulai tanggal lahir sampai tanggal penyuntikan</small>
                                       </div>
                                    </div> <!-- end col -->

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                         <label class="text-primary">Jenis Vaksin</label>
                                         <?php 
                                            $jenis_vaksin = isset($jenis_vaksin)?$jenis_vaksin:"";
                                            echo form_dropdown("jenis_vaksin",$this->dm->arr_vaksin(),$jenis_vaksin,'id="jenis_vaksin" class="form-control" data-toggle="select2"') 
                                            ?>
                                        </div>
                                    </div>
                                      <div class="col-md-4">
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




<div class="modal fade bs-example-modal-lg" id="modal_anak" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-scrollable" role="document">
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
                <a href="<?php echo site_url()."admin_anak" ?>" target ="_BLANK" class="btn btn-primary btn-xs" > Register Bayi </a> 
                   <span class="help-block mt-10 ml-2"><small>Jika pencarian nama tidak ditemukan, Silahkan Register Bayi terlebih dahulu.</small></span>
                        <div id="kotak_pencarian">

                        </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->       



    <?php
    $this->load->view($controller."_riwayat_js");
    ?>
</div>

