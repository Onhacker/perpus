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
                            <span class="btn-label"><i class="fa fa-print"></i></span>Cetak Kartu Imunisasi
                        </button>
                    </div>
                    
                    <?php } else {?>
                       <div class="button-list">
                            <button type="button" onclick="cetak()" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                <span class="btn-label"><i class="fa fa-print"></i></span>Cetak Kartu Imunisasi
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
                                    <label >No. registrasi KIA</label>
                                    <input class='form-control' name="no_kia" type="text" id="no_kia_cari" autocomplete="off">

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
                                <th width="3%" ><strong>No.</strong>    </th>
                                <th >Tgl Reg</th>
                                <th >No. Reg Kia</th>
                                <th >Nama Anak</th>
                                <th >JK</th>
                                <th >Tempat, Tgl Lahir</th>
                                <th >Desa</th>
                                <th >Nama Ibu</th>

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
                        <input type="hidden" name="id_anak" id="id_anak">
                        <h5 class="mb-3 text-uppercase text-white bg-primary p-2"><i class="mdi mdi-account"></i> Data Anak</h5>

                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">No Registrasi KIA</label>
                                            <input class='form-control' name="no_kia" type="text" id="no_kia" autocomplete="off">
                                        </div>
                                    </div> <!-- end col -->
                                    
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                         <label class="text-primary">Nama</label>
                                         <input class='form-control' name="nama" type="text" id="nama" autocomplete="off">
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Jenis Kelamin</label>
                                             <select class="form-control" name="jk" id="jk">
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div> <!-- end col -->
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Tempat Lahir</label>
                                            <input class='form-control' name="tempat_lahir" type="text" id="tempat_lahir" autocomplete="off">
                                        </div>
                                    </div> <!-- end col -->
                                    
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                           <label class="text-primary">Tanggal Lahir</label>
                                           <input class='form-control' data-date-autoclose="true" name="tgl_lahir" type="text" id="tgl_lahir" autocomplete="off">
                                       </div>
                                   </div> <!-- end col -->
                                   <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="text-primary">Gologan Darah</label>
                                        <select class="form-control" name="golda" id="golda">
                                            <option value="-">== Pilih Golongan Darah ==</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div> <!-- end col -->
                    </div>

                     <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Agama</label>
                                            <?php 
                                            $id_agama = isset($id_agama)?$id_agama:"";
                                            echo form_dropdown("id_agama",$this->dm->arr_agama(),$id_agama,'id="id_agama" class="form-control" data-toggle="select2"') 
                                            ?>
                                        </div>
                                    </div> <!-- end col -->
                                    
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                           <label class="text-primary">Desa</label>
                                           <?php 
                                           $desa = isset($desa)?$desa:"";
                                           echo form_dropdown("id_desa",$this->dm->arr_desa(),$desa,'id="id_desa"  class="form-control" data-toggle="select2"') 
                                           ?>
                                       </div>
                                   </div> <!-- end col -->
                                   <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="text-primary">Alamat Lengkap</label>
                                        <input class='form-control' name="alamat" type="text" id="alamat" autocomplete="off">
                                        <small>Contoh : Jalan Kedamaian Selatan No. 140 B</small>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div> <!-- end col -->
                    </div>
                    <h5 class="mb-3 text-uppercase text-white bg-success p-2"><i class="mdi mdi-account"></i> Data Orang Tua Anak</h5>
                     <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">NIK Ayah</label>
                                            <input class='form-control' name="nik_ayah" type="text" id="nik_ayah" autocomplete="off">
                                        </div>
                                    </div> <!-- end col -->
                                    
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                          <label class="text-primary">Nama Ayah</label>
                                          <input class='form-control' name="nama_ayah" type="text" id="nama_ayah" autocomplete="off">
                                       </div>
                                   </div> <!-- end col -->
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Pekerjaan Ayah</label>
                                            <?php 
                                            $id_pekerjaan_ayah = isset($id_pekerjaan_ayah)?$id_pekerjaan_ayah:"";
                                            echo form_dropdown("id_pekerjaan_ayah",$this->dm->arr_pekerjaan(),$id_pekerjaan_ayah,'id="id_pekerjaan_ayah" class="form-control" data-toggle="select2"') 
                                            ?>
                                        </div>
                                    </div> <!-- end col -->
                                   <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">NIK IBU</label>
                                            <input class='form-control' name="nik_ibu" type="text" id="nik_ibu" autocomplete="off">
                                        </div>
                                    </div> <!-- end col -->
                                     <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Nama IBU</label>
                                            <input class='form-control' name="nama_ibu" type="text" id="nama_ibu" autocomplete="off">
                                        </div>
                                    </div> <!-- end col -->
                                      <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label class="text-primary">Pekerjaan Ibu</label>
                                            <?php 
                                            $id_pekerjaan_ibu = isset($id_pekerjaan_ibu)?$id_pekerjaan_ibu:"";
                                            echo form_dropdown("id_pekerjaan_ibu",$this->dm->arr_pekerjaan(),$id_pekerjaan_ibu,'id="id_pekerjaan_ibu" class="form-control" data-toggle="select2"') 
                                            ?>
                                        </div>
                                    </div>
                            </div> <!-- end row -->
                        </div> <!-- end col -->
                    </div>

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
    $this->load->view($controller."_js");
    ?>
</div>

