    $().ready(function (){
			$(".ttl_pegawais").keydown(function (e) {
				
				if (checkMaxLength (this.innerHTML, 15)) {
					e.preventDefault();
					e.stopPropagation();
				}

				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 189, 111]) !== -1 ||
					 // Allow: Ctrl/cmd+A
					(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
					 // Allow: Ctrl/cmd+C
					(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
					 // Allow: Ctrl/cmd+X
					(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}

				
					
				
			});

            function checkMaxLength (text, max) {
                return (text.length >= max);
            }


        $("#atas a.skpd").click(function(e) {
            e.preventDefault();
            url =  $(this).attr('href');
            cekLogin(url);
        });

        $(".lanjutkan-mutasi1").click(function(e) {
            e.preventDefault();
			setuju = $(".saya_setuju").is(':checked');
			$(".belum-setuju1").removeClass("alert alert-danger");	

			if(setuju) {
				$(".belum-setuju1").removeClass("alert alert-danger");
				$(".login").show();
				$(".persetujuan").hide();
				$(".persetujuan-modal-title").html("Login Sinaga");
			} else {
				$(".belum-setuju1").addClass("alert alert-danger");

			}

            //lanjutMutasi1($('.nip_pegawai').val(),$('.ttl_pegawai').val(), url);
		});

        $(".lanjutkan-mutasi2").click(function(e) {
			$(this).attr("disabled","disabled");
            e.preventDefault();
			nip = $(".nip_pegawai").val();
			ttl = $(".ttl_pegawai").val();
			nipLogin(nip,ttl,url);
		});
		

        $(".kembali-mutasi1").click(function(e) {
				$(".login").hide();
				$(".persetujuan").show();
				$(".persetujuan-modal-title").html("Halaman Persetujuan");

		});

		$(".saya_setuju").click(function(e) {
			setuju = $(".saya_setuju").is(':checked');
			if(setuju) {
				$(".belum-setuju1").removeClass("alert alert-danger");				
			}
		});

    });
    
	function cekLogin(url){
		$.ajax({
			type: "POST",
			url: 'apps/app_mutasi/controller/cek_login.php',
			data: 'url='+url,
			cache: false,
			async: false,
			success: function(result) {
				if(result == 0)
					showPopLogin();
				else if(result == 1)
					window.location = url;
			},
			error: function(result) {
                
				
			}
		});
    }
    
	function nipLogin(nip,ttl,url){
		$.ajax({
			type: "POST",
			url: 'apps/app_mutasi/controller/login_nip.php',
			data: 'nip='+nip+'&ttl='+ttl,
			cache: false,
			async: false,
			success: function(result) {				
				console.log(result);
				if(result == 0) {					
					$(".lanjutkan-mutasi2").removeAttr("disabled");
					$(".login_gagal").show();
				}
				else if(result == 1)
					window.location = url;
                
			},
			error: function(result) {
				
			}
		});
	}
	
	
    function showPopLogin() {
        $('#LoginPegawai').modal('show');
	}

	

