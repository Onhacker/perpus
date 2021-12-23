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
    <?php if ($this->session->userdata("admin_level") != "admin") {
        $md = "12";
    } else {
        $md = "12";
    } ?>
    
    

    <?php  if ($fe->num_rows() == 0) { ?> 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-danger"><?php echo $cek ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php } else { ?>

  

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                      
                    
                     <?php if ($this->session->userdata("admin_level") != "admin") { ?>
                     <div class="button-list">
                        <button type="button" onclick="add()" class="btn btn-success btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                        </button>
                     <!--    <button type="button" onclick="edit()" class="btn btn-info btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button> -->
                        <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                    </div>
                    <hr>
                    <?php } ?>
                    <form id="form-filter">
                        <div class="row">
                       

                        <div class="col-md-<?php echo $md ?>">
                            <div class="form-group">
                                <label for="cwebsite">Tahun </label>
                                <?php 
                                $tahun = isset($tahun)?$tahun:"";
                                echo form_dropdown("tahun",$this->dm->arr_tahun_manual(),$tahun,'id="tahun_select" class="form-control" data-toggle="select2"') 
                                ?>
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
                    <table id="datable_1" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                
                                <?php if ($this->session->userdata("admin_level") != "admin") { ?>
                                    <th width="5%" class="float-center">
                                        <div class="checkbox checkbox-primary checkbox-single">
                                            <input id="check-all" type="checkbox">
                                            <label></label>
                                        </div>
                                    </th>
                                <?php } ?>

                                <th width="5%" ><strong>No.</strong>    </th>

                                <?php if($this->session->userdata("admin_level") == "admin"){?>
                                    <th>Puskesmas</th>
                                <?php } ?>    
                                <th>Tahun Imunisasi</th>
                                <th>Tgl Dibuat</th>
                                <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                                    <th>Cetak BIAS PKM</th>
                                <?php } else {?>
                                    <th>Kelola/Cetak</th>
                                <?php } ?>
             
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    <style type="text/css">
        .dropdown-menu-right{ z-index:99999 !important; }
    </style>


    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodal-title" id="full-width-modalLabel">xx</h4>
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    
                    <form id="form_app" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" name="id_admin_bias" id="id_admin_bias">
                        <?php 
                        $tahun = isset($record->tahun)?$record->tahun:"";
                        echo form_dropdown("tahun",$this->dm->arr_tahun_manual(),$tahun,'id="tahun" class="form-control"') ;
                        ?>
                        <!-- <label class="text-primary">Buat Tahun Vaksin <?php echo $this->om->web_me()->tahun_akhir ?> untuk melanjutkan mengelola Jumlah penduduk di tahun <?php echo $this->om->web_me()->tahun_akhir ?>. Membuat tahun vaksin hanya dilakukan setiap tahun berganti. </label> -->

                       
                </div>

                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
                        <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Buat</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <?php
    $this->load->view("backend/global_css");
    $this->load->view($controller."_js");
    ?>
    <?php } ?>
  
</div>
