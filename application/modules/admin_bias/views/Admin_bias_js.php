
<script type="text/javascript">
    var table;
    $(document).ready(function(){
        $("#range-datepicker").flatpickr({
            mode:"range",
            dateFormat: "d-m-Y",
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
                sProcessing     :   '<button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Memuat... </button>',
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
            bFilter: false,
            ajax: {
                "url": "<?php echo site_url(strtolower($controller)."/get_data")?>", 
                "type": "POST",
                "data": function ( data ) {
                data.tahun = $('#tahun_select').val();
                }
            },

            columns: [
                <?php if($this->session->userdata("admin_level") != "admin"){?>
                {"data": "cek","orderable": false},
                <?php } ?>
                
                {"data": "id_admin_bias","orderable": false},
                <?php if($this->session->userdata("admin_level") == "admin"){?>
                {"data": "penulis","orderable": false},
                <?php } ?>
                {"data": "tahun"}, 
                {"data": "create_date"},
                {"data": "kelola","orderable": false}, 
                
            ],

            "order": [],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                 <?php if($this->session->userdata("admin_level") != "admin"){?>
                    $('td:eq(1)', row).html(index); // masukkan index untuk menampilkan no urut
                <?php } else {?>
                    $('td:eq(0)', row).html(index); // masukkan index untuk menampilkan no urut
                <?php } ?>
            }
        });
        
        $('#btn-filter').click(function(){ //button filter event click
           reload_table()  //just reload table
        });
        $('#btn-reset').click(function(){ //button reset event click
            $('#form-filter')[0].reset();
            reset_select();
           reload_table(); //just reload table
        });

        $('#id_pkm,#tahun_select,#tahun,#bulan').select2();

    });

    function reload_table() {
        table.ajax.reload(null,false); 
    }
    function reset_select(){
       $('#id_pkm,#tahun_select,#bulan').val('').trigger('change');
    }

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    $(document).ready(function(){
        $(".atas_nama").hide();

        $("#ttd").change(function(){
            if($(this).val() == "lain") {
                $(".atas_nama").fadeIn();
            }
            else {
                $(".atas_nama").fadeOut();
            }
        });
    });

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
        reset_select();
        save_method = 'add';
        // $('#id_tahun_vaksin').val("1");
        $('#full-width-modal').modal('show'); 
        $('.mymodal-title').text('Buat Rekapitulasi Hasil Cakupan BIAS'); 
    }

    function edit() {
        $('#minggu_ke').select2({
            dropdownParent: $('#full-width-modal')
        });
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
                   
                    $('#id_w_dua').val(data.id_w_dua);
                    $('#field_date').show();
                    $('#fiel_minggu_ke').show();

                    $("#minggu_ke").val(data.id_minggu_ke).trigger('change');
                    $('#minggu_ke').val(data.id_minggu_ke);

                    // $('#minggu_ke').val(data.id_minggu_ke);
                    // $('#range-datepicker').val(data.periode);

                    if(data.tanda == "lain"){
                        $('#ttd').val(data.tanda);
                        $(".atas_nama").show();
                        $('#nama_pengelola').val(data.nama_pengelola);
                        $('#nip_pengelola').val(data.nip_pengelola);
                    } 
                    if(data.tanda == "pengelola") {
                        $(".atas_nama").hide();


                    }

                    
                    $('#full-width-modal').modal('show'); 
                    $('.mymodal-title').html('Edit Data laporan Minggu ke <code>'+data.minggu_ke+'  bulan '+data.bulan+' tahun '+data.tahun+'</code>');
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

    function gagal(){
         $.ajax({
            type: "get",
            url : "<?php echo site_url(strtolower($controller).'/gagal')?>/",
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

    function cetak() {
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        if(list_id.length > 0) { 
            window.open("<?php echo site_url(strtolower($controller)."/pdf_laporan/") ?>"+list_id)
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
    
</script>
