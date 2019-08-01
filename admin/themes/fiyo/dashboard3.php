<?php
/**
* @version		2.0.2
* @package		Fiyo CMS
* @copyright	Copyright (C) 2015 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

?>
<div id="app_header">
	<div class="warp_app_header">		
		<div class="app_title">Dashboard</div>
		<div class="app_link">
			
		</div> 	
	</div>
</div>
<div style="padding-bottom: 10px; width: 100%;">
<div class="col-lg-12 full">	
	<div class="box graph">								
		<header>
			<a class="accordion-toggle" data-toggle="collapse" href="#page-configuration">
				<h5>Data Absensi Harian</h5>
			</a>
		</header>								
		<div id="page-configuration" class="in">
			<div id="statistic"><div class="loading">Loading...</div>
			</div>	
		</div>
	</div>
	
	<div class="box statistic">	
		<div class="mini-box box-1 online-user"><h3><span class="data">Loading...</span><i class="icon-circle"></i></h3><span><?php echo Online_Visitor;?></span><i class="icon icon-bullseye"></i>
		</div>
		<div class="mini-box box-2 today-visitor"><h3>Loading...</h3><span><?php echo Today_Visitor;?></span><i class="icon icon-calendar-empty"></i>
		</div>
		<div class="mini-box box-3 monthly-visitor"><h3>Loading...</h3><span><?php echo Monthly_Visitor;?></span><i class="icon icon-calendar"></i>
		</div>
		<div class="mini-box box-4 total-visitor"><h3>Loading...</h3><span><?php echo Total_Visitor;?></span><i class="icon icon-signal"></i>
		</div>
	</div>	
</div>
<div class="clearfix"></div>
<div class="col-lg-6 box-left">	
	<div class="box">								
		<header>			
			<a class="accordion-toggle" data-toggle="collapse" href="#article-box">
			</a>	
			<ul class="nav nav-tabs">
			  <li class="active"><a data-target="#latest" data-toggle="tab" class='article-latest'>
			  Data Absensi</a></li>
			  <li><a data-target="#popular" data-toggle="tab" class='article-popular'>
			  Data Mangkir </a></li>
			  <li><a data-toggle='tooltip' data-placement='top' title='<?php echo New_Article;?>' href="?app=article&act=add"><i class="icon-pencil"></i></a></li>
			</ul>	
		</header>								
		<div id="article-box" class="in">
		<!-- Tab panes -->
			<div class="tab-content">
			  <div class="tab-pane active" id="latest"><div id="article-latest">		  
				<table class="table  tools">
				  <tbody>
					<?php	
					/*
						$usr = FDBPrefix."user";
						$art = FDBPrefix."article";
						$sql = DB::table($art)
							->select("*,DATE_FORMAT(date,'%W, %b %d %Y') as dates, $art.id as aid")
							->orderBy("$art.date DESC LIMIT 10")
							->leftJoin($usr,"$usr.id = $art.author_id")
							->get(); 
						$no = 0;		
						foreach($sql as $row) {
							$no++;			
							$read = check_permalink("link","?app=article&view=item&id=$row[id]","permalink");
							if($read) $read = FUrl.$read; else $read = FUrl."?app=article&view=item&id=$row[aid]";
							$edit = "?app=article&act=edit&id=$row[aid]";
							$info = "$row[date]";
							$read_article = Read;
							$edit_article = Edit;
							echo "<tr><td class='no-tabs'>#$no</td><td width='100%'>$row[title] <a class='tooltips icon-time' title='$info' data-placement='right'></a> 
							<div class='tool-box'>
								<a href='$read' target='_blank'  class='btn btn-tools tips' title='$read_article'>$read_article</a>";				
							$editor_level 	= mod_param('editor_level',$row['parameter']);
							if($editor_level >= USER_LEVEL or empty($editor_level)) echo "<a href='$edit' class='btn btn-tools tips' title='$edit_article'>$edit_article</a>";
							echo "</div>			
							</td></tr>";
						}	
						if($no == 0) { 
							echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".No_Article."</td></tr>";
						}	*/			
						?>				
					   </tbody>			
				</table>			  			  
			  </div></div>
			  <div class="tab-pane" id="popular"><div id="article-popular">
			   <div style="height:60px"><div class="loading">Loading...</div></div>
			   </div></div>
			  <div class="tab-pane" id="write">  
				<textarea rows="8" placeholder="What's on your mind?" class="form-control" required></textarea>
				<footer> 
				<input placeholder="<?php echo Title;?>" required type="text" class="form-control"></textarea>
					<a href="#">Daftar konsep yang tersimpan</a> &nbsp;
					<button class="btn btn-default btn-sm btn-grad">Simpan ke Editor Lengkap</button>
					<button class="btn btn-success btn-sm btn-grad"><?php echo Save.' '.Draft;?></button>
				</footer>
			  </div>
			</div>
		</div>
	</div>		
