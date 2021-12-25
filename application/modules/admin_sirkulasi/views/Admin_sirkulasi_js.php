<style type="text/css">
    .dataTables_filter input { width: 500px !important; height: 40px !important }
    .dataTables_length select {
        height: 40px !important;
    }
</style>
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        $("#range_awal").flatpickr({

            enableTime:!0,
            dateFormat:"d-m-Y H:i:S",
            // autoclose:"true",
            mode :"range",
            inline: true,
            // defaultDate: [data.waktu_awal, data.waktu_akhir]
        })
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        table = $('#datable_1').DataTable({
            "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            initComplete: function() {
                var api = this.api();
                $('.dataTables_filter input').focus();
                $(".dataTables_filter input").attr("placeholder", "Cari nama mahasiswa, nim, judul buku, kode buku/ scan barcode buku");
                $('#datatable-buttons_filter input')
                .off('.DT')
                .on('input.DT', function() {
                    api.search(this.value).draw();
                });
            },
            oLanguage: {
                sProcessing     :   "Memuat Data...",
                sSearch         :   "<i class='ti-search'></i> Cari :",
                sZeroRecords    :   "Maaf Data Tidak Ditemukan",
                sLengthMenu     :   "Tampil _MENU_ Data",
                sEmptyTable     :   "Data Tidak Ada",
                sInfo           :   "Menampilkan _START_ -  _END_ dari _TOTAL_ Total Data",
                sInfoEmpty      :   "Tidak ada data ditampilkan",
                sInfoFiltered   :   "(Filter dari _MAX_ total Data)",
                "oPaginate"     :   {
                                    "sNext": "<i class='fe-chevrons-right'></i>",
                                    "sPrevious": "<i class='fe-chevrons-left'></i>"
                                    },
            },
            "scrollX": true,
            processing: true,
            serverSide: true,
            ajax: {"url": "<?php echo site_url(strtolower($controller)."/get_data")?>", "type": "POST"},
            columns: [
                {"data": "cek","orderable": false},
                {"data": "id_sirkulasi","orderable": false},
                {"data" : "nim"},
                {"data" : "nama_mahasiswa"},
                {"data" : "judul_buku"},
                {"data" : "kode_buku"},
                {"data" : "range"},
                
                {"data" : "status"},               
                {"data" : "wa"},               
            ],

            "order": [],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(1)', row).html(index); // masukkan index untuk menampilkan no urut
            }
        });
    });

    function reload_table() {
        table.ajax.reload(null,false); 
    }

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    

    function copy_link(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        $.toast({
            text: "Link tercopy", // Text that is to be shown in the toast
            heading: 'Copy', // Optional heading to be shown on the toast
            icon: 'info', // Type of toast icon
            showHideTransition: 'slide', // fade, slide or plain
            allowToastClose: true, // Boolean value true or false
            hideAfter: 1000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
            position: 'mid-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
            textAlign: 'left',  // Text alignment i.e. left, right or center
            loader: true,  // Whether to show loader or not. True by default
            loaderBg: '#da8609',  // Background color of the toast loader
            
        });
    }

    function loader() {
        Swal.fire({
            title: "Prosess...",
            html: "Jangan tutup halaman ini",
            allowOutsideClick: false,
            onBeforeOpen: function() {
                Swal.showLoading()
            },
            onClose: function() {
                clearInterval(t)
            }
        })
    }

  

    function add(){ 
        $('#form_app')[0].reset(); 
        save_method = 'add';
        $('#id_sirkulasi').val("");
        $('#deskripsi').text("");
        $("#detail").hide();
        $("#btnshownim").hide();
        $("#detail_nim").hide();
        $(".range_awal").hide();
        Tanggal = new Date().getDate();
        tlg2 = new Date().getDate()+7;
        Bulan = new Date().getMonth();
        Tahun = new Date().getFullYear();
        Jam = new Date().getHours();
        Menit = new Date().getMinutes();
        Detik = new Date().getSeconds();


        $("#range_awal").flatpickr({
            enableTime:!0,
            dateFormat:"d-m-Y H:i:S",
            autoclose:"true",
            mode :"range",
            inline: true,
            defaultDate: [Tanggal+"-"+Bulan+"-"+Tahun+" "+Jam+" : "+Menit+" : "+Detik, Tanggal+"-"+Bulan+"-"+Tahun+" "+Jam+" : "+Menit+" : "+Detik]
        })
        $('#full-width-modal').modal('show'); 
        $('.mymodal-title').text('Tambah Data'); 
        show_dialog('id_buku');
    }

    function edit() {
        $('#form_app')[0].reset(); 
        loader();
        var list_id = [];
        $(".data-check:checked").each(function() {
            list_id.push(this.value);
        });
  
        if(list_id.length == 1) { 
            save_method = 'update';
            $.ajax({
                url : "<?php echo site_url(strtolower($controller).'/edit')?>/" + list_id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $("#detail").show();
                    $("#btnshownim").show();
                    $("#detail_nim").show();
                    $(".range_awal").show();
                    Swal.close();

                    $('#id_sirkulasi').val(data.id_sirkulasi);
                    $("#id_buku").val(data.id_buku);
                    $("#kode_buku").val(data.kode_buku);
                    $("#nim").val(data.nim);
                    load_buku();
                    load_nim();

                    $("#range_awal").flatpickr({
                        enableTime:!0,
                        dateFormat:"d-m-Y H:i:S",
                        autoclose:"true",
                        mode :"range",
                        inline: true,
                        defaultDate: [data.tgl_peminjaman, data.tgl_pengembalian]
                    })
                    $('#full-width-modal').modal('show'); 
                    $('.mymodal-title').html('Edit Data <code>'+ data.nama_mahasiswa+'</code>'); 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        } else if (list_id.length >= 2) {
            Swal.fire("Info","Tidak dapat mengedit "+list_id.length+" data sekaligus, Pilih satu data saja", "warning");
        } else {
            Swal.fire("Info","Pilih Satu Data", "warning");
        }
    }

    function sel(id) {
        // alert(id);
        loader();
        $.ajax({
            url : "<?php echo site_url(strtolower($controller).'/wa')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(result){
                Swal.close();
                // console.log(result);
                // obj = $.parseJSON(result);
                if (result.success == false ){
                    swal.fire({   
                        title: result.title,   
                        type: "error", 
                        html: result.pesan,
                        allowOutsideClick: false,
                        confirmButtonClass: "btn btn-confirm mt-2"   
                    });
                    return false;
                } else {
                    Swal.fire({
                        title: result.title,  
                        html: result.pesan,   
                        type: "success",
                        allowOutsideClick: false,
                        confirmButtonClass: "btn btn-confirm mt-2"
                    });

                    $("#full-width-modal").modal("hide"); 
                    reload_table();
                }   
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("fucks");
            }
        });

      
    }

    function simpan(){
        var url;
        if(save_method == 'add') {
            url = "<?php echo site_url(strtolower($controller).'/add')?>/";
        } else {
            url = "<?php echo site_url(strtolower($controller).'/update')?>/";
        }   

        $('#form_app').form('submit',{
            url: url,
            onSubmit: function(){
                loader();
                return $(this).form('validate');
        },
        dataType:'json',
        success: function(result){
            console.log(result);
            obj = $.parseJSON(result);
            if (obj.success == false ){
                swal.fire({   
                    title: obj.title,   
                    type: "error", 
                    html: obj.pesan,
                    allowOutsideClick: false,
                    confirmButtonClass: "btn btn-confirm mt-2"   
                });
                return false;
            } else {
                Swal.fire({
                    title: obj.title,  
                    html: obj.pesan,   
                    type: "success",
                    allowOutsideClick: false,
                    confirmButtonClass: "btn btn-confirm mt-2"
                });

                $("#full-width-modal").modal("hide"); 
                reload_table();
            }   
        }
        });
    }



    function hapus_data() {
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        if(list_id.length > 0) { 
            Swal.fire({
                title: "Yakin ingin menghapus "+list_id.length+" data ?",
                text: "Anda tidak dapat mengembalikan data terhapus",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya Hapus",
                cancelButtonText: "Batal",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    loader();
                    $.ajax({
                        type: "POST",
                        url : "<?php echo site_url(strtolower($controller).'/hapus_data')?>/",
                        data: {id:list_id},
                        cache : false,
                        dataType: "json",
                        success: function(result) {
                            Swal.close();
                            reload_table();
                            if(result.success == false){
                                Swal.fire(result.title,result.pesan, "error");
                                return false;
                            } else {
                                Swal.fire(result.title,result.pesan, "success");
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert("fucks");
                        }
                    });
                } else {
                    // $('#summernote').summernote("insertImage", src);
                }
            })
        } else {
            Swal.fire("Info","Pilih Satu Data", "warning");
        }
    }

    function kembali() {
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        if(list_id.length > 0) { 
            Swal.fire({
                title: "Yakin ingin mengembalikan "+list_id.length+" Buku ?",
                text: "Pastikan buku sudah sesuai",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya Kembalikan",
                cancelButtonText: "Batal",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    loader();
                    $.ajax({
                        type: "POST",
                        url : "<?php echo site_url(strtolower($controller).'/kembalikan')?>/",
                        data: {id:list_id},
                        cache : false,
                        dataType: "json",
                        success: function(result) {
                            Swal.close();
                            reload_table();
                            if(result.success == false){
                                Swal.fire(result.title,result.pesan, "error");
                                return false;
                            } else {
                                Swal.fire(result.title,result.pesan, "success");
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert("fucks");
                        }
                    });
                } else {
                    // $('#summernote').summernote("insertImage", src);
                }
            })
        } else {
            Swal.fire("Info","Pilih Satu Data", "warning");
        }
    }

   $(document).on('keypress', ':input:not(textarea):not([type=submit])', function (e) {
        if (e.which == 13) e.preventDefault();
    });

    function close_modal(){
        Swal.fire({
            title: "Yakin ingin menutup ?",
            text: "Anda tidak dapat mengembalikan data yang belum tersimpan atau silahkan simpan sebagai draft jika belum diterbitkan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Tutup",
            cancelButtonText: "Batal",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                $("#full-width-modal").modal("hide");
            } 
        })
    }

    function close_modal_des(){
        $("#full-width-modal-des").modal("hide");
    }

    function show_dialog(target) {
         $("#kotak_pencarian").html('');
         $("#target").val(target);
         $('#modal_buku').on('shown.bs.modal', function() {
            $('.search_nama_table').focus();
        });
         $('#modal_buku').modal('show');
         $('.modal-title-cari').text('Cari Buku');
    } 

     function show_dialog_nim(target) {
         $("#kotak_pencarian_nim").html('');
         $("#target_nim").val(target);
         $('#modal_nim').on('shown.bs.modal', function() {
            $('.search_nim_table').focus();
        });
         $('#modal_nim').modal('show');
         $('.modal-title-cari-nim').text('Cari Mahasiswa');
    } 

    $('#kode_buku').click(function(){
         if($(this).val() == "") {
             $('#kode_buku').blur();
             show_dialog('id_buku');
         }  
    });

    $('.nim').click(function(){
         if($(this).val() == "") {
             $('.nim').blur();
             show_dialog_nim('nim');
         }  
    });

