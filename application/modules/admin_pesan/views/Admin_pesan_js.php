<script type="text/javascript">
    var table;
    $(document).ready(function(){
        load_jumlah();
        bintangx("N");
        $("#tru").html('<button type="button" onclick="trash()" id="tru" class="btn btn-sm btn-light waves-effect"><i class="fe-trash-2 font-18"></i> Pindahkan ke sampah</button>');
        $('#summernoteadd').summernote({
          toolbar: [
          ['style', ['style']],
          ['font', ['bold','italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph','height']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video','hr']],
          ['view', ['undo','redo','fullscreen', 'codeview', 'help']],
          ],
          dialogsInBody: true,
          lang: 'id-ID',

          height: "300px",
          callbacks: {
              onImageUpload: function(image) {
                  upload_summernote(image[0]);
              },
              onMediaDelete : function(target) {
                  hapus_summernote(target[0].src);
              }
          }
      });
    });

    function bintangx(y){
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
            ajax: {"url": "<?php echo site_url(strtolower($controller)."/get_data/") ?>" + y, "type": "POST"},
            columns: [
                {"data": "cek","orderable": false},
                {"data": "bintang"}, 
                {"data": "nama"}, 
                {"data": "pesan","orderable": false},
                {"data": "waktu"}, 
                
            ],

            "order": [],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                // $('td:eq(0)', row).html(index); // masukkan index untuk menampilkan no urut
            }
        });
    }

    function bintang () {
        $('#datable_1').dataTable().fnClearTable();
        $('#datable_1').dataTable().fnDestroy();
        bintangx("Y");
        $('#bi').attr('class', 'text-danger font-weight-bold');
        $('#ib').attr('class', '');
        $('#tk').attr('class', '');
        $('#lt').attr('class', '');
        $("#kal").text("Berbintang");
        $("#tru").html('<button type="button" onclick="trash()" id="tru" class="btn btn-sm btn-light waves-effect"><i class="fe-trash-2 font-18"></i> Pindahkan ke sampah</button>');
        $("#selamanya").html("");
    }

    function sent () {
        $('#datable_1').dataTable().fnClearTable();
        $('#datable_1').dataTable().fnDestroy();
        bintangx("1");
        $('#tk').attr('class', 'text-danger font-weight-bold');
        $('#bi').attr('class', '');
        $('#ib').attr('class', '');
        $('#lt').attr('class', '');
        $("#kal").text("Terkirim");
        $("#tru").html('<button type="button" onclick="trash()" id="tru" class="btn btn-sm btn-light waves-effect"><i class="fe-trash-2 font-18"></i> Pindahkan ke sampah</button>');
        $("#selamanya").html("");
    }

    function load_trash () {
        $('#datable_1').dataTable().fnClearTable();
        $('#datable_1').dataTable().fnDestroy();
        bintangx("X");
        $('#lt').attr('class', 'text-danger font-weight-bold');
        $('#bi').attr('class', '');
        $('#tk').attr('class', '');
        $('#ib').attr('class', '');
        $("#kal").text("Sampah");
        onclick="hapus_data()"
        $("#tru").html('<button type="button" onclick="hapus_data()" id="tru" class="btn btn-sm btn-light waves-effect"><i class="fe-trash-2 font-18"></i> Hapus selamanya</button>');    
    }

    function inbox () {
        $('#ib').attr('class', 'text-danger font-weight-bold');
        $('#bi').attr('class', '');
        $('#tk').attr('class', '');
        $('#lt').attr('class', '');
        $('#datable_1').dataTable().fnClearTable();
        $('#datable_1').dataTable().fnDestroy();
        bintangx("A");
        $("#kal").text("Inbox");
        $("#selamanya").html("");
    }

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

    function reset(){
        $('#summernote').summernote('reset');
    }

    function trash(){
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        loader();
        $.ajax({
            type: "POST",
            url : "<?php echo site_url(strtolower($controller).'/trash')?>/",
            cache : false,
            data: {id:list_id},
            dataType: "json",
            success: function(result) {
                load_jumlah();
                Swal.close();
                reload_table();
                if(result.success == false){
                    Swal.fire(result.title,result.pesan, "error");
                    return false;
                } else {
                     $.toast({
                        text: result.pesan, // Text that is to be shown in the toast
                        heading: result.title, // Optional heading to be shown on the toast
                        icon: 'info', // Type of toast icon
                        showHideTransition: 'slide', // fade, slide or plain
                        allowToastClose: true, // Boolean value true or false
                        hideAfter: 2000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                        position: 'mid-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                        textAlign: 'left',  // Text alignment i.e. left, right or center
                        loader: true,  // Whether to show loader or not. True by default
                        loaderBg: '#da8609',  // Background color of the toast loader
                        
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }

    function start(id){
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        loader();
        $.ajax({
            type: "POST",
            url : "<?php echo site_url(strtolower($controller).'/start')?>/" + id,
            cache : false,
            dataType: "json",
            success: function(result) {
                load_jumlah();
                Swal.close();
                reload_table();
                if(result.success == false){
                    Swal.fire(result.title,result.pesan, "error");
                    return false;
                } else {
                     $.toast({
                        text: result.pesan, // Text that is to be shown in the toast
                        heading: result.title, // Optional heading to be shown on the toast
                        icon: 'info', // Type of toast icon
                        showHideTransition: 'slide', // fade, slide or plain
                        allowToastClose: true, // Boolean value true or false
                        hideAfter: 2000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                        position: 'mid-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                        textAlign: 'left',  // Text alignment i.e. left, right or center
                        loader: true,  // Whether to show loader or not. True by default
                        loaderBg: '#da8609',  // Background color of the toast loader
                        
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }


    function unstart(id){
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        loader();
        $.ajax({
            type: "POST",
            url : "<?php echo site_url(strtolower($controller).'/unstart')?>/" + id,
            cache : false,
            dataType: "json",
            success: function(result) {
                load_jumlah()
                Swal.close();
                reload_table();
                if(result.success == false){
                    Swal.fire(result.title,result.pesan, "error");
                    return false;
                } else {
                     $.toast({
                        text: result.pesan, // Text that is to be shown in the toast
                        heading: result.title, // Optional heading to be shown on the toast
                        icon: 'info', // Type of toast icon
                        showHideTransition: 'slide', // fade, slide or plain
                        allowToastClose: true, // Boolean value true or false
                        hideAfter: 2000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                        position: 'mid-center', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
                        textAlign: 'left',  // Text alignment i.e. left, right or center
                        loader: true,  // Whether to show loader or not. True by default
                        loaderBg: '#da8609',  // Background color of the toast loader
                        
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }

    function load_jumlah(){
        $.ajax({
            url : "<?php echo site_url(strtolower($controller)."/load_jumlah") ?>",
            type : "GET",
            dataType : "json",
            success : function(res){
                
                $("#jp").text(res.jp);
                $("#jml").text(res.jp);
                $("#btg").text(res.btg);
                $("#snnnt").text(res.sent);
                $("#sp").text(res.trash);
            }
        })
    }

    function add(){ 
        save_method = 'add';
        reset();
        $('#form_appp')[0].reset(); 
        $('#id_hubungi').val("");
        $('#full-width-modal-add').modal('show'); 
        $('.mymodal-title-add').text('Kirim Pesan'); 
    }

    function edit(list_id) {
        loader();
        save_method = 'update';
            $.ajax({
                url : "<?php echo site_url(strtolower($controller).'/edit')?>/" + list_id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    load_jumlah();
                    Swal.close();
                    reload_table();
                    $('#id_hubungi').val(data.id_hubungi);
                    $('#email').html(data.email);
                    $('#subjek').html(data.subjek);
                    $("#pesan").html(data.pesan);
                    $("#tgl_bls").html(data.tgl_bls);
                    $("#waktu").html(data.waktu);
                    $("#jam").html(data.jam);
                    $("#nama").html(data.nama);

                    if (data.terbalas == "1") {
                        $('#sum').hide();
                        $('#balas').show();
                        $('#btn-kirim').hide();
                        $("#balasan").html(data.balasan);
                    } else {
                        $('#balas').hide();
                        $('#btn-kirim').show();
                        $('#sum').show();
                    }
                    if (data.status == "1") {
                        // $("#pesan").hide();
                        $("#pes").hide();
                        $("#text-balas").text("Pesan");
                        $('.mymodal-title').html('Pesan dikirim ke <code>'+ data.nama+'</code>'); 
                    } else {
                        $("#text-balas").text("Balasan");
                        $("#pes").show();
                        
                        $('.mymodal-title').html('Pesan dari <code>'+ data.nama+'</code>'); 
                    }
                    // $('#summernote').summernote('code', data.pesan);
                    $('#full-width-modal').modal('show'); 
                    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
    }

    function simpan(){
        var url;
        if(save_method == 'add') {
            url = "<?php echo site_url(strtolower($controller).'/add')?>";
        } else {
            url = "<?php echo site_url(strtolower($controller).'/update')?>";
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


    function simpan_add(){
        var url;
        if(save_method == 'add') {
            url = "<?php echo site_url(strtolower($controller).'/add')?>";
        } else {
            url = "<?php echo site_url(strtolower($controller).'/update')?>";
        }   

        $('#form_appp').form('submit',{
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

                $("#full-width-modal-add").modal("hide"); 
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
                title: "Yakin ingin menghapus "+list_id.length+" pesan  ?",
                text: "Anda tidak dapat mengembalikan pesan yang terhapus permanent",
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
                            load_jumlah();
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


    function close_modal(){
        Swal.fire({
            title: "Yakin ingin menutup ?",
            text: "Anda tidak dapat mengembalikan data yang belum tersimpan",
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


    function close_modal_add(){
        Swal.fire({
            title: "Yakin ingin menutup ?",
            text: "Anda tidak dapat mengembalikan data yang belum tersimpan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Tutup",
            cancelButtonText: "Batal",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                $("#full-width-modal-add").modal("hide");
            } 
        })
    }



    
</script>
