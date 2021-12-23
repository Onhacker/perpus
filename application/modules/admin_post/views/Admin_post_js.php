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
                {"data": "judul"}, 
                {"data": "kategori"}, 
                {"data": "tanggal"}, 
                {"data": "judul_seo"},
                <?php if($this->session->userdata("admin_level") == "admin"){?>
                {"data": "penulis"},
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

    function reset(){
        $('#summernote').summernote('reset');
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

    function load_tag(){
        var list_id = [];
        $(".data-check:checked").each(function() {
            list_id.push(this.value);
        });
        $.ajax({
            url :'<?php echo site_url(strtolower($controller)."/load_tag/"); ?>'+list_id,
            success: function(result){
                $('#load_tag').html(result);
            },
        });
    }

    function load_you(){
        $("#loader_video").show();
        var str = $("#youtube").val();
        var rec = str.substring(0,17);
        var rep = str.substring(17);
        if (rec == "https://youtu.be/") {
            var you = '<iframe src="https://www.youtube.com/embed/'+rep+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            $('#video_modal').modal('show'); 
            $('.video-title').html('Preview Video <code>'+ rec+''+rep +'</code>'); 
            $('#load_you').html(you);
            $("#loader_video").hide();
        } else {
            // $("#loader_video").show();
            $('#video_modal').modal('show'); 
            $('.video-title').html('Preview Video <code>'+ rec+''+rep +'</code>'); 
            $('#load_you').html("Video tidak dapat dimuat. ada kesalahan. Masukkan link youtbe dengan benar.<ol><li>Cara Pertama <ol> <li>Buka Video Yotube </li> <li>Klik Kanan Pada Video Yotube </li> <li> Pilih Salin Url Video </li> </ol></li> <li> Cara Kedua <ol> <li> Buka Video Yotube </li> <li> Klik Bagikan </li> <li> Klik Tombol Salin </li>  </ol> </li> </ol>");
        }  
    }

    function hapus_gambar_thumb() {
        list_id = $("#id_berita").val();
        Swal.fire({
            title: "Yakin ingin menghapus ?",
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
                    url : "<?php echo site_url(strtolower($controller).'/hapus_gambar')?>/" + list_id,
                    cache : false,
                    dataType: "json",
                    success: function(result) {
                        $('#previewImage').attr('src', '<?php echo base_url("upload/gambar/upload-here.png") ?>');
                        $("#hapus_gambar").hide();
                        $("#text_upload").hide();
                        $("#gambar").val("");
                        Swal.close();
                        if(result.success == false){
                            Swal.fire(result.title,result.pesan, "success");
                            return false;
                        } else {
                            Swal.fire(result.title,result.pesan, "success");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#previewImage').attr('src', '<?php echo base_url("upload/gambar/upload-here.png") ?>');
                        $("#hapus_gambar").hide();
                        $("#text_upload").hide();
                        $("#gambar").val("");
                        Swal.fire("Berhasil","Gambar Berhasil dihapus", "success");
                    }
                });
            } else {
                // $('#summernote').summernote("insertImage", src);
            }
        })
    }

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function add(){ 
        $('#form_app')[0].reset(); 
        save_method = 'add';
        $.ajax({
            url :'<?php echo site_url(strtolower($controller)."/load_tag_add/"); ?>',
            success: function(result){
                $('#load_tag').html(result);
            },
        });
        reset();

        var d = new Date();
        var n = addZero(d.getHours());
        var m = addZero(d.getMinutes());
        var s = addZero(d.getSeconds());
        $("#tanggal").datepicker("setDate",d);
        $("#jam").val(n+':'+m+':'+s );
        $('#previewImage').attr('src', '<?php echo base_url("upload/gambar/upload-here.png") ?>');
        $("#hapus_gambar").hide();
        $("#text_upload").hide();
        
        $('#id_berita').val("");
        $('#full-width-modal').modal('show'); 
        $('.mymodal-title').text('Tambah Data'); 
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
                    load_tag();
                    $('#id_berita').val(data.id_berita);
                    $('#judul').val(data.judul);
                    $('#sub_judul').val(data.sub_judul);
                    $('#id_kategori').val(data.id_kategori);
                    $('#tanggal').val(data.tanggal);
                    $('#youtube').val(data.youtube);
                    $('#headline').val(data.headline);
                    $('#pilihan').val(data.pilihan);
                    $('#utama').val(data.utama);
                    $('#keterangan_gambar').val(data.keterangan_gambar);
                    $('#jam').val(data.jam);

                    if(data.gambar == ""){
                        $('#previewImage').attr('src', '<?php echo base_url("upload/gambar/upload-here.png") ?>');
                        $("#hapus_gambar").hide();
                        $("#text_upload").hide();
                    } else {
                        $('#previewImage').attr('src', '<?php echo base_url("upload/gambar/") ?>' + data.gambar);
                        $("#hapus_gambar").show();  
                        $("#text_upload").show();
                    }
                    $('#summernote').summernote('code', data.isi_berita);
                    $('#full-width-modal').modal('show'); 
                    $('.mymodal-title').html('Edit Data <code>'+ data.judul+'</code>'); 
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

    function simpan(sta){
        var url;
        if(save_method == 'add') {
            url = "<?php echo site_url(strtolower($controller).'/add')?>/"+sta;
        } else {
            url = "<?php echo site_url(strtolower($controller).'/update')?>/"+sta;
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


    function add_tag() {
        list_id = $("#tag_val").val();
        $.ajax({
            type: "POST",
            url : "<?php echo site_url(strtolower($controller).'/add_tag')?>/",
            data: {id:list_id},
            cache : false,
            dataType: "json",
            success: function(result) {
                $("#tag_val").val("");
                if(result.success == false){
                    Swal.fire(result.title,result.pesan, "error");
                    return false;
                } else {
                    if (save_method == "add") {
                        $.ajax({
                            url :'<?php echo site_url(strtolower($controller)."/load_tag_add/"); ?>',
                            success: function(result){
                                $('#load_tag').html(result);
                            },
                        });
                    } else {
                        load_tag();
                    }
                    
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(list_id);
            }
        });
    }

    function hapus_tag(id) {
       Swal.fire({
           title: "Yakin ingin menghapus data Tag ini ?",
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
               $.ajax({
                   type: "POST",
                   url : "<?php echo site_url(strtolower($controller).'/hapus_tag')?>/"+id,
                   cache : false,
                   dataType: "json",
                   success: function(result) {
                      $("#tag_val").val("");
                       if(result.success == false){
                           Swal.fire(result.title,result.pesan, "error");
                           return false;
                       } else {
                            if (save_method == "add") {
                                $.ajax({
                                    url :'<?php echo site_url(strtolower($controller)."/load_tag_add/"); ?>',
                                    success: function(result){
                                        $('#load_tag').html(result);
                                    },
                                });
                            } else {
                                load_tag();
                            }   
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

    function previewImage_click() {
        document.getElementById("previewImage").style.display = "block";
        nama_file = $("#gambar").val();  
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("gambar").files[0]);
        oFReader.onload = function(oFREvent) {
            document.getElementById("previewImage").src = oFREvent.target.result;
            $("#text_upload").show();
            $("#hapus_gambar").show();  

        };
      };

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
    
</script>