function search_cari(){
    $("#kotak_pencarian").html(' <div class="mt-3 text-center"><button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Mencari Data... </button></div>');
    v_id_buku = $("#search_nama_table").val();
    v_target = $("#target").val();
    console.log(" judul_buku " + v_id_buku);
    $.ajax({
        url : '<?php echo site_url(strtolower($controller)."/cari_buku"); ?>',
        type : "post",
        data : {judul_buku  : v_id_buku, target : v_target },
        success : function(html) {

            $("#kotak_pencarian").html(html);
        }
    });
}

function search_cari_nim(){
    $("#kotak_pencarian_nim").html(' <div class="mt-3 text-center"><button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Mencari Data... </button></div>');
    v_nim = $("#search_nim_table").val();
    v_target_nim = $("#target_nim").val();
    console.log(" nim " + v_nim);
    $.ajax({
        url : '<?php echo site_url(strtolower($controller)."/cari_nim"); ?>',
        type : "post",
        data : {nim  : v_nim, target_nim : v_target_nim },
        success : function(html) {

            $("#kotak_pencarian_nim").html(html);
        }
    });
}

function pilih(v_id_buku, v_id_buku, target) {
    console.log(v_id_buku + v_id_buku + target) ;
    $(target).val(v_id_buku);
        $("#detail").fadeIn();
        $("#kode_buku").focus();
        $('#modal_buku').modal('hide');
        $(".range_awal").show();
        $("#btnshownim").show();
} 

