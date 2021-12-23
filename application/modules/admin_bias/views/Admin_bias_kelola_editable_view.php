<link href="<?php echo base_url(); ?>assets/admin/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url("assets/admin") ?>/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />
<!-- <div class="container-fluid"> -->
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $title ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $subtitle; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $subtitle ?> </h4>
            </div>
        </div>
    </div>     

    <div class="row">
        <div class="col-lg-12">
            <!-- Portlet card -->
            <div class="card">
                <div class="card-header  py-3 text-white" style="background-color: #675aa9">
                    <div class="card-widgets">
                        <a href="javascript:;" onclick="load_data()" data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                        <a data-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false" aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                        <!-- <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a> -->
                    </div>
                    <a href="<?php echo site_url(strtolower($controller)) ?>" class="btn btn-danger btn-sm waves-effect"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <p></p>
                    <p class="card-text">Kelola Rekapitulasi Hasil Cakupan Bulan Imunisasi Anak Sekolah (BIAS) <span class="text-warning"><?php echo "Tahun ".$admin_bias->tahun."</span>" ?>
                </p>
            </div>
            <div id="cardCollpase4" class="collapse show">
                <div class="card-body">
                    <p><code>Info !!! Klik area untuk merubah data. Gunakan Scrool pada tabel paling bawah untuk mengeser data dari kanan ke kiri atau sebalikya</code></p>

                    
                    <?php 
                    $ident = $this->om->identitas_general_l_a($this->session->userdata("admin_pkm"));
                    if ($ident->bentuk == "1" or $this->session->userdata("admin_level") == "admin") {
                    $des = "Desa"; ?>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="pt-3 pb-4">
                                <div class="input-group m-t-10">
                                    <input type="text" id="cari_sekolah"  class="form-control" autocomplete="off" placeholder="Cari Sekolah">
                                    <span class="input-group-append">
                                        <button type="button" disabled="" style="cursor: unset;" class="btn waves-effectwaves-light btn-blue"><i class="fa fa-search mr-1"></i></button>
                                        <button type="button" onclick="reset_form()" class="btn waves-effect mr-3 waves-light btn-danger"><i class="fa fa-undo mr-1"></i></button>
                                        
                                        <div class="btn-group show">
                                         <button type="button" class="btn btn-primary btn-xs  ml-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> <i class="fa fa-print mr-1"></i> Cetak <i class="mdi mdi-chevron-down"></i> </button>
                                         <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
                                           <button class="dropdown-item" onclick="cetak()" >Berdasarkan Sekolah</button>
                                          <button class="dropdown-item" onclick="cetak_desa()" >Berdasarkan Desa</button>
                                         </div>
                                       </div>

                                      
                                    </span>
                                </div>
                                <div class="mt-3 text-center" id="memuat">
                                    <button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Memuat... </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else {
                    $des = "Rumah Sakit"; ?>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="text-lg-left mb-3 mt-lg-0">
                                   <button type="button" onclick="cetak()" class="btn btn-primary waves-effect waves-light">
                                    <i class="fa fa-print mr-1"></i></span>Cetak
                                </button>
                            </div>
                            </div>
                        </div>
                       <input type="hidden" id="cari_sekolah"  class="form-control" placeholder="Cari Sekolah">
                   <?php } ?>


                    <div class="responsive-table-plugin">
                       
                        <style type="text/css">
                            .tablex {
                                position: sticky;
                                top: 0;
                                z-index: 21;
                            }
                        
                        </style>
                        <div class="table-rep-plugin">
                            <div class="table" data-pattern="priority-columns">
                                 <table id="basic-datatable" class="table-bordered table table-hover">
                                <thead class="thead-light ">
                                        <tr>
                                            <th rowspan="2"  class="align-middle" style="background-color: #f1f5f7; font-weight: bold;">No</th>
                                            <th rowspan="2"  class="align-middle">SEKOLAH</th>
                                            <th colspan="2" ><span class="balik">JUMLAH MURID DLM ABSEN<br>KLS 1</span></th>
                                            <th colspan="2"><span class="balik">JUMLAH MURID DLM ABSEN<br>KLS 2</span></th>
                                            <th colspan="2" ><span class="balik">JUMLAH MURID DLM ABSEN<br>KLS 5</span></th>
                                            <th colspan="4" ><span class="balik">JUMLAH MURID DIIMUNISASI<br>KLS 1</span></th>
                                            <th colspan="2"><span class="balik">JUMLAH MURID DIIMUNISASI<br>KLS 2</span></th>
                                            <th colspan="2" ><span class="balik">JUMLAH MURID DIIMUNISASI<br>KLS 5</span></th>
                                            <th colspan="3" ><span class="balik">JUMLAH VAKSIN DIPAKAI</span></th>
                                            <th colspan="2" ><span class="balik">JUMLAH LOGISTIK DIPAKAI</span></th>
                                            
                                        </tr>
                                        <tr>
                                           <!--  <th></th>
                                            <th></th> -->
                                            <th style="background-color : #99D4FA">L</th>
                                            <th>P</th>
                                            <th style="background-color : #99D4FA">L</th>
                                            <th>P</th>
                                            <th style="background-color : #99D4FA">L</th>
                                            <th>P</th>
                                            <th style="background-color : #99D4FA">(DT)<br>L</th>
                                            <th>(DT)<br>P</th>
                                            <th style="background-color : #99D4FA">(CPK)<br>L</th>
                                            <th>(CPK)<br>P</th>
                                            <th style="background-color : #99D4FA">(TD)<br>L</th>
                                            <th>(TD)<br>P</th>
                                            <th style="background-color : #99D4FA">(TD)<br>L</th>
                                            <th>(TD)<br>P</th>
                                            <th style="background-color : #99D4FA">DT</th>
                                            <th>CPK</th>
                                            <th style="background-color : #99D4FA">TD</th>
                                            <th>Ads 5ml</th>
                                            <th style="background-color : #99D4FA">Ads 0,5ml</th>
                                            
                                        </tr>
                                  
                           </thead>

                           <tbody id='lain'></tbody>
                       </table>
                   </div>
               </div>
           </div>
       </div>
   </div>
</div> <!-- end card-->
</div><!-- end col -->

</div>

<!-- </div> -->



<!-- end row-->

<style type="text/css">
    .balikxx{
        writing-mode:tb-rl;
        -webkit-transform:rotate(-90deg);
        -moz-transform:rotate(-90deg);
        -o-transform: rotate(-90deg);
        -ms-transform:rotate(-90deg);
        transform: rotate(-1deg);
        white-space:nowrap;
        float:center;
        /*border: 1px solid #ddd;
        border-width: 10px;*/

    }

.table {
  max-width: 200%;
  max-height: 650px;
  overflow: scroll;
}



.tablex {
  /*max-width: 200%;*/
   table-layout: fixed;
    word-wrap: break-word;
     overflow: hidden;
  /*max-height: 650px;*/
  /*overflow: scroll;*/
}



tbody th {
  position: sticky;
  position: -webkit-sticky;
  left: 0;
  z-index: 0;
}
thead th {
  position: -webkit-sticky;
  top: 0;
  position: sticky;
  text-align: center;
  z-index: 0;
  /*background-color: #D0ECE7;*/
}

.thead-light{
    border: 1px solid #dee2e6;
    z-index: 1 !important;
    text-align: center;
}
/*
.jkk {
  position: -webkit-sticky;
  top: 0;
  position: sticky;
  text-align: center;
  z-index: 1;
}
*/

/*.jkk:first-child {
  left: 0;
  z-index: 1;
}
*/
tbody th {
  background: #FFF8DC;
  border-right: 1px solid #ddd;
}

tbody td {
 text-align: center;
}
/*.table-bordered td, .table-bordered th {
border: 1px solid #dee2e6;
z-index: 1 !important;
}*/
table {
  border-collapse: collapse;
}

::-webkit-scrollbar {
    width: 10px;
} 
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
} 
::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
}

.table::-webkit-scrollbar-thumb {
    background-color: rgba(44, 130, 201, 1);
    border-radius: 10px;
    border: 2px solid red;
}

.table::-webkit-scrollbar-track {
    border-radius: 6px;  
    background-color: #E6E6FA; 
}
</style>



<?php
$this->load->view("backend/global_css");
$this->load->view("Admin_bias_kelola_editable_js");
?>

</div>

