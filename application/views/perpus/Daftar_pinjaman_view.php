<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title"><?php echo $title ?></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <?php if ($this->session->userdata("admin_login") == true and $this->session->userdata("admin_level") == "user") { ?>
                     
                    <?php if ($res->num_rows() > 0) {?>
                        <?php 
                         $i = 0;
                         foreach($res->result() as $row) :
                            $tgl_peminjaman = explode(" ", $row->tgl_peminjaman);
                            $tgl_pengembalian = explode(" ", $row->tgl_pengembalian);
                            $tgl_dikembalikan = explode(" ", $row->tgl_dikembalikan);
                            $i++; ?>
                            <div class="alert alert-light bg-light text-dark border-0" role="alert">
                                <strong><?php echo $i.". ".$row->judul_buku." (".$row->kode_buku.")" ?></strong> — <code>Masa Pinjam : <?php echo tgl_indo($tgl_peminjaman[0])." ".$tgl_peminjaman[1]." s/d ".tgl_indo($tgl_pengembalian[0])." ".$tgl_pengembalian[1] ?></code>
                            </div>
                        <?php endforeach; ?>
                    <?php } else {?>
                        <div class="alert alert-light bg-info text-white border-0" role="alert">
                            Belum ada pinjaman
                        </div>
                    <?php } ?>   


                <?php  } else {?>
                    <div class="alert alert-light bg-danger text-white border-0" role="alert">
                        Info. Silahkan login sebagai member untuk melihat daftar pinjaman anda
                    </div>
                <?php  } ?>
                
               
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div>


    <style type="text/css">
        @media only screen and (max-width: 480px) {
          img {
            width: 100%;
        }
    }
</style>

</div>