function pilih_nim(v_nim, v_nim, target_nim) {
    console.log(v_nim + v_nim + target_nim) ;
    $(target_nim).val(v_nim);
        $("#detail_nim").fadeIn();
        $("#nim").focus();
        $('#modal_nim').modal('hide');
} 

function load_buku(){
    $("#isi_detail").html('<div class="mt-3 text-center"><button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Sedang Menampilkan Data...Mohon Ditunggu </button></div>');
        $.ajax({
            url : '<?php echo site_url(strtolower($controller)."/get_data_parent"); ?>',
            data : { id_buku : $("#id_buku").val() }, 
            type : 'post', 
            dataType : 'json',
            success : function(obj) {
                $("#isi_detail").hide();
                $("#kode_buku").val(obj.kode_buku);
                $("#kode_bukuc").html(obj.kode);
                $("#judul_buku").text(obj.judul_buku);
                $("#judul_bukuc").text(obj.judul_buku);
                $("#nama_penerbit").text(obj.nama_penerbit);
                $("#nama_pengarang").text(obj.nama_pengarang);
                $("#tahun_terbit").text(obj.tahun_terbit);
            }
        });
}

$("#kode_buku").focus(function(){
        $("#isi_detail").html('<div class="mt-3 text-center"><button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Sedang Menampilkan Data...Mohon Ditunggu </button></div>');
        $.ajax({
            url : '<?php echo site_url(strtolower($controller)."/get_data_parent"); ?>',
            data : { id_buku : $("#id_buku").val() }, 
            type : 'post', 
            dataType : 'json',
            success : function(obj) {
                $("#isi_detail").hide();
                $("#kode_buku").val(obj.kode_buku);
                $("#kode_bukuc").html(obj.kode);
                $("#judul_buku").text(obj.judul_buku);
                $("#judul_bukuc").text(obj.judul_buku);
                $("#nama_penerbit").text(obj.nama_penerbit);
                $("#nama_pengarang").text(obj.nama_pengarang);
                $("#tahun_terbit").text(obj.tahun_terbit);
            }
        });
     
     });
  
