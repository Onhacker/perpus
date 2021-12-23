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
          <form id="gembreng" enctype="multipart/form-data" method="post" action="<?php echo site_url(strtolower($controller)."/save"); ?>">
            <div class="alert alert-light" role="alert">
             <input type="submit" class="btn btn-success btn-rounded waves-effect waves-light" value="Import Data" /><br>
             <code><strong>PERHATIAN : </strong> Ceklis cek box paling atas untuk mengimport semua data, Lalu Klik tombol import Data</code>
            </div>
            

          </div>
          <hr>
          <table  class="table table-striped table-bordered" style="width:100%">

            <thead>
              <tr>
                <th width="5%" class="float-center">
                  <div class="checkbox checkbox-primary checkbox-single">
                    <input id="check-all" type="checkbox" name="selall" value="1">
                    <label></label>
                  </div>
                </th>
                <th width="4%">NO.</th>
                <th width="15%">NPSN</th>
                <th width="10%">SEKOLAH</th>
                <th width="10%">KECAMATAN</th>
                <th width="15%">KUOTA</th>
              </tr>
            </thead>
            <?php 
              $i = 0;
              foreach($data as $index => $row) : 
                if ($row["npsn"] !="") {
                 
               
              $i++;
            
            ?>   
              <tr>
                <td >
                  <div class="checkbox checkbox-primary checkbox-single">
                    <input class="ck_data" type="checkbox" name="data[<?php echo $index; ?>]" value="<?php echo isset($index)?$index:""; ?>" /><label></label>
                  </div>
                </td>
                <td ><?php echo $i; ?></td>
                <td ><?php echo $row['npsn']; ?></td>
                <td ><?php echo $row['nama_sekolah']; ?></td>
                <td ><?php echo $row['kecamatan']; ?></td>
                <td ><?php echo $row['kuota']; ?></td>

               
              </tr>

              <?php } endforeach; ?>
            </form>
            </table>
          </div> 
        </div> 
      </div>
    </div>

    <script>
     $(document).ready(function(){

      $("#check-all").click(function(){

	         if(this.checked) { // check select status
            $('.ck_data').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
              });
          } else {
            $('.ck_data').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
              });        
          }


        }
        );
    });              
  </script>