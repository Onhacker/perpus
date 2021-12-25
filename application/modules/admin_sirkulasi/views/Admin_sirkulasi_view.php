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
                     <button type="button" onclick="kembali()" class="btn btn-primary btn-rounded waves-effect waves-light">
                        <span class="btn-label"><i class="fa fa-check"></i></span>Dikembalikan
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
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Judul Buku</th>
                            <th width="15%">Kode Buku</th> 
                            <th>Masa Pinjam</th>
                            
                            <th>Status</th>              
                            <th>Kirim Notif</th>              
                        </tr>
                    </thead>
                </table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end row-->



<div id="full-width-modal" class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="form_app" method="post"  enctype="multipart/form-data" >
                    <input type="hidden" name="id_sirkulasi" id="id_sirkulasi">
                    <input type="hidden" name="id_buku" id="id_buku">

                    <div class="col-12" id="btnshow">
                        <div class="row ">
                            <label class="text-primary">Cari Buku</label>
                            <div class="input-group  mb-3"> 
                                <span class="input-group-append">
                                    <button type="button" onclick="show_dialog('id_buku');" class="btn btn-blue btn"><i class="fa fa-search "></i></button>
                                </span>
                                <input type="text" class="form-control kode_sirkulasi" placeholder="Cari Buku" name="kode_buku" id="kode_buku" readonly="" >    
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: none;" id="detail">
                        <div class="col-12">

                            <div class="card-box">
                                <span id="isi_detail"></span>
                                <h5 class="mb-3 text-uppercase text-white bg-blue p-2"><i class="mdi mdi-book"></i> Data Buku <span id="judul_buku"></span></h5>
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="media">
                                            <div class="media-body">

                                                <p class="mb-1"><b>Judul Buku : </b> <span id="judul_bukuc"></span></p>
                                                <p class="mb-1"><b>Nama Pengarang : </b> <span id="nama_pengarang"></span></p>
                                                <p class="mb-1"><b>Nama Penerbit : </b> <span id="nama_penerbit"></span></p>
                                                <p class="mb-0"><b>Tahun Terbit : </b> <span id="tahun_terbit"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        <p class="mb-1"><b>Kode Buku : </b> <span id="kode_bukuc"></span></p>
                                        <div class="text-center mt-3 mt-sm-0">

                                            <a href="javascript:void(0);" onclick="show_dialog('id_buku');" class="action-icon"> <div class="badge font-14 bg-info text-white p-1"> <i class="mdi mdi-square-edit-outline"></i> Cari Ulang</div></a>
                                        </div>
                                    </div>
                                </div> <!-- end row -->
                            </div>

                        </div> <!-- end col -->
                    </div>
                    <?php 
                    $tgl1 = date("d-m-Y H:i:s");// pendefinisian tanggal awal
                    $tgl2 = date('d-m-Y H:i:s', strtotime('+7 days', strtotime($tgl1))); //operasi penjumlahan tanggal sebanyak 
                    ?>


                    <div class="col-12" id="btnshownim">
                        <!-- <input type="text" name="nim" id="nim"> -->
                        <div class="row ">
                            <label class="text-primary">Cari Mahasiswa</label>
                            <div class="input-group  mb-3"> 
                                <span class="input-group-append">
                                    <button type="button" onclick="show_dialog_nim('nim');" class="btn btn-primary btn"><i class="fa fa-search "></i></button>
                                </span>
                                <input type="text" class="form-control nim" placeholder="Cari Mahasiswa" name="nim" id="nim" readonly="" >    
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display: none;" id="detail_nim">
                        <div class="col-12">

                            <div class="card-box">
                                <span id="isi_detail_nim"></span>
                                <h5 class="mb-3 text-uppercase text-white bg-primary p-2"><i class="mdi mdi-book"></i> Identitas <span id="nama_lengkapx"></span></h5>
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="media">
                                            <div class="media-body">

                                                <p class="mb-1"><b>NIM : </b> <span id="nimx"></span></p>
                                                <p class="mb-1"><b>Nama Lengkap : </b> <span id="nama_lengkap"></span></p>
                                                <p class="mb-1"><b>No. Hp : </b> <span id="no_telp"></span></p>
                                                <p class="mb-1"><b>Email : </b> <span id="email"></span></p>
                                                <p class="mb-1"><b>Fakultas : </b> <span id="nama_fakultas"></span></p>
                                                <p class="mb-1"><b>Jurusan : </b> <span id="nama_jurusan"></span></p>
                                                <p class="mb-1"><b>Program Study : </b> <span id="nama_prodi"></span></p>
                                                <p class="mb-1"><b>Angkata : </b> <span id="angkatan"></span></p>



                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-4">

                                        <div class="text-center mt-3 mt-sm-0">

                                            <a href="javascript:void(0);" onclick="show_dialog_nim('nim');" class="action-icon"> <div class="badge font-14 bg-info text-white p-1"> <i class="mdi mdi-square-edit-outline"></i> Cari Ulang</div></a>
                                        </div>
                                    </div>
                                </div> <!-- end row -->
                            </div>
                            <div class="form-group range_awal">
                                <label for="cwebsite" class="text-primary" id="lab">Range Peminjaman</label>
                                <input class='form-control' value="<?php echo date("d-m-Y H:i:s")." sampai ".$tgl2 ?>"  type="text" name="waktu_awal" id="range_awal"  autocomplete="off" readonly>
                                <small>Pilih tanggal peminjaman sampai dengan tanggal pengembalian</small>
                            </div>
                        </div> <!-- end col -->
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


<div class="modal fade bs-example-modal-lg" id="modal_buku" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-scrollable" role="document">
        <div class="modal-content" style="background-color: #E4F3FD">
            <div class="modal-header">
             <h4 class="modal-title-cari mt-0" id="full-width-modalLabel">Modal Heading</h4>
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         </div>
         <div class="modal-body">
            <div class="form-group">
                <label for="cwebsite" class="text-primary" id="lab">Cari Buku</label>
                <input type="hidden" name="target" id="target" />
                <input class="form-control search_nama_table" type="text" name="search_nama_table"  id="search_nama_table" autocomplete="off" >
                <small>Masukkan Judul atau Kode Buku atau nama pengarang atau nama penerbit/ Scan Barcode Buku</small>
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




<div class="modal fade bs-example-modal-lg" id="modal_nim" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full  modal-dialog-scrollable" role="document">
        <div class="modal-content" style="background-color: #E4F3FD">
            <div class="modal-header">
             <h4 class="modal-title-cari-nim mt-0" id="full-width-modalLabel">Modal Heading</h4>
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         </div>
         <div class="modal-body">
            <div class="form-group">
                <label for="cwebsite" class="text-primary" id="lab">Cari Mahasiswa</label>
                <input type="hidden" name="target_nim" id="target_nim" />
                <input class="form-control search_nim_table" type="text" name="search_nim_table"  id="search_nim_table" autocomplete="off" >
                <small>Masukkan nim atau nama</small>
            </div>
            <div class="modal-footer">
               <a href="javascript:search_cari_nim();" class="btn btn-primary" > Cari </a>  
               <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
           </div> 
           <div id="kotak_pencarian_nim">

           </div>
       </div>
   </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->       



<?php
$this->load->view("backend/global_css");
$this->load->view($controller."_js");
?>

</div>
