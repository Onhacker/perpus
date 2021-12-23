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
            <!-- <input type="text" id="myInputTextField"> -->

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
                    <table id="datable_1" class="table table-responsive " style="width:100%">
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
    <?php $this->load->view("Katalog_js") ?>

    <style type="text/css">
        @media only screen and (max-width: 480px) {
          img {
            width: 100%;
        }
    }
</style>

</div>