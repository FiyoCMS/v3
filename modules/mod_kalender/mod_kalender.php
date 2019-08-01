<?php
$day=date("d");
$month= date ("m");
$year=date("Y");
// t digunakan untuk menghitung jumlah seluruh hari pada bulan ini
//ini digunakan untuk menampilkan semua tanggal pada bulan ini
$endDate=date("t",mktime(0,0,0,$month,$day,$year));
//membuat tabel kalender 
//menampilkan hari ini 
//membuat tebel baris nama-nama hari
echo '<table class="mod_calendar">
<thead><tr>
<th align="center"><font color=red>Mi</font></th>
<th align="center">Se</th>
<th align="center">Se</th>
<th align="center">Ra</th>
<th align="center">Ka</th>
<th align="center">Ju</th>
<th align="center">Sa</th></tr>
</thead>';
//cek tanggal 1 hari sekarang
$s=date ("w", mktime (0,0,0,$month,1,$year));
if($s != 0) {
echo "<td colspan='$s' class='pad'></td>";
}
for ($d=1;$d<=$endDate;$d++) {
//jika variabel w= 0 disini 0 adalah hari minggu akan membuat baris baru dengan </tr>
if (date("w",mktime (0,0,0,$month,$d,$year)) == 0) { echo "<tr>"; }
$td="";
//menentukan warna pada tanggal hari biasa
if (date("D",mktime (0,0,0,$month,$d,$year)) == "Sun") { $td="free"; } else if(date("d",mktime (0,0,0,$month,$d,$year)) == date("d"))  { $td="today"; }
echo "<td class='$td' data-toggle='tooltip'>$d</td>"; 
//jika variabel w= 6 disini 6 adalah hari sabtu maka akan pindah baris dengan menutup baris </tr>
if (date("w",mktime (0,0,0,$month,$d,$year)) == 6 AND date("d",mktime (0,0,0,$month,$d,$year)) < 28 ) { echo "</tr>"; }}

$s = 35 - ($s + $endDate);
if($s != 0) {
echo "<td colspan='$s' class='pad'></td>";
}
echo "</tr>"; 
echo "</table>"; 
?>
