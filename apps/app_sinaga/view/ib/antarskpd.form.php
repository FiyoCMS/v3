<?php 
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$article = new Mutasi;


if(Input::session('PEGAWAI_LAST_DATA')) {
    
    $nip =  session('PEGAWAI_LAST_DATA')['nip'];
    $data = DB::table(FDBPrefix."mutasi_data")->where("kategori=4 AND nip='$nip'")->get();
    if(isset($data[0])) {
        $model = array_merge(Input::session('PEGAWAI_LAST_DATA'), $data[0]);
        $btn = "edit";
    }
    else {
        $model = Input::session('PEGAWAI_LAST_DATA');
        $btn = "simpan";
    }
    
    echo Form::model($model, ['url' => '', 'method' => 'post']);    
    if(Input::get('view') !== 'provskpd' OR Input::get('view') !== 'provkab') {
        $disabled = 'readonly';
        $sp3 = "style='display:none'";

    }
    else
        $disabled = '';


} else {
    
    echo Form::open(['url' => '', 'method' => 'post']);   
}


?>
<h3>Input Data PNS Pindah Antar SKPD</h3>
<?php 
printAlert('NOTICE');
?>
<table class="form-mutasi">

<!-- IDENTITAS PEGAWAI -->

    <tr>
        <td colspan="2" class="table-label"><h4>II. Identitas Pegawai</h4></td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>	
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
        <td>Tempat Lahir</td>
        <td>	
            <?php
				echo Form::text(
					'tmp_lahir', 
					'', 
					["class" => "form-control", "required $disabled", "style" => "width: 30%"]
				);
            ?>
        </td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>	
            <?php
				echo Form::date(
					'tgl_lahir', 
					'', 
					["class" => "form-control", "required  $disabled", "style" => "width: 30%"]
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
            TMT
            <?php
				echo Form::date(
					'tmt', 
					'', 
					["class" => "form-control", "$disabled", "style" => "width: 30%"]
				);
            ?>
        </td>
    </tr>
    
    <tr>
        <td>Latar Belakang Pendidikan</td>
        <td>	
            <?php
				echo Form::text(
					'pendidikan', 
					'', 
					["class" => "form-control", "", "style" => "width: 30%", "placeholder" => "SMA/SMK/D1/D2"]
				);
            ?>
            	<br>
                <?php
				echo Form::text(
					'pendidikans1', 
					'', 
					["class" => "form-control", "", "style" => "width: 30%", "placeholder" => "D4/S1"]
				);
            ?>
            	
            	<br>
                <?php
				echo Form::text(
					'pendidikans2', 
					'', 
					["class" => "form-control", "", "style" => "width: 30%", "placeholder" => "S2"]
				);
            ?>
            <br>
            <?php
            echo Form::text(
                'pendidikans3', 
                '', 
                ["class" => "form-control", "", "style" => "width: 30%", "placeholder" => "S3"]
            );
        ?>
        </td>
    </tr>

    
    <tr>
        <td>Jabatan Saat ini</td>
        <td>	
            <?php
				echo Form::text(
					'jabatan', 
					'', 
					["class" => "form-control", "", "style" => "width: 70%"]
				);
            ?>
        </td>
    </tr>
    
    <tr>
        <td>Unit Kerja Saat ini</td>
        <td>	
            <?php
				echo Form::text(
					'unit', 
					'', 
					["class" => "form-control", "", "style" => "width: 60%"]
				);
            ?>
        </td>
    </tr>
    
    <tr>
        <td>Instansi Saat ini</td>
        <td>	
            <?php
				echo Form::text(
                    'instansi', 		
                    '', 
					["class" => "form-control", "", "style" => "width: 30%"]
				);
            ?>
        </td>
    </tr>

    
<!-- LAMPIRAN -->

    <tr>
        <td colspan="2"><h4>II. Dasar Surat</h4></td>
    </tr>
    <tr>
        <td>Surat Persetujuan 1</td>
        <td>	
            <?php
				echo Form::text(
					'sp1', 
					'', 
					["class" => "form-control ", "required", "rows" => "4" ,"style='width: 70%'"]
				);
            ?>
            <br>
            Nomor : 
                <?php
                    echo Form::text(
                        'no_sp1', 
                        '', 
                        ["class" => "form-control", "required", "rows" => "4"]
                    );
                ?>
            Tanggal : 
                <?php
                    echo Form::date(
                        'tgl_sp1', 
                        '', 
                        ["class" => "form-control", "", "rows" => "4"]
                    );
                ?>
                
            
            <?php
                echo Form::checkbox(
                    'tgl_sp1n', 
                    '', 
                    '', 
                        ["class" => "form-control", "", "rows" => "4"] , "Tidak Bertanggal"
                );
            ?>
        </td>
    </tr>
    
    
    <tr>
        <td>Surat Persetujuan 2</td>
        <td>	
            <?php
				echo Form::text(
					'sp2', 
					'', 
					["class" => "form-control ", "required", "rows" => "4","style='width: 70%'"]
				);
            ?>
            
            <br>
            Nomor : 
                <?php
                    echo Form::text(
                        'no_sp2', 
                        '', 
                        ["class" => "form-control", "required", "rows" => "4"]
                    );
                ?>
            Tanggal : 
                <?php
                    echo Form::date(
                        'tgl_sp2', 
                        '', 
                        ["class" => "form-control", "", "rows" => "4"]
                    );
                ?>
                
            
            <?php
                echo Form::checkbox(
                    'tgl_sp2n', 
                    '', 
                    '', 
                        ["class" => "form-control", "", "rows" => "4"] , "Tidak Bertanggal"
                );
            ?>
        </td>
    </tr>

        
    <tr >
        <td>Surat Persetujuan 3</td>
        <td>	
            <?php
                echo Form::text(
                    'sp3', 
                    '', 
                    ["class" => "form-control full", "", "rows" => "4", "style='width: 70%'"]
                );
            ?>
            <br>
            
            Nomor : 
                <?php
                    echo Form::text(
                        'no_sp3', 
                        '', 
                        ["class" => "form-control", "", "rows" => "4"]
                    );
                ?>
            Tanggal : 
                <?php
                    echo Form::date(
                        'tgl_sp3', 
                        '', 
                        ["class" => "form-control", "", "rows" => "4"]
                    );
                ?>
                <?php
                    echo Form::checkbox(
                        'tgl_sp3n', 
                        '', 
                        '', 
                            ["class" => "form-control", "", "rows" => "4"]  , "Tidak Bertanggal"
                    );
                ?>
                
        </td>
    </tr>
        
    <tr>
        <td>SKPD Asal</td>
        <td>	
            <?php		
            
            DB::connect('eps','103.47.60.57','root','BKDauhyezzzx');
			$tb2 = 'TABLOK08';
			$sql = DB::table($tb2)
				->select("*")
				->get();
            $no = 1; 
			foreach($sql as $row){
                $array[$row['kd']] = $row['nm'];
            }					
            
                echo Form::select(
                    'skpd_asal',
                    $array, 
                    '', 
                    ["class" => "form-control", "required"],
                    'Pilih'
                );

            ?>
        </td>
    </tr>
        
    <tr>
        <td>Formasi Jabatan</td>
        <td>
            
            <?php		
$array = [
    1 => "Analis Data dan Informasi",
    2 => "Analis Penelitian dan Pengembangan    ",
    3 => "Analis Perencanaan",
    4 => "Analis Perencanaan, Evaluasi dan Pelaporan    ",


    6=> "Analis Jasa Konsultasi",
    7 => "Analis Laporan Hasil Pengawasan    ",
    8 => "Analis Data dan Informasi",

    
    9 => "Analis Jabatan",
    
    10 => "Pengadministrasi Keuangan ",
    
    11 => "Pengelola Sistem Informasi Manajemen Kepegawaian
    ",
    12 => "Pengolah Data Anggaran dan Perbendaharaan ",
];

            echo Form::select(
                'formasi',
                $array, 
                '', 
                ["class" => "form-control formasi", "required"],
                'Pilih'
            );
            
            ?>
                
        </td>
    </tr>

    <tr>
        <td class="skpd-tersedia" colspan="2">
            
           

        </td>
    </tr>


    
    <!--tr>
        <td>SKPD Tujuan</td>
        <td>	
            <?php		
            
            DB::connect('eps','103.47.60.57','root','BKDauhyezzzx');
			$tb2 = 'TABLOK08';
			$sql = DB::table($tb2)
				->select("*")
				->get();
            $no = 1; 
			foreach($sql as $row){
                $array[$row['kd']] = $row['nm'];
            }					
            
                echo Form::select(
                    'skpd_asal',
                    $array, 
                    '', 
                    ["class" => "form-control", "required"],
                    'Pilih'
                );

            ?>
        </td>
    </tr-->
        


    

<!-- E-File Administrasi -->
<tr>
        <td colspan="2" class="table-label"><h4>III. Administrasi E-File</h4></td>
    </tr>
    <tr>
        <td>Lampiran Administrasi
        </td>
        <td>
            <?php		
            
            DB::connect('edoc','103.47.60.57','root','BKDauhyezzzx');
			$tb1 = 'log_file';
			$tb2 = 'efile_efile_jenis';
			$nip = $_SESSION['USER_NIP'];
			$sql = DB::table($tb2)
				->where("penamaan = 'NIP_KODE'")
				->select("*")
				->get();
            $no = 1; 
            
            $arr = [
                '02',
                '03',
                '14_13',
                '04_11',
                '04_12',
                '09_07',
                '31_17',
                '31_18',

            ];
			foreach($sql as $row){
                if(!in_array($row['kode'], $arr)) continue;
				$file = DB::table('log_file')
					->select('*')
                    ->where("nipbaru='$nip' AND idjendok='$row[kode]'") -> get(); 
                    
				if(isset($file[0])) {
                    $mod = '<span class=\'label label-primary\'>Lengkap</span>';
                } else {
                    $mod ='(lengkapi di aplikasi E-FIle)';
                }
                    //creat user group values
                        
                                    
                    $name = "$row[nama_jenis] <i>($row[kode])</i>";
                    
                    echo "";
                    echo "$no.) 
                    $name                    
                    $mod
                   ";
                    echo"<br>";
                    $no++;	
				
			}					
			?>

        
        <!--
            <?php
				echo Form::checkbox(
					'administrasi1', 
					'', 
					'', 
					["class" => "form-control", ""] ,"SK CPNS legalisir"
				);
            ?> 
            <?php
				echo Form::checkbox(
					'administrasi2', 
					'', 
					'', 
					["class" => "form-control", ""] ,"SK PNS legalisir"
				)
            ?> 
            <?php
				echo Form::checkbox(
					'administrasi3', 
					'', 
					'', 
					["class" => "form-control", ""] ,"SK KP terakhir legalisir"
				);
            ?>  
            
                <?php
                    echo Form::checkbox(
                        'administrasi4', 
                        '', 
                        '', 
                        ["class" => "form-control", ""],"Konversi NIP legalisir"
                    );
                ?>  
                 <?php
                     echo Form::checkbox(
                         'administrasi5', 
                         '', 
                         '', 
                         ["class" => "form-control", ""],"Karpeg legalisir"
                     )
                 ?> 
                 <?php
                     echo Form::checkbox(
                         'administrasi6', 
                         '', 
                         '', 
                         ["class" => "form-control", ""] ," Penyesuaian jabatan Fungsional Guru(bagi jabatan PNS Guru) "
                     );
                 ?>
                  <?php
                      echo Form::checkbox(
                          'administrasi7', 
                          '', 
                          '', 
                          ["class" => "form-control", ""],"Ijazah legalisir"
                      )
                  ?> 
                   <?php
                       echo Form::checkbox(
                           'administrasi8', 
                           '', 
                           '', 
                           ["class" => "form-control", ""]," DP3/SKP 2 tahun terakhir dan"
                       );
                   ?> 
                    <?php
                        echo Form::checkbox(
                            'administrasi9', 
                            '', 
                            '', 
                            ["class" => "form-control", ""],"Surat keterangan tidak pernah dijatuhi hukum disiplin tingkat sedang/berat dari pimpinan SKPD asal"
                        );
                    ?> -->
            
            </td>
    </tr>

<!-- Kelengkapan Lain -->

    <tr>
        <td colspan="2" class="table-label"><h4>IV. Kelengkapan Lain</h4></td>
    </tr>
    <tr>
        <td>Noomor SK</td>
        <td>	
            <?php
				echo Form::text(
					'no_sk', 
					'', 
					["class" => "form-control", "", "style" => "width: 50%"]
				);
            ?>
        </td>
    </tr>
    <tr>
        <td>Nomor Pengantar</td>
        <td>	
            <?php
				echo Form::text(
					'no_pengantar', 
					'', 
					["class" => "form-control", "", "style" => "width: 50%"]
				);
            ?>
        </td>
    </tr>
    <tr>
        <td>Tanggal Penetapan SK</td>
        <td>	
            <?php
				echo Form::date(
					'tgl_sk', 
					'', 
					["class" => "form-control", "", "style" => "width: 50%"]
				);
            ?>
            <?php
				echo Form::hidden(
					'id', 
					'', 
					["class" => "form-control "]
				);
            ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button type="submit" class="form-control btn btn-success" style="width: 150px;" name="<?php echo $btn; ?>-antarskpd" value="1">Simpan</button>
        </td>
    </tr>
</table>


<script>

$().ready(function (){ 

    $(".formasi").change(function() {
        val = $(this).val();
        if(val < 2) {
            $(".skpd-tersedia").html("<table><tr><td>Pilihan</td><td>ESELON III</td> <td>ESELON IV</td> <td>TERSEDIA</td> <td>KUALIFIKASI PENDIDIKAN</td><tr><tr><td><label><input type='radio'  name='formasi'> DINAS PU BINA MARGA DAN CIPTA KARYA </label></td><td>Balai Pelaksana Teknis Jalan Wilayah Cilacap</td> <td>Subbag Tata Usaha  </td><td>2</td> <td>SLTA/DI/ DII/ DIII di bidang manajemen perkantoran/ administrasi perkantoran/ tata perkantoran </td><tr></table><br><br><br>");
        }
        else if(val < 5) {
            $(".skpd-tersedia").html("<table><tr><td>Pilihan</td><td>ESELON III</td> <td>ESELON IV</td> <td>TERSEDIA</td> <td>KUALIFIKASI PENDIDIKAN</td><tr><tr><td><label><input type='radio'  name='formasi'> DINAS PU BINA MARGA DAN CIPTA KARYA </label></td><td>Balai Jasa Konstruksi dan Informasi Konstruksi</td> <td>Seksi Jasa Konstruksi</td><td>1</td> <td>S-1 Teknik Sipil S-1 Teknik Arsitektur</td><tr></table><br><br><br>");
        }
        else if(val < 9) {
            $(".skpd-tersedia").html("<table><tr><td>Pilihan</td><td>ESELON III</td> <td>ESELON IV</td> <td>TERSEDIA</td> <td>KUALIFIKASI PENDIDIKAN</td><tr><tr><td><label><input type='radio'  name='formasi'> DINAS PU BINA MARGA DAN CIPTA KARYA </label></td><td>Balai Jasa Konstruksi dan Informasi Konstruksi</td> <td>Seksi Jasa Konstruksi</td><td>2</td> <td>KS-1/D-IV Teknik Sipil</td><tr></table><br><br><br>");
        }
        else {
            $(".skpd-tersedia").html("<table><tr><td>Pilihan</td><td>ESELON III</td> <td>ESELON IV</td> <td>TERSEDIA</td> <td>KUALIFIKASI PENDIDIKAN</td><tr><tr><td><label><input type='radio'  name='formasi'> DINAS PU BINA MARGA DAN CIPTA KARYA </label></td><td>Balai Jasa Konstruksi dan Informasi Konstruksi</td> <td>Seksi Jasa Konstruksi</td><td>2</td> <td>KS-1/D-IV Teknik Sipil</td><tr></table><br><br><br>");
        }
    });

});

</script>

				