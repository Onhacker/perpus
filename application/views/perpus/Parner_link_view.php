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
                <?php 
                    $i = 0;
                    foreach($link->result() as $row) :
                        if ($this->uri->segment(2) == "berita") {
                            $seg = $row->nama_berita;
                        } elseif ($this->uri->segment(2) == "jurnal") {
                            $seg = $row->nama_jurnal;
                        }
                    $i++; ?>
                    <div class="alert alert-light bg-light text-dark border-0" role="alert">
                        <strong><?php echo $i.". ".$seg ?></strong> — <a href="<?php echo $row->link ?>" target="_BLANK"><?php echo $row->link ?></a>
                    </div>
                <?php endforeach; ?>
               
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