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
                "url": "<?php echo site_url(strtolower($controller)."/get_data_riwayat")?>", 
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
                // {"data": "cek","orderable": false},
                {"data": "id","orderable": false},
                {"data": "no_kia"}, 
                {"data": "nama"}, 
                {"data": "jk"},
                {"data": "ttl"},
                {"data": "desa"},
                {"data": "nama_ibu"},
                
                <?php if ($this->session->userdata("admin_level") == "admin") {?>
                    {"data": "pkm"},
                <?php } ?>
               {"data": "cetak", "orderable" : false},
            ],

            "order": [],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index); // masukkan index untuk menampilkan no urut
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
        $('#form_app')[0].reset(); 
        reset_select();
        $("#detail").hide();
        $('#id_imunisasi').val("");
        $('#id_anak').val("");
        $('#full-width-modal').modal('show'); 
        $('.mymodal-title').text('Tambah Data'); 
    }

    
    function cetak() {
            window.open("<?php echo site_url(strtolower($controller)."/pdf_riwayat/") ?>"+list_id)
    }

    function cetakx() {
        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        if(list_id.length == 1) { 
            window.open("<?php echo site_url(strtolower($controller)."/pdf_riwayat/") ?>"+list_id)
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
