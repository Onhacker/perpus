<script type="text/javascript">
	$(document).ready(function() {
		$("#btn-loader").hide();
		$("#btn-loader-reset").hide();
		$('form').bind("keypress", function(e) {
			if (e.keyCode == 13) {               
				e.preventDefault();
				return false;
			}
		});
		
		$('.form-checkbox').click(function(){
			if($(this).is(':checked')){
				$('#kode').attr('type','text');
			}else{
				$('#kode').attr('type','password');
			}
		});
	});

	function go_login(){
		$("#btn-login").hide();
		$("#btn-loader").show()	;
		$('#frm').form('submit',{
			url: '<?php echo site_url("on_login/ceklogin"); ?>',				 
			success: function(result){
				console.log(result);
				result = result.replace(/\s+/g, " ");
				obj = $.parseJSON(result);
				console.log(obj.pesan);
				if (obj.success == false ){
					$('#Capctha').text(obj.new);
						Swal.fire({
							title: obj.title,   
							text: obj.pesan,
							type: obj.type,   
							confirmButtonClass: "btn btn-confirm mt-2",
								// footer: '<a href="">Why do I have this issue?</a>'
						})
					$("#btn-login").show();
					$("#btn-loader").hide();

				} else {
					location.href='<?php echo site_url("on_login/reload") ?>'

				}
			}
		});
		return false;
	}

	function reset_password(){
		$("#btn-login-reset").hide();
		$("#btn-loader-reset").show();
		$('#reset').form('submit',{
			url: '<?php echo site_url("kmzwa8awaa/reset_password_user"); ?>',				 
			success: function(result){
				console.log(result);
				result = result.replace(/\s+/g, " ");
				obj = $.parseJSON(result);
				console.log(obj.pesan);
				if (obj.success == false ){
					Swal.fire({
						title: obj.title,   
						html: obj.pesan,
						type: obj.type,   
						confirmButtonClass: "btn btn-confirm mt-2",
							// footer: '<a href="">Why do I have this issue?</a>'
						})
					$("#btn-login-reset").show();
					$("#btn-loader-reset").hide();

				} else {
					$("#con-close-modal").modal("hide");
					$("#btn-login-reset").show();
					$("#btn-loader-reset").hide();
					$("#email").val("");
					Swal.fire({
						title: obj.title,   
						html: obj.pesan,
						type: obj.type,   
						confirmButtonClass: "btn btn-confirm mt-2",
							// footer: '<a href="">Why do I have this issue?</a>'
					})
				}
			}
		});
		return false;
	}

</script>