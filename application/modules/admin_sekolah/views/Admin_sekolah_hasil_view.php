 <div class="container-fluid">
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
          <a class="btn btn-success btn-rounded waves-effect waves-light" href="<?php echo site_url("admin_sekolah") ?>"><span class="btn-label"><i class="fe-user-check"></i></span>Lihat Hasil</a>
          
          <h3>IMPORT DATA SEKOLAH SELESAI </h3>
          <span class="text-success">Data berhasil diproses <?php echo $berhasil; ?> </span><br />
          <span class="text-danger">Data gagal diproses <?php echo $gagal; ?> </span>
          <hr />

          <?php 
          foreach($arr_berhasil as $x) : 
            echo "$x <span class='text-success'>berhasil disimpan</span> <br />";
          endforeach;
          ?>
          <?php 
          foreach($arr_gagal as $x) : 
            echo "$x   <span class='text-danger'>gagal disimpan. NPSN/Sekolah sudah ada</span> <br />";
          endforeach;
          ?>
          
        </div> 
      </div> 
    </div>
  </div>



