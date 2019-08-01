<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.txt
**/

defined('_FINDEX_') or die('Access Denied');

$article = Article::item($id);

if($article) :	
	$editable = "class=title";
	$editable2 = null;
	if($_SESSION['USER_LEVEL'] <= 3 OR (!empty($_SESSION['USER_EMAIL']) 
		AND $_SESSION['USER_EMAIL'] == $data['autmail'])) :
		$editable 	= ' class="title editordb" title="Click to edit"';
		$editable2 	= ' class="editordb" id="article-main"';
		
		$_SESSION["ARTICLE_EDITOR_$id"] = $article->article;
	?>				
		<div>
			<input type="hidden" value="<?php echo $id; ?>" id="article-id" />
			<input type="hidden" value="<?php echo $_SESSION["ARTICLE_EDITOR_$id"]; ?>" id="article-revert" />
		</div>
		<div id="editor-panel" > 
			<input type="submit" value="Save" style="display: none;" class="save editor-button" title="Save"/>	
			<input type="submit" value="Revert" style="display: none;" class="revert editor-button" title="Revert to last saved"/>	
		</div>		
	<?php endif; ?>

<div id="article">	

	<?php if($article->param->stitle) : ?>
		<h1 <?php echo $editable; ?>><?php echo $article->title; ?></h1>	
	<?php endif; ?>

	<?php if($article->param->tpanel) : ?>
		<div class='article-panel'>
		<?php echo $article->panel;
		loadModule('article-panel'); ?>
		</div>
	<?php endif; ?>
			
	<div class="article-main">
		<?php loadModule('article-top');  ?>
		<div class="article-warp">
			<div <?php echo $editable2; ?>>
				<?php echo $article->article; ?>
			</div>
			<a class='limit-editor-panel'></a>
		</div>	
	</div>		
	<div style="clear:both"> </div>	
	<?php if(!empty($article->param->bpanel)) : ?>
	<?php if($article->param->shits || $article->param->stag || $article->param->srate) : ?>	
	<div class='panel-bottom'>
		<?php if($article->param->shits) : ?>	
		<div class='article-read'>		
			<?php echo Reads;?> <?php echo '<b>'.$article->hits.'</b>';  ?> <?php echo times;?>	
		</div>	
		<?php endif; ?>				
		<?php if($article->param->srate) : ?>
		<div class='article-rating'>
		<span style='float:left'>Rates</span>
		<div class='box-rating'>
			<ul class='star-rating'> 
			  <li class="current-rating" id="current-rating" style="width:<?php echo $article->rate; ?>%"></li>
			  <?php if(!isset($_SESSION["article_rate_$id"]) or $article->voter == 0) :?>
			  <span id="ratelinks">
			  <li><a href="javascript:void(0)" title="1 star out of 5" class="one-star">1</a></li>
			  <li><a href="javascript:void(0)" title="2 stars out of 5" class="two-stars">2</a></li>
			  <li><a href="javascript:void(0)" title="3 stars out of 5" class="three-stars">3</a></li>
			  <li><a href="javascript:void(0)" title="4 stars out of 5" class="four-stars">4</a></li>
			  <li><a href="javascript:void(0)" title="5 stars out of 5" class="five-stars">5</a></li>
			  </span>
			  <?php endif; ?>
			</ul> 
		</div>
		<span class='valRates'>(<span><?php echo $article->voter ?></span> <?php if($article->voter<2) echo 'Vote'; else echo 'Votes'; ?>)</span>	
		</div>
		<?php endif; ?>
		<?php if($article->param->stag AND !empty($article->param->tags)) : ?>
		<div style="clear:both"> </div>
			<ul class="tags">
				<li class="tag">Tags : </li>
				<?php echo $article->tags; ?>
			</ul>
		<?php endif; ?>
	</div>	
	<?php endif; ?>
	
	<?php loadModule('article-mid'); ?>
	
	
	<?php if($article->param->sauthor) : ?>
	<div class='article-author'>
			
		<?php
		$autmail=	md5($article->autmail);
			echo "<span class='gravatar' data-gravatar-hash=\"$autmail\"></span>";
		?>
		<div class='author-nb'>
			<div class='author-name'><?php echo $article->author; ?></div>
			<div class='author-bio'><?php echo $article->autbio ; ?></div>
		</div>
	</div>
	<?php endif; ?>
	
	<?php endif; ?>
	<?php loadModule('article-bottom'); ?>
	
	<?php if($article->comment AND !checkModule('article-comment')) : ?>
	<div id="comment">	
		<?php 
			loadComment();
		?>
	<?php loadModule('article-comment'); ?>	
	</div>		
	<?php endif; ?>
	
</div>


<script>
$(function() {	
	$('.gravatar[data-gravatar-hash]').each(function () {
		var hash = $('.gravatar').attr('data-gravatar-hash');
		$.ajax({
			url: 'http://gravatar.com/avatar/'+ hash +'?size=100',
			type : 'GET',
			timeout: 5000, 
			error:function(data){
				$('.gravatar[data-gravatar-hash]').prepend(function(){
					var img = $(this).find("img").length ;
					if(img > 0) img.remove();
					var hash = $(this).attr('data-gravatar-hash');
					return '<img width="100" height="100" alt="" src="../apps/app_article/theme/images/stock.png" >'; 
				});	
			},
			success: function(data){
				$('.gravatar[data-gravatar-hash]').prepend(function(){
					var img = $(this).find("img").length ;
					if(img > 0) img.remove();
					var hash = $(this).attr('data-gravatar-hash');
					return '<img width="100" height="100" alt="" src="http://gravatar.com/avatar/' + hash + '?size=100">';
				});
			}
		});	
	});
	
	function getRating(){
		$.ajax({
			type: "POST",
			url: '<?php echo FUrl; ?>apps/app_article/controller/rating.php?=<?php echo MD5(getUrl()).MD5(FUrl);?>',
			data: 'id=<?php echo $id; ?>&do=getrate',
			cache: false,
			async: false,
			success: function(result) {
				$('#current-rating').css({ width: '' + result + '%' });
			},
			error: function(result) {
				
			}
		});
	}
		
	$('#ratelinks li a').click(function(){
		$.ajax({
			type: 'POST',
			url: '<?php echo FUrl; ?>/apps/app_article/controller/rating.php',
			data: 'id=<?php echo $id; ?>&rating='+$(this).text()+'&do=rate',
			cache: false,
			async: false,
			success: function(result) {
				$('#ratelinks').remove();
				var x = parseInt($('.valRates span').text(),10);
				++x;
				var v ='';
				if(x<2) v ='Vote'; else v = 'Votes';
				$('.valRates').html('('+x+' '+v+')');
				getRating();
			},
			error: function(result) {
			
			}
		});
	});
});	
	
</script>
<?php 
else :
	echo _404_;
endif;