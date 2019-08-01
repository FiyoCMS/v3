<?php
/**
* @version		2.0
* @package		Fi ImageSlider
* @copyright	Copyright (C) 2012 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
* @description	
**/

defined('_FINDEX_') or die('Access Denied');

$type = mod_param('type',modParam);
$folder = mod_param('folder',modParam);
$theme = mod_param('theme',modParam);
$effect = mod_param('effect',modParam);
$imgW = mod_param('imgW',modParam);
$imgH = mod_param('imgH',modParam);
$slideD = mod_param('slideD',modParam);
$effectD = mod_param('effectD',modParam);
$strecth = mod_param('strecth',modParam);

if($type=="jpg"){$ext1="selected";}
if($type=="png"){$ext2="selected";}
if($type=="gif"){$ext3="selected";} 


?>

<input type="hidden" value="9" name="totalParam"/>
<input type="hidden" value="folder" name="nameParam1"/>
<input type="hidden" value="type" name="nameParam2"/>
<input type="hidden" value="theme" name="nameParam3"/>
<input type="hidden" value="effect" name="nameParam4"/>
<input type="hidden" value="imgW" name="nameParam5"/>
<input type="hidden" value="imgH" name="nameParam6"/>
<input type="hidden" value="slideD" name="nameParam7" />
<input type="hidden" value="effectD" name="nameParam8" />
<input type="hidden" value="strecth" name="nameParam9" />

<div class="panel box">								
	<header>
		<a data-parent="#accordion" class="accordion-toggle" data-toggle="collapse" href="#article_list">
				<h5>ImageSlider Configuration</h5>
		</a>
	</header>
	<div id="article_list" class="in">
		<table class="data2">
			<!-- Menampilkan menu menurut kategori pilihan -->	
			<tr>
				<td  class="row-title"><span class="tips" title="Pilih folder pada folder media/">Path Folder</td>
				<td>
					<input value="<?php echo @$folder; ?>" name="param1" type="text" size="20"/>	
				</td>
			</tr>
			
			<!-- Tipe tampilan menu -->
			<tr>
				<td  class="row-title"><span class="tips" title="Tipe ekstensi gambar" >Tipe Gambar</td>
				<td>
					<select name='param2'>
					
					<option value="jpg" <?php echo @$ext1;?> >jpg</option>
					<option value="png" <?php echo @$ext2;?> >png</option>
					<option value="gif" <?php echo @$ext3;?> >gif</option>
					</select>			
				</td>
			</tr>	
			<tr>
				<td  class="row-title"><span class="tips" title="Thumbnail akan terbentuk secara otomatis apabila<br>anda mengunggah gambar melalui Media Menager<br>dan terunggah pada folder <b>/files/.thumbs/</b>" >Slide Theme</td>
				<td>
					<select name='param3'>
					<option value="1" <?php if(@$theme==1) echo'selected';?>>Theme 1</option>
					<option value="2" <?php if(@$theme==2) echo'selected';?>>Theme 2</option>
					<option value="3" <?php if(@$theme==3) echo'selected';?>>Theme 3</option>
					<option value="4" <?php if(@$theme==4) echo'selected';?>>Theme 4</option>
					<option value="5" <?php if(@$theme==5) echo'selected';?>>Theme 5</option>
					<option value="6" <?php if(@$theme==6) echo'selected';?>>Theme 6</option>
					<option value="7" <?php if(@$theme==7) echo'selected';?>>Theme 7</option>
					<option value="8" <?php if(@$theme==8) echo'selected';?>>Theme 8</option>
					</select>			
				</td>
			</tr>
			
			<tr>
				<td  class="row-title"><span class="tips" title="Thumbnail akan terbentuk secara otomatis apabila<br>anda mengunggah gambar melalui Media Menager<br>dan terunggah pada folder <b>/files/.thumbs/</b>" >Slide Effect</td>
				<td>
					<select name='param4'>
					<option value="basic" <?php if(@$effect=='basic') echo 'selected';?>>Basic</option>
					<option value="squares" <?php if(@$effect=="squares") echo 'selected';?>>Squares</option>
					<option value="fades" <?php if(@$effect=='fades') echo 'selected';?>>Fades</option>
					<option value="7" <?php if(@$effect==7) echo 'selected';?> >Fly</option>
					<option value="blast" <?php if(@$effect=='blast') echo 'selected';?>>Blast</option>
					<option value="kenburns" <?php if(@$effect=='kenburns') echo 'selected';?>>Kenburns</option>
					</select>			
				</td>
			</tr>
			<tr>
				<td  class="row-title"><span class="tips" title="Thumbnail akan terbentuk secara otomatis apabila<br>anda mengunggah gambar melalui Media Menager<br>dan terunggah pada folder <b>/files/.thumbs/</b>" >Image(s) Strecth</td>
				<td>
					<select name='param9'>
					<option value="0" <?php if(@$strecth==0) echo 'selected';?>>No</option>
					<option value="1" <?php if(@$strecth==1) echo 'selected';?>>Yes</option>
					</select>			
				</td>
			</tr>
			
			<tr>
				<td  class="row-title"><span class="tips" title="Panjang gambar slide">Image Width</td>
				<td>
					<input value="<?php echo @$imgW; ?>" class="numeric" name="param5" type="text" size="5"/>	px
				</td>
			</tr>
			
			<tr>
				<td  class="row-title"><span class="tips" title="Lebar gambar slide">Image Height</td>
				<td>
					<input value="<?php echo @$imgH; ?>" class="numeric" name="param6" type="text" size="5"/> px
				</td>
			</tr>
			
			<tr>
				<td  class="row-title"><span class="tips" title="Durasi perpindahan antar gambar satu dengan yang lain">Slide Duration</td>
				<td>
					<input value="<?php echo @$slideD; ?>" class="numeric" name="param7" type="text" size="5"/>
				</td>
			</tr>
			
			<tr>
				<td  class="row-title"><span class="tips" title="Transisi gambar slide">Effect Duration</td>
				<td>
					<input value="<?php echo @$effectD; ?>" class="numeric" name="param8" type="text" size="5"/>
				</td>
			</tr>
		</table>
	</div>
</div>