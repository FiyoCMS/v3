<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

session_start();
if(!isset($_SESSION['USER_ID']) or !isset($_SESSION['USER_ID']) or $_SESSION['USER_LEVEL'] > 5) die();
define('_FINDEX_','BACK');

require_once ('../../../system/jscore.php');

$id = Input::get('id');
$sql = Database::table('exsummary`,`kemajuankerja')
->select('realisasi_kumulatif as realisasi, rencana_kumulatif as rencana, kegiatan, dari, sampai')
->where("`kemajuankerja`.`proyek` = $id AND `exsummary`.`proyek` = $id  AND  `kemajuankerja`.`mingguke` = `exsummary`.`mingguke`")
->get();


$rencana	= [];
$realisasi	= [];
$dari		= [];
$sampai		= [];
$kegiatan	= [];
$i = 0;
			if($sql) 
foreach($sql as $row) {
	array_push($rencana,  	[(int)$i, (int)$row['rencana'], (int)$row['realisasi']]);
	array_push($realisasi,  	[(int)$i, (int)$row['rencana'], (int)$row['realisasi']]);
	array_push($dari,  		(int)$row['dari']);
	array_push($sampai,  	(int)$row['sampai']);
	array_push($kegiatan,  	$row['kegiatan']);
	$i++;
}


			
			$id = Input::get('id');
			$sql=Database::table('exsummary')
			->select('*')
			->where("proyek = $id")
			->get();
			if($sql) :
			?>
<div class="col-lg-5" style="padding:0;margin: -1px;">		
		<table class="data">
			<thead>
				<tr>					
					<th style="width:20% !important;">Uraian Pekerjaan</th>
					<th style="width:15% !important; text-align: center;" >Mulai</th>
					<th style="width:15% !important; text-align: center;" >Selesai</th>
					<th style="width:10% !important; text-align: center;" class='hidden-xs'>Durasi</th>
				</tr>
			</thead>
			<tbody>
			<?php		
			$sql=Database::table('exsummary')
			->select('*')
			->where("proyek = $id")
			->get();
			$no=1;
			$hari = [];
			$i = 0;
			foreach($sql as $row){
				
					$startTimeStamp = strtotime($row['dari']);
						$endTimeStamp = strtotime($row['sampai']);
						$timeDiff = $endTimeStamp - $startTimeStamp;
						$numberDays = $timeDiff/86400; 					
						$kntrk = intval($numberDays) + 1;
						$hari[$i] = $kntrk;
				echo "<tr>";
				echo "
					<td>$row[kegiatan]</td>
					<td align='center' class='hidden-xs'>$row[dari]</td>
					<td align='center' class='hidden-xs'>$row[sampai]</td>
					<td align='center' class='hidden-xs'>$kntrk Hari</td>
					";
				echo "</tr>";
				$i++;	
			}
			?>
			</tbody>			
		</table>
		
		<?php endif; 
		
			
			$kt = Database::table('kontrak')
			->select('*')
			->where("proyek = $id")
			->get();
			
				
			$startTimeStamp = strtotime($kt[0]['tgl_kontrak']);
			$endTimeStamp = strtotime($kt[0]['tgl_selesai']);
			$timeDiff = $endTimeStamp - $startTimeStamp;
			$numberDays = $timeDiff/86400;
			
			$kntrk = intval($numberDays) + 1;
						
			$c  = date_parse($kt[0]['tgl_selesai']); 
			
			$ddate = $kt[0]['tgl_kontrak'];
			$date = new DateTime($ddate);
			$sweek = $date->format("W");
			$smonth = (int)$date->format("m");
			
			$edate = $kt[0]['tgl_selesai'];
			$date = new DateTime($edate);
			$eweek = $date->format("W");
			$emonth = (int)$date->format("m");
					
		?>
</div>
<div class="col-lg-7"  style="padding:0;  margin: -1px -1px 0 0;  width: 58.6%;">	
<table class="data">
			<thead>
				<tr>
				<?php
				for($i = $smonth;$i <= $emonth;  $i++) : 	
					$monthNum  = $i;
					$dateObj   = DateTime::createFromFormat('!m', $monthNum);
					$monthName = $dateObj->format('F'); // March
					
				?>					
					<th style=" text-align: center">
						<?= $monthName;?>
					</th>
				<?php endfor; ?>
	
				</tr>
			</thead>
			
			
			
			<tbody>
			<?php		
			$sql=Database::table('kemajuankerja')
			->select('*')
			->where("proyek = $id")
			->get();
			$i=0;
			$tweek = $eweek - $sweek +1; 
			$mmm = $emonth - $smonth +1; 
			foreach($sql as $row){
				$n = $hari[$i] / $kntrk * 100;
				$mweek = $row['mingguke'] / $tweek * 100 ;
				
				if($n > $row['rencana']) $c = 'red';
				else if(($n / $row['rencana'] * 100) > 80) $c = 'yelow';
				else  $c = 'green';
				echo "<tr>";
				echo "
					<td colspan='$mmm'>
					<div style='width: $n%;  background: $c; height: 10px;border-radius: 5px;  margin: -2px 0 0 $mweek%;'></div>
					<div style='width: $row[rencana]%; background: #aaa; height: 10px;border-radius: 5px; margin:  4px 0 -4px $mweek%'></div>
					
					
					</td>
					";
				echo "</tr>";
				$i++;	
			}
			?>
			</tbody>	
		</table>
</div>
		<div id="statistic3">
			<!-- Tab panes -->			
			
		</div>
<script>
$(function () {		
    var chart;
	var rencana = <?php echo json_encode($rencana);?>;
    $(document).ready(function() {
		
		function chartStat() {
			chart = new Highcharts.Chart({
			//colors: ['#09f', '#f85d11', ],
				chart: {
					renderTo: 'statistic3',
					type: 'columnrange',
					inverted: true,
				 },
				title: {
	        text: ''
	    },
	    
		subtitle: {
	        text: ''
	    },
	
	    xAxis: {
	        categories: <?php echo json_encode($kegiatan);?>
	    },
	    
	    yAxis: {
	        title: {
	            text: 'Bulan'
	        },
	        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan']
	    },
	
	    tooltip: {
	        valuePrefix: 'Minggu ke-'
	    },
	    
	    plotOptions: {
	        columnrange: {
	        	dataLabels: {
	        		enabled: false,
	        		formatter: function () {
	        			return this.y + 0.5 + '';
	        		}
	        	}
	        }
	    },
	    
	    legend: {
	        enabled: false
	    },
	
	    series: [{
	        name: 'Rencana',
	        data: 
                <?php echo json_encode($rencana);?>
			
	    },{
	        name: 'Realisasi',
	        data: 
				<?php echo json_encode($realisasi);?>
			
	    }]					
			});
		}
		
		//chartStat();
		

    }); 
    
});
</script>