</div>


<div class="col-lg-6 box-right">	
	<div class="box">								
		<header>
			<a class="accordion-toggle" data-toggle="collapse" href="#comment-box">
				<h5>Cuti Terbaru</h5>
			</a>
		</header>								
		<div id="comment-box" class="in">			
		<div class="tab-pane active" id="home">
			<div class="comment">

<table class="table table-striped tools">
  <tbody>
	<?php	
		$user_id = USER_ID;
		if($_SESSION['USER_LEVEL'] > 3)
			$sql = DB::table(FDBPrefix."cuti")
				->select("*,DATE_FORMAT(tanggal_cuti,'%W, %b %d %Y') as dates")
				->orderBy('tanggal_cuti DESC')
				->limit(10)
				->leftJoin(FDBPrefix.'pregawai',FDBPrefix.'pregawai.id_pegawai = '.FDBPrefix.'cuti.id_pegawai')
				->get();
		else
			$sql = DB::table(FDBPrefix."cuti")
				->select("*,DATE_FORMAT(tanggal_cuti,'%W, %b %d %Y') as dates")
				->orderBy('tanggal_cuti DESC LIMIT 10')
				->get(); 
				
		$no = 0;	
		/*	
		foreach($sql as $row) {					
			$id = $row['id_cuti'];
			$auth = $row['nama_pegawai'];
			$info = $row['tanggal_cuti'];
			$imgr = md5("");
			$foto = " <span class='c_gravatar' data-gravatar-hash=\"$imgr\"></span>";
			$comment = cutWords(htmlToText($row['comment']),10);
			$hide = Hide;
			$cedit = Edit;
			$read = Read;
			$delete = Delete;
			$approve = Approve;
			$app = link_param('app',"$row[link]");	
			$aid = link_param('id',"$row[link]");	
			$app = "$row[apps]";
			if(empty($app)) $app = 'article';
			$lread = check_permalink("link","?app=article&view=item&id=$aid","permalink");
			$edit = "?app=$app&view=comment&act=edit&id=$id";			
			$title = oneQuery('article','id',$aid ,'title');			
			$red = '';

			if($row['status']) 
				$approven = "<a class='btn-tools btn btn-danger btn-sm btn-grad disable-comment' title='$hide' data-id='$id'>$hide</a><a class='btn-tools btn btn-success btn-sm btn-grad approve-comment' title='$approve' style='display:none;' data-id='$id'>$approve</a>";
			else {
				$approven = "<a data-id='$id' class='btn-tools btn btn-success btn-sm btn-grad approve-comment' title='$approve'>$approve</a><a data-id='$id' class='btn-tools btn btn-danger btn-sm btn-grad disable-comment' title='$hide'  style='display:none;'>$hide</a>";
				$red = "class='unapproved'";
			}

			echo "<tr $red><td style='text-align: center; vertical-align: middle;  padding: 7px 8px 6px 10px;'>$foto</td><td style='width: 97%; padding: 7px 8px 8px 0;'><b>$row[name]</b> <span>on</span> $title <a data-toggle='tooltip' data-placement='right' title='$info' class='icon-time tooltips'></a> <a data-toggle='tooltip' data-placement='left' title='$row[email]' class='icon-envelope-alt tooltips'></a>
			<br/><span>$comment ...</span><br/>
			<div class='tool-box tool-$no'>
				$approven
				<a href='$edit' class='btn btn-tools tips' title='$cedit'>$cedit</a>
				<a href='../$lread#comment-$row[id]' target='_blank'  class='btn btn-tools tips' title='$read'>$read</a>
				<!--a class='btn btn-tools tips' title='$delete'>$delete</a-->
			</div>
			</td></tr>";
			$no++;	
		}
		if($no < 1) { 
			echo "<tr><td style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'>".No_Comment."</td></tr>";
		}*/
	?>
    </tbody>			
</table>
			</div>	
		</div>
		</div>
	</div>		
	
