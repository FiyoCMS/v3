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
			<div class="mini-box style-blue online-user"><h3>110.123</span></h3>
				<span>Jumlah Artikel </span> <i class="icon icon-file-text"></i>
			</div>
			<div class="mini-box style-green monthly-visitor"><h3>0</h3>
				<span>Kunjungan Hari ini</span><i class="icon icon-dollar"></i>
			</div>
			<div class="mini-box style-yellow today-visitor"><h3>0</h3>
				<span>Kunjungan Minggu ini</span><i class="icon icon-users"></i>
			</div>
			<div class="mini-box style-red total-visitor"><h3>0</h3>
				<span>Kunjungan Bulan ini</span><i class="icon icon-youtube"></i>
			</div>
		</div>
	</div>

	
<br>
	<div class="col-lg-12 full">
		<div class="grid-2 auto-grid">
			<div class="mini-box border-blue online-user"><h3>0 <small>/ 0</small> </span></h3>
				<span>Pesanan Baru</span> <i class="icon icon-file-text"></i>
			</div>
			<div class="mini-box border-green monthly-visitor"><h3>0</h3>
				<span>Jumlah Produk</span><i class="icon icon-database"></i>
			</div>
			<div class="mini-box border-red today-visitor"><h3>0</h3>
				<span>Kategori Produk</span><i class="icon icon-list"></i>
			</div>
			<div class="mini-box border-yellow -visitor"><h3>0</h3>
				<span>Total Penjualan</span><i class="icon icon-dollar"></i>
			</div>
		</div>
	</div>

<div class="clearfix"></div>
<br>
<div class="box-left">
	<div class="box">
		<header>			
			<h5>Pie Chart</h5>
		</header>
		<div>
		<canvas id="chart-area"></canvas>

		</div>
	</div>
</div>

<div class="box-right">

	<div class="box" id="visitor-stat">
		<header>			
			<h5>Kunjungan</h5>
		</header>
		<div class="padding-10">
			<canvas id="barstatistik"></canvas>

		</div>
	</div>
	
	<div class="box">
		<header>			
			<h5>Bar</h5>
		</header>
		<div>
			<canvas id="canvas"></canvas>
		</div>
	</div>
</div>


</div>
<script>
	'use strict';

	/* send post data */
	var tanggal = [];

	window.chartColors = {
			red: '#e74c3c',
			orange: 'rgb(255, 159, 64)',
			yellow: 'rgb(255, 205, 86)',
			green: '#3ea932',
			blue: '#428bca',
			purple: 'rgb(153, 102, 255)',
			grey: 'rgb(201, 203, 207)'
		};


	$.get("?app=theme&api=module&module=module/statistic_data").done(function (r) {
		
		var $label = r.data.date;
		var $unique = r.data.unique;
		var $visitor = r.data.visitor;
		
		
		var config = {
			type: 'bar',
			data: {
				labels: $label,
				datasets: [{
					label: 'Page Views',
					backgroundColor: window.chartColors.yellow,
					borderColor: window.chartColors.yellow,
					data: $visitor,
					fill: false,
				}, {
					label: 'Unique Visitors',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: $visitor,
				}]
			},
			options: {
				legend: {
					display: true,
					position: 'bottom',
					labels: {
						
					}
				},
				responsive: true,
				title: {
					display: false,
					text: 'Chart.js Line Chart'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Days'
						}
					}],
					yAxes: [{
						display: false,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}]
				}
			}
		};


		var ctx = document.getElementById('barstatistik').getContext('2d');
		window.myLine2 = new Chart(ctx, config);
			
	});
</script>
	
<script>
	var barChartData = {
		labels: ['Kecamatan A', 'Kecamatan B', 'C', 'April', 'May', 'June', 'July'],
		datasets: [{
			label: 'Data Kecamatan',
			backgroundColor: [
				window.chartColors.red,
				window.chartColors.orange,
				window.chartColors.yellow,
				window.chartColors.green,
				window.chartColors.blue,
				window.chartColors.purple,
				window.chartColors.red
			],
			borderWidth:1,
			yAxisID: 'y-axis-1',
			data: [
				4,
				3,
				4,
				7,
				7,
				7,
				7,
				0,
				20,
			]
		}]

	};

		var ctx = document.getElementById('canvas').getContext('2d');
		window.myBar = new Chart(ctx, {
			type: 'horizontalBar',
			data: barChartData,
			options: {
				legend: {
					display: true,
					position: 'bottom',
					labels: {
						fontColor: 'rgb(255, 99, 132)'
					}
				},
				responsive: true,
				title: {
					display: false,
					text: 'Judul Chart'
				},
				tooltips: {
					mode: 'index',
					intersect: true
				},
				scales: {
					yAxes: [{
						display: true,
						position: 'left',
						id: 'y-axis-1',							
						ticks: {
							beginAtZero: true,
							max: 100,
							min: 0
						}
					}],
				}
			}
		});
		
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						12,
						2,
						3,
						4,
						5,
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
						window.chartColors.blue,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Red',
					'Orange',
					'Yellow',
					'Green',
					'Blue'
				]
			},
			options: {
				responsive: true,				
				legend: {
						display: true,
						position: 'bottom',
						labels: {
							fontColor: 'rgb(255, 99, 132)'
						}
					},
			}
		};
			
		var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);


		var colorNames = Object.keys(window.chartColors);

	</script>