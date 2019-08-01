<?php

echo Form::open(['url' => '', 'method' => 'post']);  
$disabled = "disabled";
?>

<div class="main">
    <div class="app-header">
        <h2>Lembar Tugas Belajar</h2>
    </div>
    
    <div class="tbib">
        <div class="app-sub-header">
            <a class="btn btn-default panel" href="<?php echo make_permalink("?app=".app_param('app')."&view=".app_param('view')."&type=".app_param('type')."&cat=".app_param('cat')); ?>"> 
           <i class="icon-arrow-left"></i> Kembali
            </a> 
		</div>
		

<div class="form-full">		
			<table class="form full" style="width:100%">
			<!-- IDENTITAS PEGAWAI -->
				<tr>
					<td colspan="2">
			            <h3>I. Identitas Pegawai</h3>
                    </td>
				</tr>
				<tr>
					<td style="width: 30%">Nama</td>
					<td style="width: 70%">	
						<?php
							echo Form::text(
								'nama', 
								'', 
								["class" => "form-control", "required readonly", "style" => "width: 50%"]
							);
						?>
					</td>
				</tr>
				<tr>
					<td>NIP</td>
					<td>	
						<?php
							echo Form::text(
								'nip', 
								'', 
								["class" => "form-control", "required $disabled", "style" => "width: 30%"]
							);
						?>
					</td>
				</tr>
				<tr>
					<td>Tempat Lahir / Tanggal Lahir</td>
					<td>	
						<?php
							echo Form::text(
								'tmp_lahir', 
								'', 
								["class" => "form-control", "required $disabled"]
							);
						?> - 
						<?php
							echo Form::date(
								'tgl_lahir', 
								'', 
								["class" => "form-control", "required  $disabled"]
							);
						?>
					</td>
				</tr>
				
				<tr>
					<td>Pangkat/Gol.Ruang</td>
					<td>	
						<?php
							echo Form::select(
								'golongan', 
								[11=>"I/a - Juru Muda",12=>"I/b          ||
								Juru Muda Tingkat I      "      ,
								13=>"      I/c          ||
								Juru"                  ,
								14=>"      I/d          ||
								Juru Tingkat I  ",
								21=>" II/a          ||
								Pengatur Muda",
								22=>"   II/b          ||
								Pengatur Muda Tingkat I",
								
								23=>"  II/c          ||
								Pengatur  ",
								24=>"    II/d          ||
								Pengatur Tingkat I  ",
								31=>"III/a          ||
								Penata Muda  ",
								32=>"  III/b          ||
								Penata Muda Tingkat I ",
								33=>"   III/c          ||
								Penata        ",
								34=>"   III/d          ||
								Penata Tingkat I ",
								41=>"   IV/a          ||
								Pembina      ",
								42=>"   IV/b          ||
								Pembina Tingkat I ",
								43=>"    IV/c          ||
								Pembina Utama Muda   ",
								44=> "   IV/d          ||
								Pembina Utama Madya  ",
								45=> "  IV/e          ||
								Pembina Utama  "  ],
								'', 
								["class" => "form-control", "required  $disabled", "style" => "width: 30%"]
							);
						?>
						TMT <span>
						<?php
							echo Form::date(
								'tmt', 
								'', 
								["class" => "form-control", "$disabled"]
							);
						?></span>
					</td>
				</tr>
				
				<tr>
					<td>Pendidikan Terakhir</td>
					<td>	
						<?php
							echo Form::text(
								'pendidikan', 
								'', 
								["class" => "form-control", "$disabled", "style" => "width: 30%"]
							);
						?>
					</td>
				</tr>

				
				<tr>
					<td>Jabatan</td>
					<td>	
						<?php
							echo Form::text(
								'jabatan', 
								'', 
								["class" => "form-control", "$disabled", "style" => "width: 70%"]
							);
						?>
					</td>
				</tr>
				
				<tr>
					<td>Unit Kerja Lama</td>
					<td>	
						<?php
							echo Form::text(
								'unit', 
								'', 
								["class" => "form-control", "$disabled", "style" => "width: 60%"]
							);
						?>
					</td>
				</tr>
				
			</table>
						</div>
			

<div class="label-big">	
			<table class="" style="width:100%"><tr>
				<td colspan="2">
			            <h3>II. Kelengkapan Surat</h3>
                    </td>
				</tr>
				<tr>
					<td style="width: 30%">Diterima resmi dari Sekolah</td>
					<td style="width: 70%">	
						<?php
							echo Form::text(
								'prodi', 
								'', 
								["class" => "form-control ", "required", "size" => "40", "placeholder" => "Nama Prodi." ]
							);
						?>	-
						<?php
							echo Form::text(
								'fakultas', 
								'', 
								["class" => "form-control ", "required", "size" => "40" , "placeholder" => "Fakultas"]
							);
						?> -	
						<?php
							echo Form::text(
								'universitas', 
								'', 
								["class" => "form-control ", "required", "size" => "40", "placeholder" => "Universitas" ]
							);
						?>
					</td>	
				</tr>
				<tr>
					<td style="width: 30%">Surat Pernyataan / keterangan</td>
					<td style="width: 70%">
						<button class='btn btn-primary'>Lampiran</button>	<br><br>
						<?php
							echo Form::text(
								'no_surat', 
								'', 
								["class" => "form-control ", "required", "size" => "40", "placeholder" => "No. Surat" ]
							);
						?>	-
						<?php
							echo Form::text(
								'tgl_surat', 
								'', 
								["class" => "form-control ", "required", "size" => "40" , "placeholder" => "Tanggal Surat"]
							);
						?> -	
						<?php
							echo Form::text(
								'hal', 
								'', 
								["class" => "form-control ", "required", "size" => "40", "placeholder" => "Tentang / Perihal" ]
							);
						?>
					</td>	
					</tr>
				<tr>
					<td style="width: 30%">Surat keterangan Pembiayaan</td>
					<td style="width: 70%">	
						<button class='btn btn-primary'>Lampiran</button>	<br><br>
						<?php
							echo Form::text(
								'no_surat', 
								'', 
								["class" => "form-control ", "required", "size" => "20", "placeholder" => "No. Surat" ]
							);
						?>	-
						<?php
							echo Form::text(
								'tgl_surat', 
								'', 
								["class" => "form-control ", "required", "size" => "20" , "placeholder" => "Tanggal Surat"]
							);
						?> -	
						<?php
							echo Form::text(
								'hal', 
								'', 
								["class" => "form-control ", "required", "size" => "40", "placeholder" => "Tentang / Perihal" ]
							);
						?>
					</td>	
				</tr>
				
				<tr>
					<td style="width: 30%">Surat Kepala Dinas / Badan</td>
					<td style="width: 70%">	
						<button class='btn btn-primary'>Lampiran</button>	<br><br>
						<?php
							echo Form::text(
								'no_surat', 
								'', 
								["class" => "form-control ", "required", "size" => "20", "placeholder" => "No. Surat" ]
							);
						?>	-
						<?php
							echo Form::text(
								'tgl_surat', 
								'', 
								["class" => "form-control ", "required", "size" => "20" , "placeholder" => "Tanggal Surat"]
							);
						?> -	
						<?php
							echo Form::text(
								'hal', 
								'', 
								["class" => "form-control ", "required", "size" => "40", "placeholder" => "Tentang / Perihal" ]
							);
						?>
					</td>	
				</tr>

				
				<tr>
					<td style="width: 30%">Surat keterangan lama studi</td>
					<td style="width: 70%">	
						<button class='btn btn-primary'>Lampiran</button>	<br><br>
						<?php
							echo Form::text(
								'tgl_surat', 
								'', 
								["class" => "form-control ", "required", "size" => "20" , "placeholder" => "Tanggal Mulai"]
							);
						?> s.d.	
						<?php
							echo Form::text(
								'hal', 
								'', 
								["class" => "form-control ", "required", "size" => "40", "placeholder" => "Tanggal Selesai" ]
							);
						?>
						<?php
							echo Form::hidden(
								'no_surat', 
								'', 
								["class" => "form-control ", "required", "size" => "20", "placeholder" => "Semester" ]
							);
						?>
					</td>	
				</tr>
				<tr>
					<td style="width: 30%">Kalender Pendidikan</td>
					<td style="width: 70%">	
						<button class='btn btn-primary'>Unggah Kalender</button>	<br><br>
					</td>	
				</tr>
				
				<tr>
					<td style="width: 30%">Anggaran Pendidikan</td>
					<td style="width: 70%">	
						<?php
							echo Form::text(
								'sumber_anggaran', 
								'APBD Pemerintah Provinsi Jawa Tengah', 
								["class" => "form-control ", "readonly", "size" => "50" , "style"=>"width: 70%", "placeholder" => "Tanggal Mulai"]
							);
						?> 
					</td>	
				</tr>
				<tr>
					<td style="width: 30%"></td>
					<td style="width: 70%"><br><br>
						<button class='btn btn-success '>Kirim Pengajuan</button>
					</td>	
				</tr>
				
			</table>
		</div>
	</div>
</div>