</div>
</div>
<script language="javascript" type="text/javascript">
$(function () {	
	function loader(target) {
		$(target+ ' .loading').remove();
		$(target).prepend("<div class='loading'>Loading</div>");	
	}
	
	function loaded(target) {
		$(target+ ' .loading').fadeOut('fast');
		setInterval(function(){
			$(target+ ' .loading').remove();
		}, 1000);
	}
	

	function updateStat() {	
		$.ajax({
			url: "?api=theme&module=statistic_data",
			data: "access",
			success: function(data){
				$("#statistic").html(data.html);				
				updateOnline();	
			}
		});
	}	
		
	function updateOnline() {	
		$.ajax({
			url: "<?php echo FAdminPath; ?>/module/statistic_online.php",
			data: "access",
			success: function(data){
                var json = $.parseJSON(data);
				$(".online-user .data").html(json.online);
				$(".today-visitor h3").html(json.today);
				$(".monthly-visitor h3").html(json.month);
				$(".total-visitor h3").html(json.total);
				if(json.online > 0)
				$(".online-user h3 i").addClass('blink');
				else
				$(".online-user h3 i").removeClass('blink');
			}
		});
	}
	
		
	$('.article-popular').click(function(){	
		loadArticlePopular();	
	});
	$('.article-latest').click(function(){	
		loadArticleLatest(true);
	});
	
	$('.member-log').click(function(){	
		loadMemberLog();	
	});
	
	$('.member-online').click(function(){
		loadMemberOnline();	
	});
	
	$('.member-new').click(function(){	
		loadNewMember();
	});	
	
	updateStat();
	var dt = new Date();
	var cH = dt.getHours();
	
	
	pingVisitor = setInterval(function(){
		updateOnline();	
		var dS = new Date();
		var uH = dS.getHours();
		if(uH != cH) {
			updateStat();
			cH = uH;
		}
	}, 1000*10);	
	function loadFeeds() {	
		$.ajax({
			timeout: 8000, 
			type : 'GET',
			url: "<?php echo FAdminPath; ?>/module/feeds.php",
			success: function(data){
				$(".feed").html(data);
			},
			error : function(data){
				$(".feed").html("<div style='text-align:center; padding: 40px 0; color: #ccc; font-size: 1.5em'><?php echo Failed_to_connect_server; ?></div>");
				
			}
		});
	}
	loadFeeds();
	$('.c_gravatar[data-gravatar-hash]').each(function () {
	var th = $(this);
	var hash = th.attr('data-gravatar-hash');
	$.ajax({
		url: 'http://gravatar.com/avatar/'+ hash +'?size=32' ,
		type : 'GET',
		timeout: 5000, 
		error:	function(data){			
			th.html('<img width="32" height="32" alt="" src="../apps/app_comment/images/user.png" >');	
		},
		success: function(data){
			th.html('<img width="32" height="32" alt="" src="http://gravatar.com/avatar/' + hash + '">');
		}
	});
	});
	
	
	$('.approve-comment').click(function() {
		var btn = $(this);
		$.ajax({
			url: "apps/app_article/controller/comment_status.php",
			data: "stat=1&id="+btn.data('id'),
			success: function(data){
				btn.parents("tr").removeClass('unapproved');
				btn.hide();
				btn.parent().find('.disable-comment').show();
			}
		});		
	});
	$('.disable-comment').click(function() {
		var btn = $(this);
		$.ajax({
			url: "apps/app_article/controller/comment_status.php",
			data: "stat=0&id="+btn.data('id'),
			success: function(data){
				btn.parents("tr").addClass('unapproved');
				btn.hide();
				btn.parent().find('.approve-comment').show();
			}
		});
	});
	
	$('.approve-user').click(function() {
		var is = $(this);
		var id = $(this).data('id');
		$.ajax({
			url: "apps/app_user/controller/status.php",
			data: "stat=1&id="+id,
			success: function(data){						
				is.parents("tr").removeClass('unapproved');
				is.hide();
				is.parent().find('.disable-user').show();
			}
		});		
	});
	
	$('.disable-user').click(function() {
		var is = $(this);
		var id = $(this).data('id');
		$.ajax({
			url: "apps/app_user/controller/status.php",
			data: "stat=0&id="+id,
			success: function(data){
				is.parents("tr").addClass('unapproved');
				is.hide();
				is.parent().find('.approve-user').show();
			}
		});	
	});
});
</script>