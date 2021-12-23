<link href="<?php echo base_url(); ?>assets/admin/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url("assets/admin") ?>/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?php echo $title ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="">
                                <div class="input-group ">
                                    <input type="text" id="myInputTextField" class="form-control">
                                    <span class="input-group-append">
                                        <button type="button" class="btn waves-effect waves-light btn-blue"><i class="fa fa-search mr-1"></i> Cari</button>
                                    </span>
                                </div>
                                <div class="mt-1 text-center">
                                    <h4><span id="hasil"></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="datable_1" class="table  table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th><?php echo $title ?></th> 

                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    <?php $this->load->view("jurnal_js") ?>

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

    <style type="text/css">
        @media only screen and (max-width: 480px) {
          img {
            width: 100%;
        }
        .modal-dialog{
            height:calc(100% - 60px);
        }
        .modal-content{
          height:100%;
      }
      .modal-header{
        height:50px;

    }
    .model-footer{
        height:75px;
    }
    .modal-body {
        height:calc(100% - 125px);
        overflow-y: scroll;     /*give auto it will take based in content */
    }
}
</style>

</div>