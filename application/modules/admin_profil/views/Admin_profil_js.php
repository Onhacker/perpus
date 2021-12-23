<script type="text/javascript">
    $(document).ready(function(){
        load_profil();
        $('.dropify').dropify();
        $('.form-checkbox').click(function(){
            if($(this).is(':checked')){
                $('#password_lama').attr('type','text');
                $('#password_baru').attr('type','text');
                $('#password_baru_lagi').attr('type','text');
            }else{
                $('#password_lama').attr('type','password');
                $('#password_baru').attr('type','password');
                $('#password_baru_lagi').attr('type','password');
            }
        });

    });

    function validasiFile(){
            var inputFile = document.getElementById('foto');
            var pathFile = inputFile.value;
            var ekstensiOk = /(\.jpg|\.jpeg|\.png|\.gif|\.ico)$/i;
            // var ekstensiOk = /(\.on)$/i;
            if(!ekstensiOk.exec(pathFile)){
                Swal.fire({
                    type: "error",
                    title: "File tidak diterima",
                    text: "Silakan upload file gambar yang memiliki ekstensi .jpg/.jpeg/.png/.gif/.ico",
                    confirmButtonClass: "btn btn-confirm mt-2",
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
                inputFile.value = '';
                return false;
            } else {
                return true;
            }
    }   

    function load_profil(){
        $("#loader").show();
        $("#bg-pr").hide();
        $.ajax({
            url : " <?php echo site_url(strtolower($controller)."/load_profil/") ?>",
            cache:false,
            type : "GET",
            dataType : "json",
            success : function(result){
                $("#loader").hide();
                $("#bg-pr").show();
                $("#nama").text(result.nama_lengkap);
                $("#nama_profil").text(result.nama_lengkap);
                $("#lev").text(result.username);
                $("#telp").text(result.no_telp);
                $("#em").text(result.email);
                $("#tanggal_reg").text(result.tanggal_reg);
                $('#foto_profil').attr('src', '<?php echo base_url("upload/users/") ?>' + result.foto);
            }
        })
    }
    
    function update(){
        $('#form_app').form('submit',{
            url: '<?php echo site_url($this->uri->segment(1)."/update") ?>',
            onSubmit: function(){
                Swal.fire({
                    title: "Updating...",
                    html: "Jangan tutup halaman ini",
                    allowOutsideClick: false,
                    onBeforeOpen: function() {
                        Swal.showLoading()
                    },
                    onClose: function() {
                        clearInterval(t)
                    }
                })
                //loader
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
                    load_profil();
                    Swal.fire({
                        title: obj.title,  
                        html: obj.pesan,   
                        type: "success",
                        allowOutsideClick: false,
                        confirmButtonClass: "btn btn-confirm mt-2"
                    })
                }
            }
        });
    }

    function update_pass(){
        $('#form_pass').form('submit',{
            url: '<?php echo site_url($this->uri->segment(1)."/update_pass") ?>',
            onSubmit: function(){
                Swal.fire({
                    title: "Updating...",
                    html: "Jangan tutup halaman ini",
                    allowOutsideClick: false,
                    onBeforeOpen: function() {
                        Swal.showLoading()
                    },
                    onClose: function() {
                        clearInterval(t)
                    }
                })
                //loader
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
                    $("#password_lama").val("");
                    $("#password_baru").val("");
                    $("#password_baru_lagi").val("");
                    Swal.fire({
                        title: obj.title,  
                        html: obj.pesan,   
                        type: "success",
                        allowOutsideClick: false,
                        confirmButtonClass: "btn btn-confirm mt-2"
                    })
                }
            }
        });
    }

    function home(){
        window.location.href="<?php echo site_url("admin_profil/reload") ?>";
    }

    // $(window).bind('beforeunload', function(){
    //   return 'Are you sure you want to leave?';
    // });
    
</script>
