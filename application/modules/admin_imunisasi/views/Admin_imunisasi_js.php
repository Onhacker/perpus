<script type="text/javascript">
    var table;
    $(document).ready(function(){
        $('#tgl_suntik').datepicker({
          format: 'dd-mm-yyyy',
         
        });
        // var startDate = new Date(); // Now
        // var endDate = new Date();
        // endDate.setDate(startDate.getDate() + 0); // Set now + 30 days as the new date
        // $('#tgl_suntik').datepicker('setEndDate', endDate);//1st set  end date

        $('#id_desa_cari,#tahun_cari,#id_pkm,#jenis_vaksin,#bulan,#bulan_cari,#jenis_vaksin_form').select2();

        $('#id_agama,#id_desa,#id_pekerjaan_ayah,#id_pekerjaan_ibu').select2({
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
                "url": "<?php echo site_url(strtolower($controller)."/get_data")?>", 
                "type": "POST",
                "data": function ( data ) {
                data.id_desa = $('#id_desa_cari').val();
                data.nama = $('#nama_cari').val();
                data.no_kia = $('#no_kia_cari').val();
                data.tahun = $('#tahun_cari').val();
                data.bulan = $('#bulan_cari').val();
                data.id_pkm = $('#id_pkm').val();
                data.jenis_vaksin = $('#jenis_vaksin_form').val();
                data.jk = $('#jk_cari').val();
                }
            },


            columns: [
                {"data": "cek","orderable": false},
                {"data": "id","orderable": false},
                {"data": "no_im"},
                // {"data": "no_kia"}, 
                
                // {"data": "nama"}, 
                {"data": "jk"},
                {"data": "nama_ibu"},
                {"data": "ttl"},
                {"data": "tgl_suntik"},
                {"data": "ber","orderable" : false},
                // {"data": "do","orderable" : false},
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
        $('#id_agama,#id_desa,#id_pekerjaan_ayah,#id_pekerjaan_ibu,#id_desa_cari,#id_pkm,#jenis_vaksin,#bulan_cari,#jenis_vaksin_form').val('').trigger('change');
        // $('#bulan').val(<?php echo date("m"); ?>).trigger('change');
        $('#tahun').val(<?php echo date("Y"); ?>).trigger('change');
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
        $('#jenis_vaksin').select2({
            dropdownParent: $('#full-width-modal')
        });
        $('#form_app')[0].reset(); 
        reset_select();
        $("#detail").hide();
        $('#id_imunisasi').val("");
        $('#id_anak').val("");
        $('#full-width-modal').modal('show'); 
        $('.mymodal-title').text('Tambah Data'); 
    }

    function edit() {
        $('#jenis_vaksin').select2({
            dropdownParent: $('#full-width-modal')
        });
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
                url : "<?php echo site_url(strtolower($controller).'/edit')?>/" + list_id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    Swal.close();
                    $('#id_anak').val(data.id_anak);
                    $('#id_imunisasi').val(data.id_imunisasi);
                    $("#detail").show();
                    // $("#isi_detail").show();
                    $("#nama").val(data.nama);
                    $("#namac").text(data.nama);
                    $("#namacc").text(data.nama);
                    $("#no_kia").text(data.no_kia);
                    $("#jk").text(data.jk);
                    $("#golda").text(data.golda);
                    $("#alamat").text(data.alamat);
                    $("#desa").text(data.desa);
                    $("#agama").text(data.agama);
                    $("#ttl").html(data.tempat_lahir+", "+data.tgl_lahir);
                    $("#umur").text(data.umur);
                    $("#nik_ayah").text(data.nik_ayah);
                    $("#nama_ayah").text(data.nama_ayah);
                    $("#pekerjaan_ayah").text(data.pekerjaan_ayah);
                    $("#nik_ibu").text(data.nik_ibu);
                    $("#nama_ibu").text(data.nama_ibu);
                    $("#pekerjaan_ibu").text(data.pekerjaan_ibu);
                    $('#pemberi_imunisasi').val(data.pemberi_imunisasi);
                    $('#tgl_suntik').val(data.tgl_suntik);
                    $('#jenis_vaksin').val(data.jenis_vaksin).trigger('change');
                    // $('#id_desa').val(data.id_desa).trigger('change');
                    $('#tempat_pelayanan').val(data.tempat_pelayanan);
            
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
        if(list_id.length == 1) { 
            window.open("<?php echo site_url(strtolower($controller)."/pdf/") ?>"+list_id)
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
    
function show_dialog(target) {
     $("#kotak_pencarian").html('');
     $("#target").val(target);
     $('#modal_anak').modal('show');
     $('.modal-title-cari').text('Cari Anak'); // Set Title to Bootstrap modal title
} 

$('#nama').click(function(){
     if($(this).val() == "") {
         $('#nama').blur();
         show_dialog('id_anak');
     }  
});

function search_cari(){
    $("#kotak_pencarian").html(' <div class="mt-3 text-center"><button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Mencari Data... </button></div>');
    v_id_anak = $("#search_nama_table").val();
    v_target = $("#target").val();
    console.log(" nama " + v_id_anak);
    $.ajax({
        url : '<?php echo site_url(strtolower($controller)."/cari_anak"); ?>',
        type : "post",
        data : {nama  : v_id_anak, target : v_target },
        success : function(html) {
            $("#ketikan").text(v_id_anak);
            $("#kotak_pencarian").html(html);
        }
    });
}

function pilih(v_id_anak, v_id_anak, target) {
    console.log(v_id_anak + v_id_anak + target) ;
    $(target).val(v_id_anak);
        $("#detail").fadeIn();
        $("#nama" ).focus();
        $('#modal_anak').modal('hide');
} 

$(document).ready(function(){

$("#nama").focus(function(){
        $("#isi_detail").html('<div class="mt-3 text-center"><button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Sedang Menampilkan Data...Mohon Ditunggu </button></div>');
        tgl_s = $("tgl_suntik").val();
        $.ajax({
            url : '<?php echo site_url(strtolower($controller)."/get_data_parent"); ?>',
            data : { id_anak : $("#id_anak").val() }, 
            type : 'post', 
            dataType : 'json',
            success : function(obj) {
                $("#isi_detail").hide();
                $("#nama").val(obj.nama);
                $("#namac").text(obj.nama);
                $("#namacc").text(obj.nama);
                $("#no_kia").text(obj.no_kia);
                $("#jk").text(obj.jk);
                $("#golda").text(obj.golda);
                $("#alamat").text(obj.alamat);
                $("#desa").text(obj.desa);
                $("#agama").text(obj.agama);
                $("#ttl").html(obj.tempat_lahir+", "+obj.tgl_lahir);
                $("#umur").text(obj.umur);
                $("#nik_ayah").text(obj.nik_ayah);
                $("#nama_ayah").text(obj.nama_ayah);
                $("#pekerjaan_ayah").text(obj.pekerjaan_ayah);
                $("#nik_ibu").text(obj.nik_ibu);
                $("#nama_ibu").text(obj.nama_ibu);
                $("#pekerjaan_ibu").text(obj.pekerjaan_ibu);
            }
        });
     
     });
})

</script>