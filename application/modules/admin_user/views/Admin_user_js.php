<script type="text/javascript">
    var table;
    $(document).ready(function(){
        $('#id_fakultas,#id_jurusan,#id_prodi').select2();

        $('#id_fakultas,#id_jurusan,#id_prodi').select2({
            dropdownParent: $('#full-width-modal')
        });
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
                sSearch         :   "<i class='ti-search'></i> Cari <?php echo $subtitle ?> :",
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
                {"data": "id","orderable": false},
                {"data": "nim","orderable": false},
                {"data": "nama_lengkap"}, 
               
                {"data": "no_telp"}, 
                {"data": "email"}, 
                {"data": "nama_fakultas"}, 
                {"data": "nama_jurusan"}, 
                {"data": "nama_prodi"}, 
                {"data": "angkatan"}, 
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

    function refresh(){
        reload_table();
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


    function pub(id){
        loader();
        $.ajax({
            type: "POST",
            url : "<?php echo site_url(strtolower($controller).'/pub')?>/" + id,
            cache : false,
            dataType: "json",
            success: function(result) {
                Swal.close();
                reload_table();
                if(result.success == false){
                    // Swal.fire(result.title,result.pesan, "error");
                    return false;
                } else {
                    // Swal.fire(result.title,result.pesan, "success");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }

    

    function add(){ 
        $('#form_app')[0].reset(); 
        $('#usernamex').show();
        save_method = 'add';
        $("#add_member").show();
        $('#id_fakultas').val("").trigger('change');
        $('#id_jurusan').val("").trigger('change');
        $('#id_prodi').val("").trigger('change');
        $('#full-width-modal').modal('show'); 
        $('.mymodal-title').text('Invite User '); 
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
                    Swal.close();
                    $('#usernamex').hide();
                    $('#pass1').html("biarkan kosong jika tidak ingin mengganti");
                    $('#pass2').html("biarkan kosong jika tidak ingin mengganti");
                    $('#username').val(data.username);
                    $('#nim').val(data.nim);
                    $('#nama_lengkap').val(data.nama_lengkap);
                    $('#no_telp').val(data.no_telp);
                    $('#email').val(data.email);
                    $('#alamat').val(data.alamat);
                    $('#angkatan').val(data.angkatan);
                    $('#id_fakultas').val(data.id_fakultas).trigger('change');
                    $('#id_jurusan').val(data.id_jurusan).trigger('change');
                    $('#id_prodi').val(data.id_prodi).trigger('change');
                    $('#full-width-modal').modal('show'); 
                    $('.mymodal-title').html('Edit Data <code>'+ data.nama_prodi+'</code>'); 
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
                Swal.fire({   
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
                    confirmButtonClass: "btn btn-confirm mt-2",
                    showCancelButton: false,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ok",
                    cancelButtonText: "Batal",
                    allowOutsideClick: false,

                }).then((result) => {
                    if (result.value) {
                        reload_table()
                        // document.location.href = "<?php echo site_url(strtolower($controller)."/detail_profil/") ?>" + obj.id;
                    } else {
                    // $('#summernote').summernote("insertImage", src);
                }
                })

               
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

    function pdf() {
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        if(list_id.length == 1) { 
            window.open("<?php echo site_url(strtolower($controller)."/pdf/") ?>"+list_id)
        } else if (list_id.length >= 2) {
            Swal.fire("Info","Tidak dapat Mencetak "+list_id.length+" data sekaligus, Pilih satu data saja", "warning");
        } else {
            Swal.fire("Info","Pilih Satu Data", "warning");
        }
    }

     function bio() {
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        if(list_id.length == 1) { 
            window.open("<?php echo site_url(strtolower($controller)."/biodata/") ?>"+list_id)
        } else if (list_id.length >= 2) {
            Swal.fire("Info","Tidak dapat Mencetak "+list_id.length+" data sekaligus, Pilih satu data saja", "warning");
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

    function det(id){
        document.location.href = "<?php echo site_url(strtolower($controller)."/detail_profil/") ?>" + id;
    }

    $(document).ready(function(){
        $('#id_fakultas').change(function(){
            $('#loading').html("Loading...");
            var id=$(this).val();
            $.ajax({
                url:'<?php echo site_url(strtolower($controller)."/get_jurusan"); ?>',
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    html += '<option value = "">== Pilih Jurusan == </option>';
                    for(i=0; i<data.length; i++){
                        html += '<option value = "'+data[i].id_jurusan+'">'+data[i].nama_jurusan+'</option>';
                    }
                    $('#id_jurusan').html(html);
                    $('#loading').hide();
                }
            });
        });

        $('#id_jurusan').change(function(){
            $('#loading').html("Loading...");
            var id=$(this).val();
            $.ajax({
                url:'<?php echo site_url(strtolower($controller)."/get_prodi"); ?>',
                method : "POST",
                data : {id: id},
                async : false,
                dataType : 'json',
                success: function(data){
                    var html = '';
                    var i;
                    html += '<option value = "">== Pilih Program studi == </option>';
                    for(i=0; i<data.length; i++){
                        html += '<option value = "'+data[i].id_prodi+'">'+data[i].nama_prodi+'</option>';
                    }
                    $('#id_prodi').html(html);
                    $('#loading').hide();
                }
            });
        });
    });
    $(document).on('keypress', ':input:not(textarea):not([type=submit])', function (e) {
        if (e.which == 13) e.preventDefault();
    });
    
</script>
