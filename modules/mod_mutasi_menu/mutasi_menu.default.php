<?php


function mutasi_link($val) {
    if(session('PEGAWAI_SKPD'))
        return "#";
    else
        return make_permalink($val);
}

function skpd_link($val) {
    if(session('PEGAWAI_LAST_DATA'))
        return make_permalink($val);
    else {
        
        return make_permalink($val);
        return "#";
    }
}


$peg = session('PEGAWAI_LAST_DATA');



$data = DB::table(FDBPrefix."mutasi_data")->select("*")->where("nip = '$peg[nip]' AND tgl_lahir ='$peg[tgl_lahir]'")->limit(1)->get();
if($data) {
    $data[0]['kategori'];
}
?><div id="atas"> 
    <div class="container"> 
        <div class="row-fluid"> 

            <a class="span4 warna6" href="<?php echo mutasi_link("?app=mutasi&view=antarkab&act=form"); ?>"> 
                <div class="modules ">
                    <div class="mod-inner" style="">
                        <h3><span>A1</span>Pindah Antar Kabupaten/Kota</h3>
                    </div>
                </div> 
            </a> 
            
            <a class="span4 warna6"  href="<?php echo mutasi_link("?app=mutasi&view=kabskpd&act=form"); ?>">
                <div class="modules ">
                    <div class="mod-inner" style="">
                        <h3><span>A2</span>Pindah Kabupaten/Kota ke&nbsp;SKPD&nbsp; Prov. Jateng</h3>
                    </div>
                </div> 
            </a> 
        
            <a class="span4 warna6"  href="<?php echo mutasi_link("?app=mutasi&view=kabkemen&act=form"); ?>">
                <div class="modules ">
                    <div class="mod-inner" style="">
                        <h3><span>A3</span>Pindah Kabupaten/Kota <br> ke Kementrian/Prov. Lain</h3>
                    </div>
                </div> 
</a> 

        

            
        </div> 

        
        <div class="row-fluid row-menu"> 
            <a class="span4 hijau skpd"  href="<?php echo skpd_link("?app=mutasi&view=antarskpd&act=form"); ?>">
                <div class="modules ">
                    <div class="mod-inner" style="">
                        <h3><span>B1</span>Pindah Antar <br> SKPD  Prov. Jateng</h3>
                    </div>
                </div> 
            </a> 
        
            <a class="span4 hijau skpd"   href="<?php echo skpd_link("?app=mutasi&view=skpdkab&act=form"); ?>">
                <div class="modules "> 
                    <div class="mod-inner" style="">
                        <h3><span>B2</span>Pindah SKPD  Prov. Jateng <br>  ke Kabupaten/Kota</h3>
                    </div>
                </div> 
            </a> 
        
            <a class="span4 hijau skpd"  href="<?php echo skpd_link("?app=mutasi&view=skpdkemen&act=form"); ?>">
                <div class="modules " >
                    <div class="mod-inner" style="">
                        <h3><span>B3</span>Pindah SKPD  Prov. Jateng <br>ke Kementrian/Prov. Lain</h3>
                    </div>
                </div> 
            </a> 

            
        </div> 

         <div class="row-fluid row-menu"> 
            <a class="span4 warna4"  href="<?php echo mutasi_link("?app=mutasi&view=kemenkab&act=form"); ?>">
                <div class="modules ">
                    <div class="mod-inner" style="">
                        <h3><span>C1</span> Kementrian/Prov. Lain <br> ke Kabupaten/Kota<h3>
                    </div>
                </div> 
                </a> 
        
            <a class="span4 warna4" href="<?php echo mutasi_link("?app=mutasi&view=kemenskpd&act=form"); ?>">
                <div class="modules">
                    <div class="mod-inner" style="">
                        <h3><span>C2</span>Kementrian/Prov. Lain <br>ke SKPD  Prov. Jateng</h3>
                    </div>
                </div> 
            </a> 
            <a class="span4 tanya" href="<?php echo mutasi_link("?app=article&view=item&id=236"); ?>">
                <div class="modules " style="    color: #eee;    box-sizing: border-box;    background: #404040; border-radius: 40px;">
                    <div class="mod-inner" style="">
                        <h3><span>?</span>Baca Panduan <br>Pengisian Mutasi </h3>
                    </div>
                </div> 
            </a> 
           
        </div> 
    </div> 
</div>


<!-- #helpModal -->        
<div id="LoginPegawai" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title persetujuan-modal-title">Halaman Persetujuan</h4>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	      </div>
	      <div class="modal-body">
			<div id="pages" class="pop_up">
				<div id="page_id" style="width:500px">
                    <div class="persetujuan">
                        <p>
                            <?php $raw = DB::table(FDBPrefix.'mutasi_raw')->select("value")->where("data='persyaratan'")->get()[0]['value'];
                            echo htmlentities($raw); ?>
                        </p>
                    
                        <label class="belum-setuju1">
                            <input type="checkbox" class="saya_setuju"> Saya setuju dengan persyaratan dan ketentuan diatas.</label>
                    </div>

                    <div class="login" style="display:none">
                    <table style="width:100%">
                        <tr>
                            <td align="center" >
                            <div class="alert alert-danger login_gagal" style="display:none">NIP dan Tanggal Lahir tidak cocok!</div>
                            <img src="media/images/id_card.jpg">
                            <br>
                            <input type="text"class="nip_pegawai form-controller form-login-mutasi numeric" placeholder="NIP / Username SINAGA" >
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                            <input type="password" class="ttl_pegawai form-controller form-login-mutasi" placeholder="Password SINAGA" maxlength="40">
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                        </tr>
                    </table>
				</div>


				</div>
			</div>
	      </div>
	      <div class="modal-footer">
			<button type="button" class="btn btn-default left" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary lanjutkan-mutasi1 persetujuan" >Lanjutkan</button>
            <button type="button" class="btn btn-default kembali-mutasi1 login"  style="display:none" >Kembali</button>
            <button type="button" class="btn btn-success lanjutkan-mutasi2 login"  style="display:none" >Proses</button>
	      </div>
	    </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->        
<!-- /#helpModal -->
