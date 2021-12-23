<style type="text/css">
    /*.dataTables_filter input { width: 500px !important; height: 40px !important }*/
    .dataTables_filter {
        display: none; 
    }

</style>
<script type="text/javascript">
    var table;
    $(document).ready(function(){
      
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
                $(".dataTables_filter input").attr("placeholder", "Cari Jurnal");
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
                sInfo           :   "Tampil _START_ -  _END_ dari _TOTAL_ Data",
                sInfoEmpty      :   "Tidak ada",
                sInfoFiltered   :   "(Filter dari _MAX_ Data)",
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
                {"data" : "judul"},
               
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
        $('#myInputTextField').keyup(function(){
            table.search($(this).val()).draw() ;
            // if($(this).val()) {
                $('#hasil').html("Hasil Pencarian : <code>'"+$(this).val()+"'</code>");
           // }  
        })
    });

   

    function reload_table() {
        table.ajax.reload(null,false); 
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

    function view(id) {
        loader();
        $.ajax({
                url : "<?php echo site_url(strtolower($controller).'/view')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#downloads').hide();
                    Swal.close();
                    $('#deskripsix').html(data.file);
                    $('#full-width-modal-des').modal('show'); 
                    $('.mymodal-title').html('<code>'+ data.judul+'</code>'); 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
    }

    function close_modal_des(){
        $("#full-width-modal-des").modal("hide");
    }
    
</script>
