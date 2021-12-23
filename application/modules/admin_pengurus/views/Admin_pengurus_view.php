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

                <div class="card-body ">
                 <div class="row">
                    <div class="col-lg-6">
                     <div class="button-list text-left">
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
                </div>
                <div class="col-lg-6">
                    <div class="button-list text-right">
                       <?php $cp = "'#".$subtitle."'"; ?>
                       <span style="display: none;"  id="<?php echo $subtitle ?>"><?php echo  url("","Admin_pengurus", "copy") ?></span> 
                       <a class="btn btn-info btn-rounded waves-effect waves-light" href="javascript:void(0)"  onclick="copy_link(<?php echo $cp ?>)"> <span class="btn-label"><i class="fa fa-copy"></i></span>Copy  Link halaman</a>
                       <a class="btn btn-primary btn-rounded waves-effect waves-light" href="<?php echo url("", "Admin_pengurus") ?>" target="_BLANK"> <span class="btn-label"><i class="fa fa-globe"></i></span>Lihat Hasil di halaman web</a>
                       

                   </div>
               </div>
           </div>

           <hr>
           <table id="datable_1" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width="5%" class="float-center">
                        <div class="checkbox checkbox-primary checkbox-single">
                            <input id="check-all" type="checkbox">
                            <label></label>
                        </div>
                    </th>
                    <th width="5%" ><strong>No.</strong>    </th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th width="3%">JK</th>
                    <th width="15%">TTL</th>
                    <th>Alamat</th>
                    <th>Telepon</th>

                </tr>
            </thead>
        </table>
    </div> <!-- end card body-->
</div> <!-- end card -->
</div><!-- end col-->
</div>
<!-- end row-->



<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="form_app" method="post"  enctype="multipart/form-data" >
                    <input type="hidden" name="id_pengurus" id="id_pengurus">
                    <div class="form-group mb-3">
                        <label class="text-primary">Nama</label>
                        <input class='form-control' name="nama" type="text" id="nama" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">NIP</label>
                        <input class='form-control' name="niapd" type="text" id="niapd" autocomplete="off">
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-primary">Jabatan</label>
                        <?php 
                        $id_jabatan = isset($id_jabatan)?$id_jabatan:"";
                        echo form_dropdown("id_jabatan",$this->dm->arr_jabatan(),$id_jabatan,'id="id_jabatan" class="form-control"') 
                        ?>
                    </div>

                    <div class="form-group mb-3">
                        <label class="text-primary">Jenis Kelamin</label>
                        <select name="jk" id="jk" class="form-control">

                            <option value="L" class="text-danger">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Tempat Lahir</label>
                        <input class='form-control' name="tempat_lahir" type="text" id="tempat_lahir" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Tanggal Lahir</label>
                        <input type="text" class="form-control" data-provide="datepicker" name="tanggal_lahir" id="tanggal_lahir" data-date-autoclose="true" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Pendidikan</label>
                        <?php 
                        $id_pendidikan = isset($id_pendidikan)?$id_pendidikan:"";
                        echo form_dropdown("id_pendidikan",$this->dm->arr_pendidikan(),$id_pendidikan,'id="id_pendidikan" class="form-control"') 
                        ?>
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Alamat</label>
                        <input class='form-control' name="alamat" type="text" id="alamat" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Telepon</label>
                        <input class='form-control' name="telepon" type="text" id="telepon" autocomplete="off">
                        <small>Contoh : 085203954888</small>
                    </div>

                    <div class="card-box">
                        <h4 class="header-title mb-3 text-primary">Foto</h4>
                        <div class="col-sm-6 col-xl-12 filter-item all graphic illustrator">
                            <div class="row">
                                <div class="col">
                                    <h5  id="text_upload">Klik gambar untuk untuk mengganti</h5>
                                </div>
                                <div class="col-auto" id="hapus_gambar"  style="display: none;">
                                    <a href="javascript: void(0);" class="float-right btn btn-light btn-xs waves-effect waves-light" onclick="hapus_gambar_thumb()" ><i class="fa fa-trash text-danger"></i> hapus gambar</a>
                                </div>
                            </div>
                            <div class="gall-info">
                                <div class="image-upload" >
                                    <label for="gambar">
                                        <img  id="previewImage" class="img-fluid img-thumbnail" alt="" style="cursor: pointer;">
                                    </label>
                                    <input type="file" name="gambar" id="gambar" onchange="return previewImage_click()" />
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>



                <div class="modal-footer">

                    <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan </button>
                    
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

