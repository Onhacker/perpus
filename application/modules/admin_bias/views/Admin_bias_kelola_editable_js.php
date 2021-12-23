<script type="text/javascript">
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    function reset_form(){
        $('#cari_sekolah').val("");
        load_data();
    }

    
$(document).ready(function(){
    $("#cari_sekolah").click(function(){
       document.body.scrollTop = 0;
       document.documentElement.scrollTop = 0;
    });

    $("#cari_sekolah").keyup(function(){
        load_data();
    });

    load_data();
     $('#lain').editable({
        container: 'body',
        selector: 'td.absen_kelas_1_l',
        url: "<?php echo site_url(strtolower($controller)."/absen_kelas_1_l") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.absen_kelas_1_p',
        url: "<?php echo site_url(strtolower($controller)."/absen_kelas_1_p") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.absen_kelas_2_l',
        url: "<?php echo site_url(strtolower($controller)."/absen_kelas_2_l") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.absen_kelas_2_p',
        url: "<?php echo site_url(strtolower($controller)."/absen_kelas_2_p") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.absen_kelas_5_l',
        url: "<?php echo site_url(strtolower($controller)."/absen_kelas_5_l") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.absen_kelas_5_p',
        url: "<?php echo site_url(strtolower($controller)."/absen_kelas_5_p") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.imun_kelas_1_l_dt',
        url: "<?php echo site_url(strtolower($controller)."/imun_kelas_1_l_dt") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.imun_kelas_1_p_dt',
        url: "<?php echo site_url(strtolower($controller)."/imun_kelas_1_p_dt") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.imun_kelas_1_l_cpk',
        url: "<?php echo site_url(strtolower($controller)."/imun_kelas_1_l_cpk") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.imun_kelas_1_p_cpk',
        url: "<?php echo site_url(strtolower($controller)."/imun_kelas_1_p_cpk") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.imun_kelas_2_l',
        url: "<?php echo site_url(strtolower($controller)."/imun_kelas_2_l") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.imun_kelas_2_p',
        url: "<?php echo site_url(strtolower($controller)."/imun_kelas_2_p") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.imun_kelas_5_l',
        url: "<?php echo site_url(strtolower($controller)."/imun_kelas_5_l") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.imun_kelas_5_p',
        url: "<?php echo site_url(strtolower($controller)."/imun_kelas_5_p") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.vaksin_dt',
        url: "<?php echo site_url(strtolower($controller)."/vaksin_dt") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.vaksin_cpk',
        url: "<?php echo site_url(strtolower($controller)."/vaksin_cpk") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.vaksin_td',
        url: "<?php echo site_url(strtolower($controller)."/vaksin_td") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.logistik_5ml',
        url: "<?php echo site_url(strtolower($controller)."/logistik_5ml") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });
 $('#lain').editable({
        container: 'body',
        selector: 'td.logistik_05ml',
        url: "<?php echo site_url(strtolower($controller)."/logistik_05ml") ?>/<?php echo $admin_bias->id_admin_bias ?>",
        title: ' ',
        type: "POST",
        dataType: 'json',
        validate: function(value){
            if($.trim(value) == '') {
                return 'Tidak boleh Kosong';
            }
            var regex = /^[0-9.]+$/;
            if(! regex.test(value)){
              return 'Masukkan Angka';
            }
        },
        success: function(obj){
            console.log(obj);
            if (obj.success == false ){
                alert("gagal");
            } else {
               success();
            }
        }

    });

})

function success(){
    $.toast().reset('all');
    $("body").removeAttr('class');
    $.toast({
        text: "Data tersimpan", // Text that is to be shown in the toast
        heading: 'Berhasil', // Optional heading to be shown on the toast
        icon: 'info', // Type of toast icon
        showHideTransition: 'slide', // fade, slide or plain
        allowToastClose: true, // Boolean value true or false
        hideAfter: 1000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
        position: 'mid-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
        textAlign: 'left',  // Text alignment i.e. left, right or center
        loader: true,  // Whether to show loader or not. True by default
        loaderBg: '#FF4500',  // Background color of the toast loader
    });
}

function cetak() {
    window.open("<?php echo site_url(strtolower($controller)."/pdf_laporan/".$admin_bias->id_admin_bias) ?>")
    
}

function cetak_desa() {
    window.open("<?php echo site_url(strtolower($controller)."/pdf_laporan_desa/".$admin_bias->id_admin_bias) ?>")
    
}

function load_data() {
    $('#memuat').show(); 
    $('#lain').html(''); 
    $.ajax({
        url:"<?php echo site_url(strtolower($controller)) ?>/load_isi_admin_bias/<?php echo $admin_bias->id_admin_bias ?>/"+$("#cari_sekolah").val(),
        method:"get",
        dataType:"json",
        success:function(data){
            $('#memuat').fadeOut(); 
            $('#lain').html(''); 
            for(var count=0; count<data.length; count++) {
                var 
                html_data = '<tr>';
                html_data += '<td>'+data[count].no+'</td>';
                html_data += '<th>'+data[count].sekolah+'</th>';
                html_data += '<td data-name="absen_kelas_1_l" style="cursor: '+data[count].b+'; class="align-middle" class="absen_kelas_1_l" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].absen_kelas_1_l+'</td>'
                html_data += '<td data-name="absen_kelas_1_p" style="cursor: '+data[count].b+'; class="align-middle" class="absen_kelas_1_p" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].absen_kelas_1_p+'</td>'
                html_data += '<td data-name="absen_kelas_2_l" style="cursor: '+data[count].b+'; class="align-middle" class="absen_kelas_2_l" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].absen_kelas_2_l+'</td>'
                html_data += '<td data-name="absen_kelas_2_p" style="cursor: '+data[count].b+'; class="align-middle" class="absen_kelas_2_p" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].absen_kelas_2_p+'</td>'
                html_data += '<td data-name="absen_kelas_5_l" style="cursor: '+data[count].b+'; class="align-middle" class="absen_kelas_5_l" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].absen_kelas_5_l+'</td>'
                html_data += '<td data-name="absen_kelas_5_p" style="cursor: '+data[count].b+'; class="align-middle" class="absen_kelas_5_p" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].absen_kelas_5_p+'</td>'
                html_data += '<td data-name="imun_kelas_1_l_dt" style="cursor: '+data[count].b+'; class="align-middle" class="imun_kelas_1_l_dt" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].imun_kelas_1_l_dt+'</td>'
                html_data += '<td data-name="imun_kelas_1_p_dt" style="cursor: '+data[count].b+'; class="align-middle" class="imun_kelas_1_p_dt" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].imun_kelas_1_p_dt+'</td>'
                html_data += '<td data-name="imun_kelas_1_l_cpk" style="cursor: '+data[count].b+'; class="align-middle" class="imun_kelas_1_l_cpk" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].imun_kelas_1_l_cpk+'</td>'
                html_data += '<td data-name="imun_kelas_1_p_cpk" style="cursor: '+data[count].b+'; class="align-middle" class="imun_kelas_1_p_cpk" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].imun_kelas_1_p_cpk+'</td>'
                html_data += '<td data-name="imun_kelas_2_l" style="cursor: '+data[count].b+'; class="align-middle" class="imun_kelas_2_l" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].imun_kelas_2_l+'</td>'
                html_data += '<td data-name="imun_kelas_2_p" style="cursor: '+data[count].b+'; class="align-middle" class="imun_kelas_2_p" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].imun_kelas_2_p+'</td>'
                html_data += '<td data-name="imun_kelas_5_l" style="cursor: '+data[count].b+'; class="align-middle" class="imun_kelas_5_l" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].imun_kelas_5_l+'</td>'
                html_data += '<td data-name="imun_kelas_5_p" style="cursor: '+data[count].b+'; class="align-middle" class="imun_kelas_5_p" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].imun_kelas_5_p+'</td>'
                html_data += '<td data-name="vaksin_dt" style="cursor: '+data[count].b+'; class="align-middle" class="vaksin_dt" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].vaksin_dt+'</td>'
                html_data += '<td data-name="vaksin_cpk" style="cursor: '+data[count].b+'; class="align-middle" class="vaksin_cpk" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].vaksin_cpk+'</td>'
                html_data += '<td data-name="vaksin_td" style="cursor: '+data[count].b+'; class="align-middle" class="vaksin_td" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].vaksin_td+'</td>'
                html_data += '<td data-name="logistik_5ml" style="cursor: '+data[count].b+'; class="align-middle" class="logistik_5ml" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].logistik_5ml+'</td>'
                html_data += '<td data-name="logistik_05ml" style="cursor: '+data[count].b+'; class="align-middle" class="logistik_05ml" data-type="text" data-placement="top" data-pk="'+data[count].id_admin_bias_isi+'">'+data[count].logistik_05ml+'</td>'
                 
                html_data += '</tr>'
                $('#lain').append(html_data);
            }                
        }
    })
}
</script>
