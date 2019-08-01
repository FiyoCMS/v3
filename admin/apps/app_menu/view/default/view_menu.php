<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2014 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');
printAlert();

?>
<script type="text/javascript">	

$(function() {	
	$(".activator label").click(function(){ 
		var parent = $(this).parents('.switch');
		var id = $('#id',parent).attr('value');	
		var value = $('#type',parent).val();
		if(value == 1) value = 0; else value = 1;
		$.ajax({
			url: "?app=menu&api=status&stat="+value+"&id="+id,
			success: function(data){
				notice(JSON.parse(data));		
			}
		});
	});
			
	$(".home label.cb-enable").click(function(){
		$('.home label').addClass('selected');
		$('.home label.cb-enable').removeClass('selected');
		var parent = $(this).parents('.switch');
		var id = $('#id',parent).attr('value');
		var cat = $('#id',parent).data('category');	
		var type = $('#type',parent).attr('value');			
		$.ajax({
			url: "?app=menu&api=status",
			data: "home=1&id="+id,
			success: function(data){						
				$('.home-label').remove();
				$('.menu .menu-'+cat+' a').append("<span class='label label-danger home-label'>home</span>");
				notice(data);		
				$(this +'.cb-disable').addClass('selected');				
			}
		});			
	});
		
	$(".cb-enable").click(function(){		
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);	
	});
	$(".activator .cb-disable").click(function(){		
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);	
	});
		
		
	$("#form").submit(function(e){
		e.preventDefault();
		var ff = this;
		var checked = $('input[name="check[]"]:checked').length > 0;
		if(checked) {	
			$('#confirmDelete').modal('show');	
			$('#confirm').on('click', function(){
				ff.submit();
			});		
		} else {
			noticeabs("<?php echo alert('error',Please_Select_Menu); ?>");
			$('input[name="check[]"]').next().addClass('input-error');
			return false;
		}
	});		

	var ns = $('.sortable').nestedSortable({
				forcePlaceholderSize: true,
				handle: 'div',
				helper:	'clone',
				items: 'li',
				opacity: .6,
				placeholder: 'placeholder',
				revert: 250,
				tabSize: 25,
				tolerance: 'pointer',
				toleranceElement: '> div',
				maxLevels: 4,
				isTree: true,
				expandOnHover: 700,
				startCollapsed: false,
				change: function(){
				},
				relocate: function(){					
					var hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
					j = JSON.stringify(hiered); 
					$.ajax({
						url: "?app=menu&api=arranger",
						data: 'data='+j,
						success: function(data){
							notice(JSON.parse(data));	
						}
					});	
				}
			});
	$(".filterText").keyup(function(){
		var v = $(this).val();
		$(".sortable.arrange_menu li:not(:contains("+v+"))" ).closest( ".sortable.arrange_menu li" ).hide();

		c =$("a.menu-name:contains("+v+")").length;

		$(".sortable.arrange_menu li:contains("+v+")" ).closest( ".sortable.arrange_menu li" ).css( "display", "block" );
		$( ".count" ).html($(".sortable.arrange_menu li:visible" ).length + "");
	});
	
			
});	

