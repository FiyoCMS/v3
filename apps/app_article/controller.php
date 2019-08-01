<?php
/**
* @name			Article System
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

defined('_FINDEX_') or die('Access Denied');

require('model/article.php');
function loadComment() {
	include_once ('apps/app_comment/index.php');
}


/****************************************/
/*			   SEF Article				*/
/****************************************/
$view = app_param('view');
$id = app_param('id');

if($id > 0) {
	$a = FQuery("article_category","id=$id",'',1); 
	if(!$a)
	$a = FQuery("article","id=$id",'',1); 
}
else if ((app_param('tag') != null)) {
	$a = app_param('tag');
}
else{
	$a = app_param('view');
}


if($a){ 
	if(SEF_URL AND !isHomePage()){
		if($view == 'item') {
			$icat = Article::articleInfo('category');
			$ncat = Article::categoryInfo('name');
			$page = menuInfo('id',"?app=article&view=item&id=$id");
			if(!$page)
				$page = menuInfo('id',"?app=article&view=category&id=$icat");
			$lcat = "$ncat";
			
			$i = 1;
			while(empty($page) AND !check_permalink('link',getLink()) AND $i < 10 AND !empty($lcat) AND $icat != 0) {	
				$icat = Article::categoryInfo('parent_id',$icat);
				$ncat = Article::categoryInfo('name',$icat);
				$page = menuInfo('id',"?app=article&view=category&id=$icat");
				if($icat == 0) break;
				$lcat = "$ncat/$lcat";
				$i++;
			}
			$lcat = strtolower($lcat);
			$item = Article::articleInfo('title');
			add_permalink($item,$lcat,$page);

			Site::setPageID($page);
		}
		else if($view == 'category' or $view == 'catlist') {	
			$icat = Article::categoryInfo('id');
			$ncat = Article::categoryInfo('name');
			$page = menuInfo('id',"?app=article&view=category&id=$icat");
			$lcat = "$ncat";
			
			$i = 1;
			while(empty($page) AND !check_permalink('link',getLink()) AND $i < 10 AND $icat != 0) {		
				$icat = Article::categoryInfo('parent_id',$icat);
				$ncat = Article::categoryInfo('name',$icat);
				$page = menuInfo('id',"?app=article&view=category&id=$icat");
				if($icat == 0) break;
				$lcat = "$ncat/$lcat";
				$i++;
			}
			$lcat = strtolower($lcat);
			$item = Article::articleInfo('title');
			if(app_param('feed') == 'rss')
				add_permalink("$lcat","","","rss");
			else
				add_permalink($lcat,'',$page);
				

			Site::setPageID($page);
		}
		else if($view == "archives") {
			if(app_param('feed') == 'rss')
				add_permalink("archives","","","rss");
			else
				add_permalink("archives");	
		}	
		else if($view == "featured") {
			if(app_param('feed') == 'rss')
				add_permalink("featured","","","rss");
			else
				add_permalink("featured");	
		}			
		else if (app_param('tag') != null) {	
			$tag = app_param('tag');
			if(app_param('feed') == 'rss')
				add_permalink("tag/$tag","","","rss");		
			else add_permalink("tag/$tag");
		}	
	}
}

/****************************************/
/*			 Article Title				*/
/****************************************/
if($id > 0) {
	$follow = true;
	$a = FQuery("article_category","id=$id",'',1); 
	if(!$a) {
		$a = FQuery("article","id=$id",'',1); 
		if(!$a) {
			$follow = false;
			define('MetaRobots',"noindex");
		}
	}
	else {
		if(app_param('view')=='featured')
			$a = 1;
		else 
			$follow = false;
	}
}

if($a){
	if(!isHomePage()) {	
		if ($view=="item") {
			define('PageTitle', Article::articleInfo('title'));			
			$desc = Article::articleInfo('description');
			if(!empty($desc)) 	
				define('MetaDesc', Article::articleInfo('description'));
			else
				define('MetaDesc', generateDesc(Article::articleInfo('article')));
			
			$keys = Article::articleInfo('keyword');		
			if(!empty($keys)) 	
				define('MetaKeys', $keys);
			else
				define('MetaKeys', generateKeywords(Article::articleInfo('article')));
			if(!$follow)
				$follow = 'noindex';
			else if(siteConfig('follow_link'))
				$follow = 'index, follow';
			else
				$follow = 'index, nofollow';
			
			define('MetaRobots',"$follow");
			
			$author = Article::articleInfo('author');
			if(empty($author)) 
				$author = oneQuery('user','id',Article::articleInfo('author_id'),'name');
			if(empty($author)) 
				$author = oneQuery('user','id',Article::articleInfo('editor'),'name');
			if(!empty($author))
				define('MetaAuthor',$author);

				$layout = Article::articleInfo('layout');
			if(!Article::articleInfo('layout'))
			$layout = menuInfo("layout", "?app=article&view=category&id=". Article::articleInfo('category'));
			
			if(!empty($layout))
				Site::setLayout($layout);
			
		}
		else if($view=="category" or $view=="catlist") {
			if(pageInfo(Page_ID,'name'))
				define('PageTitle', pageInfo(Page_ID,'name'));
			else
				define('PageTitle', Article::categoryInfo('name'));
			$desc = Article::categoryInfo('description');
			if(!empty($desc )) 
				define('MetaDesc', $desc);
			else
				
			$keys = Article::categoryInfo('keywords');
			if(!empty($keys)) 
				define('MetaKeys', $keys );
						
			$cat = app_param('id');
			$rowy = oneQuery("menu","link","'?app=article&view=category&id=$cat'");
			if(!$rowy)
				$rowy = oneQuery("menu","link","'?app=article&view=catlist&id=$cat'");
			if($rowy) {
				if(siteConfig('follow_link'))
					$follow = 'index, follow';
				else
					$follow = 'index, nofollow';
			}
			else
				$follow = 'noindex';
			define('MetaRobots',"$follow");
			
		}		
		else if($view=='archives')
			define('PageTitle', "Archives");
		else if($view=='featured')
			define('PageTitle', "Featured");
		else if (app_param('tag') != null)		{	
			define('PageTitle', $p = str_replace("-"," ",ucfirst(app_param('tag'))));
			define('Apps_Title', $p);
			
			}
	}
}
