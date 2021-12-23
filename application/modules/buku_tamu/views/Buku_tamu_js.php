<script type="text/javascript">
    $(document).ready(function() {
        $('form').bind("keypress", function(e) {
            if (e.keyCode == 13) {               
                e.preventDefault();
                return false;
            }
        });
    });

    function modal(){
        $("#md").modal("show");
    }
    
    function send(){
        $('#form_app').form('submit',{
            url: '<?php echo site_url("buku_tamu/send") ?>',
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
                    $('#Capctha').text(obj.new);
                    swal.fire({   
                        title: obj.title,   
                        type: "error", 
                        html: obj.pesan,
                        allowOutsideClick: false,
                        confirmButtonClass: "btn btn-confirm mt-2"   
                    });
                    return false;
                } else {
                    $('#form_app')[0].reset(); 
                    $('#Capctha').text(obj.new);
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
        window.location.href="<?php echo site_url() ?>";
    }

 
</script>