</script>
<form method="post" id="form">
	<div id="app_header">
		<div class="warp_app_header">		
			<div class="app_title">Menu Manager</div>
			<div class="app_link">			
				<a class="add btn btn-primary" href="?app=<?php echo $app['root']; ?>&act=add" title="<?php echo Add_New_Menu; ?>"><i class="icon-plus"></i>  <?php echo New_Menu; ?></a>
				<button type="submit" class="delete btn btn-danger btn-grad" title="<?php echo Delete; ?>" value="<?php echo Delete; ?>" name="delete"><i class="icon-trash"></i> &nbsp;<?php echo Delete; ?></button>
				
				<span class="filter-table visible-lg-inline-block filter-notable">
					<div>
						<input type="text" size="50" class="filterText" placeholder="
						<?php echo Search; ?>...">
					<i class="icon-search"></i>
					</div>				
				</span>
				<input type="hidden" value="true" name="delete_confirm" style="display:none" />				
		 </div> 	
		</div>
	</div>
			
		<ol class="sortable arrange_menu">
			<?php			
			//start query to get home page value.
			$cat_default = oneQuery('menu','home',1,'category');
			if(!empty($cat_default)) $cat_default =" AND category='$cat_default'"; 
			$tb1 = FDBPrefix.'menu';
			$tb2 = FDBPrefix.'user_group';	
			if(isset($_REQUEST['cat'])) {
				$cat = $_REQUEST['cat'];
				$sql = DB::table($tb1)
					->select("$tb1.id,category,name,parent_id,status,short,
						$tb1.level,home,title,show_title,group_name,layout,app")
					->where("parent_id=0 AND category='$cat'")
					->orderBy("short ASC")
					->leftJoin($tb2,"$tb2.level= $tb1.level")
					->get();				
				}
			else {
				$cat = $_REQUEST['cat'] = null;				 				 
				$sql = DB::table($tb1)
					->select("$tb1.id,category,name,link,parent_id,status,short,
						$tb1.level,home,title,show_title,group_name,layout,app")
					->where("parent_id=0 $cat_default")
					->orderBy("short ASC")
					->leftJoin($tb2,"$tb2.level= $tb1.level")
					->get();			
			}
			
			$no=1;				
			foreach($sql as $row){
				if($row['status']==1)
				{ $stat1 ="selected"; $stat2 =""; $enable = ' enable';}							
				else
				{ $stat2 ="selected";$stat1 =""; $enable = 'disable';}
				
				$status ="
					<div class='switch s-icon activator'>
					<label class='cb-enable tips $stat1' data-placement='right' title='".Disable."'><span>
					<i class='icon-remove-sign'></i></span></label>
					<label class='cb-disable tips $stat2' data-placement='right' title='".Enable."'><span>
					<i class='icon-check-circle'></i></span></label>
					<input type='hidden' value='$row[id]' id='id' class='invisible'>
					<input type='hidden' value='$row[status]' id='type' class='invisible'>
				</div>";					
				
				/* change home page */
				if($row['home']==1)
				{ $hm = "selected"; $hms = ""; }							
				else
				{ $hm = ""; $hms = "selected"; }		
				$home ="
				<div class='switch s-icon home'>
					<label class='cb-enable tips $hm' data-placement='left' title='".Set_as_home_page."'><span>
					<i class='icon-home'></i></span></label>
					<label class='cb-disable tips $hms' data-placement='left' title='".As_home_page."'><span>
					<i class='icon-home'></i></span></label>
					<input type='hidden' value='$row[id]' id='id' data-category='$row[category]' class='invisible'>
					<input type='hidden' value='stat' id='type' class='invisible'>
				</div>";		
				/* change default page */				
				if($row['layout']==1)
				{ $dm = "selected"; $dms = ""; }							
				else
				{ $dm = ""; $dms = "selected"; }		

				$default ="
					<div class='switch s-icon star'>
						<label class='cb-enable tips $dm' title='".Set_as_default_page."'><span>
						<i class='icon-star'></i>
						</span></label>
						<label class='cb-disable tips $dms' title='".As_default_page."'><span>
						<i class='icon-star'></i></span></label>
						<input type='hidden' value='$row[id]' class='invisible' id='id'>
						<input type='hidden' value='fp' id='type' class='invisible'>
					</div>";		

				$level = "
					<span>
						
					</span>";
					
				$filter = strtolower($row['name']);
				$name ="<a class='tips menu-name' title='".Edit."' data-placement='right' href='?app=menu&act=edit&id=$row[id]' data-filter='$filter'>$row[name]</a>";
				
				$checkbox ="<input type='checkbox' data-name='rad-$row[id]' sub-target='.sub-menu' name='check[]' value='$row[id]' rel='ck'>";

				//creat user group values	
				if($row['level']==99) {		
					$level = _Public;
				} 
				else 
				{
					$level = $row['group_name']; 
				}
				if($row["category"] == "adminpanel") {
					$home = $default = null;
				}
				echo "<li id='menuItem_$row[id]'><span style='display:none;'>$filter</span>";
				echo "<div data-id='$no' class='box'><header>$checkbox $name 				

				<div class='switch-group hidden-xs'> 
					<div class='switch s-icon'>
					<label class='cb-default'><span><i class='icon-users'></i> $level</span></label>
					</div>	
				</div>
				
				<div class='switch-group hidden-xs'> 
					<div class='switch s-icon'>
					<label class='cb-default'><span><i class='icon-link'></i> $row[app]</span></label>
					</div>	
				</div>

				<div class='switch-group hidden-xs'> 
					<div class='switch s-icon'>
					<label class='cb-default'><span><i class='icon-book'></i> $row[category]</span></label>
					</div>	
				</div>

				<div class='switch-group'>$home$status</div>
				</span></header>";
				echo "</div>";
				sub_menu($row['id'],'',$no);
				echo "</li>";
			$no++;	
			}			
			?>		
	</ol>
</form>

<script>


</script>