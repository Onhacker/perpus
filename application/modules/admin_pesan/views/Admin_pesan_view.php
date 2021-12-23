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
                    <div class="inbox-leftbar">

                                <a href="javascript:void(0)" onclick="add()" class="btn btn-danger btn-block waves-effect waves-light">Kirim Pesan</a>

                                <div class="mail-list mt-4">
                                    <a href="javascript:void(0)" onclick="inbox()" class="list-group-item border-0 " id="ib"><i class="mdi mdi-inbox font-18 align-middle mr-2"></i>Inbox<span class="badge badge-primary float-right ml-2 mt-1" id="jp"></span></a>
                                    <a href="javascript:void(0)" onclick="bintang()" id="bi" class="list-group-item border-0"><i class="mdi mdi-star font-18 align-middle mr-2"></i>Berbintang<span class="badge badge-warning float-right ml-2 mt-1" id="btg"></span></a>
                                    <a href="javascript:void(0)" onclick="sent()" id="tk" class="list-group-item border-0"><i class="mdi mdi-send font-18 align-middle mr-2"></i>Terkirim<span class="badge badge-success float-right ml-2 mt-1" id="snnnt"></span></a>
                                    <a href="javascript:void(0)" onclick="load_trash()" id="lt" class="list-group-item border-0"><i class="mdi mdi-delete font-18 align-middle mr-2"></i>Sampah<span class="badge badge-danger float-right ml-2 mt-1" id="sp"></span></a>
                                </div>

                               

                            </div>
                            <!-- End Left sidebar -->

                            <div class="inbox-rightbar">

                                <div class="btn-group" id="tru">
                                   
                                    
                                </div>
                                <!-- <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-folder font-18"></i>
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <span class="dropdown-header">Move to</span>
                                        <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-label font-18"></i>
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <span class="dropdown-header">Label as:</span>
                                        <a class="dropdown-item" href="javascript: void(0);">Updates</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Social</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Promotions</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Forums</a>
                                    </div>
                                </div> -->
                                <span class="float-right"><a href="javascript:void(0)">Email Account : <?php echo $this->om->web_me()->email ?> </a></span>
                               <!--  <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal font-18"></i> More
                                        <i class="mdi mdi-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <span class="dropdown-header">More Option :</span>
                                        <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Add Star</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Mute</a>
                                    </div>
                                </div> -->

                                <div class="mt-3">
                                    <i class="fe-arrow-right"></i> <span id="kal" class="text-primary"> Inbox</span>&nbsp; 
                                    <!-- <span class="float-right"><a href="javascript:void(0)" onclick="hapus_data()" id="selamanya"> </a></span> -->
                                    <p></p>
                                    <table id="datable_1" class="table table-borderless mb-0 table-hover" style="width:100%; ">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="float-center">
                                                    <div class="checkbox checkbox-primary checkbox-single">
                                                        <input id="check-all" type="checkbox">
                                                        <label></label>
                                                    </div>
                                                </th>
                                                <th></th>
                                                <th>Pengirim</th>
                                                <th>Pesan</th>
                                                <th>Waktu</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div> 
                    
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
                    <input type="hidden" name="id_hubungi" id="id_hubungi">              
                    <h5 class="font-18" id="subjek"></h5>
                    <hr/>
                    <div class="media mb-4 mt-1">
                        <div class="media-body">
                            <span class="float-right"><span id="waktu"></span>  <span id="jam"></span></span>
                            <h6 class="m-0 font-14" id="nama"></h6>
                            <small class="text-muted" id="email"></small>
                        </div>
                    </div>
                    <div id="pes">
                    <label class="text-primary"><code>Pesan</code></label><br>
                    <span id="pesan"></span>
                    </div>
                    <hr>
                    <div class="form-group mb-3" id="sum">
                        <label class="text-primary"><code>Balas</code></label>
                        <textarea id='summernote' class='form-control' name='balas'></textarea>
                    </div>
                    <div class="form-group mb-3" id="balas">
                        <label class="text-primary" id="text-balas">Balasan</label><br>
                        <span class="float-right"><span id="tgl_bls"></span></span>
                        <span id="balasan"></span>
                    </div>

                </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Tutup</button>
                    <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light" id="btn-kirim">Kirim Balasan</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->





     <div id="full-width-modal-add" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-full modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodal-title-add" id="full-width-modalLabel">Modal Heading</h4>
                    <button type="button" class="close" onclick="close_modal_add()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                 <form id="form_appp" method="post"  enctype="multipart/form-data" >
                    <input type="hidden" name="id_hubungi" id="id_hubungi">              
                    <div class="form-group mb-3">
                        <label class="text-primary">Subject</label>
                        <input class='form-control' name="subjek" type="text" id="subjek">
                    </div>
                     <div class="form-group mb-3">
                        <label class="text-primary">Email</label>
                        <input class='form-control' name="email" type="text" id="email">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary"><code>Isi Pesan</code></label>
                        <textarea id='summernoteadd' class='form-control' name='balasan'></textarea>
                    </div>

                </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal_add()">Tutup</button>
                    <button type="button" onclick="simpan_add()" class="btn btn-primary waves-effect waves-light" id="btn-kirim">Kirim Pesan</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php
        $this->load->view("backend/global_css");
        $this->load->view("backend/global_js");
        $this->load->view($controller."_js");
    ?>
</div>

