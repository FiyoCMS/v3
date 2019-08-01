<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2019 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

?>
<div id="app_header">
	<div class="warp_app_header">
		<?php if(USER_LEVEL <= 2) : ?>
		<div class="app_title">Dashboard</div>
		<div class="app_link">
			
		
			
				
	</div>

		<?php endif; ?>
	</div>
</div>
<div style="padding-bottom: 10px; width: 100%;">
<div class="col-lg-12 full">

	<div class="grid-2 auto-grid">
		<div class="mini-box style-blue online-user"><h3>0 <small>/ 0</small> </span></h3>
			<span>Dokumen Penting Saya</span> <i class="icon icon-shopping-cart"></i>
		</div>
		<div class="mini-box style-green monthly-visitor"><h3>0</h3>
			<span>Dokumen Saya Keseluruhan</span><i class="icon icon-file-text"></i>
		</div>
		<div class="mini-box style-red today-visitor"><h3>0</h3>
			<span>Dokumen Penting Seluruh SKPD</span><i class="icon icon-list"></i>
		</div>
		<div class="mini-box total-visitor"><h3>0</h3>
			<span>Dokumen Seluruh E-File</span><i class="icon icon-database"></i>
		</div>
	</div>



</div>
<div class="clearfix"></div>
<br>
<div class="box-left">
<div class="box">

		<header>			
			<h5>Daftar Dokumen Wajib
		</h5></header>

		<table class="data">
			<tbody>
				<?php		
				$tb1 = 'log_file';
				$tb2 = FDBPrefix.'efile_jenis';
				$nip = USER_NIP;
				$sql = DB::table($tb2)
					->where("penamaan = 'NIP_KODE'  AND wajib = 1")
					->select("*")
					->get();			
					
				$no = 1; 
				
				
				
		//login to EPS2017

		/*
DB::connect('eps','103.47.60.57','root','BKDauhyezzzx');
		
			$sk = DB::query("SELECT t.nm skpd, t.kd kdskpd,l.NALOK satker,m.B_02B FROM USER_NEW u,MASTFIP08 m,TABLOK08 t,TABLOKB08 l
			WHERE u.nip=m.B_02B AND m.A_01=t.kd AND
			m.A_01=l.A_01 AND m.A_02=l.A_02 AND m.A_03=l.A_03 AND m.A_04=l.A_04 AND l.A_05='00'
			AND t.kd='B2'", true, true);

			//jumlah seluruh pegawi per SKPD
			echo count($sk);




DB::connect('eps','103.47.60.57','root','BKDauhyezzzx');
$sk = DB::query("SELECT t.nm skpd, t.kd kdskpd,l.NALOK satker,m.B_02B FROM USER_NEW u,MASTFIP08 m,TABLOK08 t, TABLOKB08 l,
		 efile_efile_jenis j, log_file f
WHERE u.nip=m.B_02B AND m.A_01=t.kd AND
m.A_01=l.A_01 AND m.A_02=l.A_02 AND m.A_03=l.A_03 AND m.A_04=l.A_04 AND l.A_05='00'
AND f.nipbaru = u.nip
AND f.idjendok = j.kode
AND j.wajib = 1
AND t.kd='B2'", true, true);

//jumlah seluruh pegawi per SKPD
echo count($sk);

*/	

			
				foreach($sql as $row){	

					$jml = DB::table('log_file')
						->select('COUNT(*) AS count')
						->where("nipbaru='$nip' AND idjendok='$row[kode]'") -> get()[0]['count']; 
					if(!$jml) $jml = "<span class='label label-danger label-right hidden-xs' style='font-size: 90%'>Masih Kosong</span>";
					else $jml = "<span class='label label-success label-right hidden-xs' style='font-size: 90%'>Sudah Ada</span>";

					//creat user group values
						
									
					$name = "$row[nama_jenis]";
					
					echo "<tr>";
					echo "<td style=\"width:80% !important;\"><a class='tips' data-placement='right' title='".Edit."' href='?app=efile&view=folder&code=$row[kode]'>
					<img src='../media/images/folder.png' height='40' style='margin-right: 5px'> $name </a></td>
					<td align='center'>$jml</td>";
					echo"</tr>";
					$no++;
				}					
				?>
			</tbody>			
		</table>
</div>
</div>

<div class="box-right">
<div class="box">
<script src="<?php echo AdminPath; ?>/js/Chart.bundle.min.js"></script>
<canvas id="myChart" width="400" height="400"></canvas>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Dokumen Wajib", "Dokumen Keseluruhan", "Dokumen SKPD", "Dokumen Seluruhnya"],
        datasets: [{
            label: '# of Votes',
            data: [<?php echo $dokptg; ?>, <?php echo $doksaya; ?>, <?php echo $dokptgskpd; ?>, <?php echo $jumlah; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
		responsive: true,
		maintainAspectRatio: false,
		layout: {
            padding: {
                left: 0,
                right: 0,
                top: 10,
                bottom: 20
            }
        }
    }
});
</script>



</div>
</div>
