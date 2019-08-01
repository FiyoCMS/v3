<?php
/**
* @version		2.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

?>

<div class="box-left full">
	<div class="box">								
		<header class="dark">
			<h5></h5>
		</header>								
		<div>
			<table>
				
			
				<tr>
					<td>Judul</td>
					<td>
					<?php
						echo Form::text(
							'judul', 
							'', 
							["class" => "form-control", "required", "rows" => "4"]
						);
					?>
					</td>
				</tr>
				
				<tr>
					<td>Alamat</td>
					<td>
					<?php
						echo Form::date(
							'tanggal', 
							'', 
							["class" => "form-control", "required", "rows" => "4"]
						);
					?>
					</td>
				</tr>
				<tr>
					<td>Lokasi</td>
					<td>
					<?php
						echo Form::text(
							'lokasi', 
							'', 
							["class" => "form-control", "required", "rows" => "4"]
						);
					?>
					</td>
				</tr>
				<tr>
					<td>Deskripsi</td>
					<td>
					<?php
						echo Form::textarea(
							'deskripsi', 
							'', 
							["class" => "form-control", "required", "rows" => "4"]
						);
					?>
					</td>
				</tr>
				
			</table>			
		</div>  
	</div>
</div>
 
