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
                    <?php if ($this->session->userdata("admin_level") != "admin") { ?>
                        <p class="text-info">INFO !!! Silahkan buat data sekolah dalam wilayah imunisasi <span class="text-primary"><?php echo $title ?></span> terlebih dahulu sebelum melanjutkan pembuatan data BIAS</p>
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
                    </div>
                    
                    

                    <hr>
                    <form id="form-filter">
                        <div class="row">
                             <div class="col-md-8">
                            </div> 
                            <div class="col-md-4">
                                <div class="row">
                                <div class="input-group m-t-10">
                                    <input type="text" id="sekolah_cari"  class="form-control" autocomplete="off" placeholder="Cari Sekolah">
                                    <span class="input-group-append">
                                        <button type="button" id="btn-filter" class="btn waves-effectwaves-light btn-blue">Cari</button>
                                        <button type="button" id="btn-reset"  class="btn waves-effect mr-3 waves-light btn-danger">Reset</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr>
                    <?php } else {?>
                        <form id="form-filter">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cwebsite">PKM</label>
                                        <?php 
                                        $id_pkm = isset($id_pkm)?$id_pkm:"";
                                        echo form_dropdown("id_pkm",$this->dm->arr_pkm(),$id_pkm,'id="id_pkm" onchange="get_desa(this,\'#id_desa_cari\',1)" class="form-control"') 
                                        ?>
                                    </div>
                                </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cwebsite">Desa</label>
                                    <?php 
                                    $desa = isset($desa)?$desa:"";
                                    echo form_dropdown("id_desa",$this->dm->arr_desa(),$desa,'id="id_desa_cari"  class="form-control" data-toggle="select2"') 
                                    ?>
                                    <small id="loading" class="text-danger"></small>
                                </div>
                            </div>
                      
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Nama Sekolah</label>
                                    <input class='form-control' type="text" id="sekolah_cari" autocomplete="off">
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
                    <?php } ?>


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
                                <th width="20%">Sekolah</th>
                                <th width="20%">Desa</th>
                                <th width="20%">Kecamatan</th>
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
                        <input type="hidden" name="id_sekolah" id="id_sekolah">
                        <div class="form-group mb-3">
                            <label class="text-primary">Nama Sekolah</label>
                            <input class='form-control' name="sekolah" type="text" id="sekolah" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary"><?php echo $this->om->engine_nama_menu("Admin_desa") ?></label>
                            <?php 
                            $id_desa = isset($id_desa)?$id_desa:"";
                            echo form_dropdown("id_desa",$this->dm->arr_desa(),$id_desa,'id="id_desa" class="form-control" data-toggle="select2"') 
                            ?>
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