function load_nim(){
    $("#isi_detail_nim").html('<div class="mt-3 text-center"><button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Sedang Menampilkan Data...Mohon Ditunggu </button></div>');
        $.ajax({
            url : '<?php echo site_url(strtolower($controller)."/get_data_parent_nim"); ?>',
            data : { nim : $("#nim").val() }, 
            type : 'post', 
            dataType : 'json',
            success : function(obj) {
                $("#isi_detail_nim").hide();
                $("#nim").val(obj.nim);
                $("#nimx").text(obj.nim);
                $("#nama_lengkap").html(obj.nama_lengkap);
                $("#nama_lengkapx").text(obj.nama_lengkap);
                $("#nama_fakultas").text(obj.nama_fakultas);
                $("#nama_jurusan").text(obj.nama_jurusan);
                $("#nama_prodi").text(obj.nama_prodi);
                $("#angkatan").text(obj.angkatan);
                $("#no_telp").text(obj.no_telp);
                $("#email").text(obj.email);

            }
        });
}

$("#nim").focus(function(){
        $("#isi_detail_nim").html('<div class="mt-3 text-center"><button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Sedang Menampilkan Data...Mohon Ditunggu </button></div>');
        $.ajax({
            url : '<?php echo site_url(strtolower($controller)."/get_data_parent_nim"); ?>',
            data : { nim : $("#nim").val() }, 
            type : 'post', 
            dataType : 'json',
            success : function(obj) {
                $("#isi_detail_nim").hide();
                $("#nim").val(obj.nim);
                $("#nimx").text(obj.nim);
                $("#nama_lengkap").html(obj.nama_lengkap);
                $("#nama_lengkapx").text(obj.nama_lengkap);
                $("#nama_fakultas").text(obj.nama_fakultas);
                $("#nama_jurusan").text(obj.nama_jurusan);
                $("#nama_prodi").text(obj.nama_prodi);
                $("#angkatan").text(obj.angkatan);
                $("#no_telp").text(obj.no_telp);
                $("#email").text(obj.email);

            }
        });
     
     });  
</script>
