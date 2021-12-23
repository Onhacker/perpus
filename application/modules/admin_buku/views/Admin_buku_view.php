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
                            <th width="2%" class="float-center">
                                <div class="checkbox checkbox-primary checkbox-single">
                                    <input id="check-all" type="checkbox">
                                    <label></label>
                                </div>
                            </th>
                            <th width="2%" ><strong>No.</strong>    </th>
                            
                            <!-- <th>Kode Buku</th> -->
                            <th width="10%">Judul Buku</th>
                            <th width="10%%">Pengarang</th>
                            <th width="10%">Penerbit</th>
                            <th width="4%">Tahun Terbit</th>
                            <th width="10%">Jumlah Unit</th> 
                            <th width="30%">Deskripsi</th>              
                            <th width="15%">Kode</th>              
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
                    <input type="hidden" name="id_buku" id="id_buku">
                    <div class="form-group mb-3">
                        <label class="text-primary">Kode Buku</label>
                        <input class='form-control kode_buku' name="kode_buku" type="text" id="kode_buku"   autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Judul Buku</label>
                        <input class='form-control' name="judul_buku" type="text" id="judul_buku" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Nama Pengarang</label>
                        <input class='form-control' name="nama_pengarang" type="text" id="nama_pengarang" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Nama Penerbit</label>
                        <input class='form-control' name="nama_penerbit" type="text" id="nama_penerbit" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Tahun Terbit</label>
                        <input class='form-control' name="tahun_terbit" type="number" id="tahun_terbit" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Jumlah Unit</label>
                        <input class='form-control' name="jumlah_unit" type="number" id="jumlah_unit" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Deskripsi Buku</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"></textarea>
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
    <div class="modal-dialog  modal-dialog-scrollable" role="document">
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


<?php
$this->load->view("backend/global_css");
$this->load->view($controller."_js");
?>

</div>
