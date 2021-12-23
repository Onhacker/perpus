<script type="text/javascript">
    var table;
    $(document).ready(function(){
       
        
        $("#komorbid").change(function(){
            if($(this).val() == "1") {
                $(".komorbid_detail").show();
            }
            else {
                $(".komorbid_detail").hide();
            }
        });
        // var startDate = new Date(); // Now
        // var endDate = new Date();
        // endDate.setDate(startDate.getDate() + 0); // Set now + 30 days as the new date
        // $('#tgl_suntik').datepicker('setEndDate', endDate);//1st set  end date
        $('#tahun_cari,#id_pkm,#bulan_cari').select2();
        $('#id_detail_pekerjaan').select2({
            dropdownParent: $('#full-width-modal')
        });
        // $("#tgl_lahir").datepicker({minDate:"2020-01",maxDate:"2020-03"})
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
                "url": "<?php echo site_url(strtolower($controller)."/get_data_covid")?>", 
                "type": "POST",
                "data": function ( data ) {
                data.nama = $('#nama_cari').val();
                data.no_kia = $('#no_kia_cari').val();
                data.tahun = $('#tahun_cari').val();
                data.bulan = $('#bulan_cari').val();
                data.id_pkm = $('#id_pkm').val();
                }
            },


            columns: [
                {"data": "cek","orderable": false},
                {"data": "id","orderable": false},
                {"data": "nik","orderable": false},
                {"data": "nama"}, 
                {"data": "jk"},
                {"data": "ttl"},
                {"data": "alamat"},
                {"data": "no_hp"},
                {"data": "tgl_suntik"},
                
                <?php if ($this->session->userdata("admin_level") == "admin") {?>
                    {"data": "pkm"},
                <?php } ?>
               
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

        $('#btn-filter').click(function(){ //button filter event click
           reload_table()  //just reload table
        });
        $('#btn-reset').click(function(){ //button reset event click
            $('#form-filter')[0].reset();
            reset_select();
            reload_table(); //just reload table
        });
    });

     function load_profil(){
        $.ajax({
            url : " <?php echo site_url(strtolower($controller)."/get_data/") ?>",
            cache:false,
            type : "POST",
             data : function ( data ) {
                data.id_desa = $('#id_desa_cari').val();
                data.nama = $('#nama_cari').val();
                data.no_kia = $('#no_kia_cari').val();
                data.jk = $('#jk_cari').val();
                },
            dataType : "json",
            success : function(result){
                $("#nama_f").text("Nama "+result.nama);
            }
        })
    }
    

    function reload_table() {
        table.ajax.reload(null,false); 
    }

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    function reset_select(){
        $('#id_pekerjaan,#id_pkm,#tahun_cari,#bulan_cari,#id_detail_pekerjaan').val('').trigger('change');
    }

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
        save_method = 'add';
        $('#tgl_suntik,#tgl_lahir').datepicker({
          format: 'dd-mm-yyyy',
        });
        $(".komorbid_detail").hide();
        $('#Hipertensi').prop("checked", false);
        $('#Diabetes').prop("checked", false);
        $('#Jantung').prop("checked", false);
        $('#Ginjal').prop("checked", false);
        $('#Paru').prop("checked", false);
        $('#Lainnya').prop("checked", false);
        $('#form_app')[0].reset(); 
        reset_select();
        $('#id_imunisasi_coivd').val("");
        $('#full-width-modal').modal('show'); 
        $('.mymodal-title').text('Tambah Data'); 
    }

    function edit() {
        $('#form_app')[0].reset(); 
        reset_select();
        loader();
        var list_id = [];
        $(".data-check:checked").each(function() {
            list_id.push(this.value);
        });
  
        if(list_id.length == 1) { 
            save_method = 'update';
            $.ajax({
                url : "<?php echo site_url(strtolower($controller).'/edit_covid')?>/" + list_id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    Swal.close();
                    $('#tgl_suntik,#tgl_lahir').datepicker({
                      format: 'dd-mm-yyyy',

                    });
                    $('#id_imunisasi_covid').val(data.id_imunisasi_covid);
                    $("#nama").val(data.nama);
                    $("#no_kia").val(data.no_kia);
                    $("#jk").val(data.jk);
                    $("#no_hp").val(data.no_hp);
                    $("#alamat").val(data.alamat);
                    $("#bpjs").val(data.bpjs);
                    $("#tempat_imunisasi").val(data.tempat_imunisasi);
                    $('#tgl_lahir').val(data.tgl_lahir);
                    $('#id_pekerjaan').val(data.id_pekerjaan);
                    $('#tgl_suntik').val(data.tgl_suntik);
                    $('#id_detail_pekerjaan').val(data.id_detail_pekerjaan).trigger('change');
                    $('#komorbid').val(data.komorbid);
                    $('#tempat_pelayanan').val(data.tempat_pelayanan);
                    if(data.komorbid == "1") {
                        $(".komorbid_detail").show();
                    }
                    else {
                        $(".komorbid_detail").hide();
                    }
                    if (data.hipertensi == "1") {
                        $('#Hipertensi').prop("checked", true);
                            
                    }

                    if (data.diabetes == "1") {
                        $('#Diabetes').prop("checked", true);
                    }
                    if (data.jantung == "1") {
                        $('#Jantung').prop("checked", true);
                    }
                    if (data.ginjal == "1") {
                        $('#Ginjal').prop("checked", true);
                    }
                    if (data.paru == "1") {
                        $('#Paru').prop("checked", true);
                    }
                    if (data.lainnya == "1") {
                        $('#Lainnya').prop("checked", true);
                    }
                    $('#full-width-modal').modal('show'); 
                    $('.mymodal-title').html('Edit Data <code>'+ data.nama+'</code>'); 
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
            url = "<?php echo site_url(strtolower($controller).'/add_covid')?>";
        } else {
            url = "<?php echo site_url(strtolower($controller).'/update_covid')?>";
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
                        url : "<?php echo site_url(strtolower($controller).'/hapus_data_covid')?>/",
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
        if(list_id.length == 1) { 
            window.open("<?php echo site_url(strtolower($controller)."/pdf_covid/") ?>"+list_id)
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


    <?php if ($this->session->userdata("admin_level") == "admin") {?>
        function get_desa(id,target,dropdown){
            $("#loading").html('Loading data....');
            console.log('id kecamatan' + $(id).val() );
            $.ajax({
                url:'<?php echo site_url(strtolower($controller)."/get_desa"); ?>/'+$(id).val()+'/'+dropdown,
                success: function(data){
                    $("#loading").hide();
                    $(target).html('').append(data);
                }
            });
        }
   <?php  } ?>
   

</script>