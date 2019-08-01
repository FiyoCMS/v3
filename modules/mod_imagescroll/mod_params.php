<?php
/**
* @version		v 1.0.0
* @package		Fi ImageScroll
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$type = mod_param('type',modParam);
$thumb = mod_param('thumb',modParam);
$folder = mod_param('folder',modParam);
$style = mod_param('style',modParam);
$thumbW = mod_param('thumbW',modParam);
$thumbH = mod_param('thumbH',modParam);
$boxW = mod_param('boxW',modParam);
$boxH = mod_param('boxH',modParam);

if($type=="jpg"){$ext1="selected";}
if($type=="png"){$ext2="selected";}
if($type=="gif"){$ext3="selected";} 


if($style=="1"){$sty1="selected";}
if($style=="2"){$sty2="selected";}
if($style=="3"){$sty3="selected";} 

if($thumb==1){$thumbs1="selected";}
if($thumb==0){$thumbs2="selected";} 

?>

<input type="hidden" value="8" name="totalParam" />
<input type="hidden" value="folder" name="nameParam1" />
<input type="hidden" value="type" name="nameParam2" />
<input type="hidden" value="style" name="nameParam3" />
<input type="hidden" value="thumb" name="nameParam4" />
<input type="hidden" value="thumbW" name="nameParam5" />
<input type="hidden" value="thumbH" name="nameParam6" />
<input type="hidden" value="boxW" name="nameParam7" />
<input type="hidden" value="boxH" name="nameParam8" />
<li>
<h3>Fi ImageScrooll Configuration</h3>
<div class="isi">
	<div class="acmain open">
		<table class="data2">
			<!-- Menampilkan menu menurut kategori pilihan -->	
			<tr>
				<td class="djudul tooltip" title="Pilih folder pada folder <b>/files/</b>">Path Folder</td>
				<td>
					<input value="<?php echo @$folder; ?>" name="param1" type="text" size="20"/>	
				</td>
			</tr>
			
			<!-- Tipe tampilan menu -->
			<tr>
				<td class="djudul tooltip" title="Tipe ekstensi gambar" >Images Extention</td>
				<td>
					<select name='param2'>
					
					<option value="jpg" <?php echo @$ext1;?> >jpg</option>
					<option value="png" <?php echo @$ext2;?> >png</option>
					<option value="gif" <?php echo @$ext3;?> >gif</option>
					</select>			
				</td>
			</tr>

			<!-- Tipe tampilan menu -->
			<tr>
				<td class="djudul tooltip" title="Tipe ekstensi gambar" >Style</td>
				<td>
					<select name='param3'>
					<option value="1" <?php echo @$sty1;?> >Style 1</option>
					<option value="2" <?php echo @$sty2;?> >Style 2</option>
					</select>			
				</td>
			</tr>				
			<tr>
				<td class="djudul tooltip" title="Thumbnail akan terbentuk secara otomatis apabila<br>anda mengunggah gambar melalui Media Menager<br>dan terunggah pada folder <b>/files/.thumbs/</b>" > Folder Thumbnail</td>
				<td>
					<select name='param4'>
					<option value="1" <?php echo @$thumbs1;?> >Ya</option>
					<option value="0" <?php echo @$thumbs2;?> >Tidak</option>
					</select>			
				</td>
			</tr>
			
			<tr>
				<td class="djudul tooltip" title="Panjang gambar thumbnail">Thumbnail Width</td>
				<td>
					<input value="<?php echo @$thumbW; ?>" name="param5" type="text" size="5"/>	px
				</td>
			</tr>
			
			<tr>
				<td class="djudul tooltip" title="Lebar gambar thumbnail">Thumbnail Height</td>
				<td>
					<input value="<?php echo @$thumbH; ?>" name="param6" type="text" size="5"/>	px
				</td>
			</tr>
			
			<tr>
				<td class="djudul tooltip" title="Panjang kotak image scroll">Box Width</td>
				<td>
					<input value="<?php echo @$boxW; ?>" name="param7" type="text" size="5"/>	px
				</td>
			</tr>
			
			<tr>
				<td class="djudul tooltip" title="Lebar kotak image scroll">Box Height</td>
				<td>
					<input value="<?php echo @$boxH; ?>" name="param8" type="text" size="5"/>	px
				</td>
			</tr>
		</table>
	</div>
</div>
</li>