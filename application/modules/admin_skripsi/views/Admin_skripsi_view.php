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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <div class="button-list">
                        <button type="button" onclick="add()" class="btn btn-success btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                        </button>
                        <button type="button" onclick="edit()" class="btn btn-info btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button>
                        <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                    </div>
                    <hr>
                    <table id="datable_1" class="table table-striped table-bordered table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="float-center">
                                    <div class="checkbox checkbox-primary checkbox-single">
                                        <input id="check-all" type="checkbox">
                                        <label></label>
                                    </div>
                                </th>
                                <th width="5%" ><strong>No.</strong>    </th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Tahun</th>
                                <th>Tgl. Diterima</th>
                                <th>File</th>
                                          
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
                        <input type="hidden" name="id_skripsi" id="id_skripsi">
                        <div class="form-group mb-3">
                            <label class="text-primary">Judul</label>
                            <input class='form-control' name="judul" type="text" id="judul" autocomplete="off">
                        </div>
                         <div class="form-group mb-3">
                            <label class="text-primary">Pengarang</label>
                            <input class='form-control' name="pengarang" type="text" id="pengarang" autocomplete="off">
                        </div>
                         <div class="form-group mb-3">
                            <label class="text-primary">Tahun Penelitian</label>
                            <input class='form-control' name="tahun" type="number" id="tahun" autocomplete="off">
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Tanggal Diterima</label>
                            <input class='form-control'  data-date-autoclose="true"  type="text" id="tgl_diterima" name = "tgl_diterima" autocomplete="off" readonly="">
                        </div>

                         <div class="form-group mb-3">
                            <label class="text-primary" id="edit_text">File : </label>
                            <input type="file" name="file" id="gambar"  />
                        </div>
                        
                        <div class="row" id="pre">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-box">
                                            <div class="col-sm-12 col-xl-12 filter-item all graphic illustrator">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5  id="text_upload" class="text-info">File Saat ini</h5>
                                                        <h5 id="nama_file"></h5>
                                                    </div>
                                                    <div class="col-auto" id="hapus_gambar"  style="display: none;">
                                                        <a href="javascript: void(0);" class="float-right btn btn-light btn-xs waves-effect waves-light" onclick="hapus_gambar_thumb()" ><i class="fa fa-trash text-danger"></i> hapus file</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

<div id="full-width-modal-des" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                <button type="button" class="close" onclick="close_modal_des()" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p style="text-align: justify;"><span id="deskripsix"></span></p>
                
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal_des()">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
     $(document).ready(function(){
        $('#tgl_diterima').datepicker({
            format: 'dd-mm-yyyy',

        });

    })
</script>
    <?php
    $this->load->view("backend/global_css");
    $this->load->view($controller."_js");
    ?>
  
</div>
