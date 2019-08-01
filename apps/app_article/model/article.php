<?php
/**
* @version		3.0
* @package		Fiyo CMS
* @copyright	Copyright (C) 2017 Fiyo CMS.
* @license		GNU/GPL, see LICENSE.
**/

class Article {	
	static function item($id, $output = 'object') {
		if(self::articleInfo('id',$id)) {		
			$sql = DB::table(FDBPrefix."article")->select("*,
			DATE_FORMAT(date,'%W, %d %M %Y %H:%i') as time,
			DATE_FORMAT(date,'%Y-%m-%d %H:%i:%s') as timer,
			DATE_FORMAT(date,'%d %M %Y') as date,
			DATE_FORMAT(date,'%W') as D,
			DATE_FORMAT(date,'%d') as f,
			DATE_FORMAT(date,'%b') as b,
			DATE_FORMAT(date,'%a') as a,
			DATE_FORMAT(date,'%D') as d,
			DATE_FORMAT(date,'%m') as n,
			DATE_FORMAT(date,'%M') as m,
			DATE_FORMAT(date,'%y') as y,
			DATE_FORMAT(date,'%Y') as Y,
			DATE_FORMAT(date,'%h') as h,
			DATE_FORMAT(date,'%H') as H,
			DATE_FORMAT(date,'%p') as p,
			DATE_FORMAT(date,'%i') as i,
			DATE_FORMAT(date,'%s') as s")->where("id=$id AND status=1 LIMIT 1")->get();
			$row = $sql[0];	
			
			if($row) {		
				$category 	= self::categoryInfo('name',$row['category']);
				$catLevel 	= self::categoryInfo('level',$row['category']);
				$catLink	= self::categoryLink($row['category']);
				if(!empty($row['author_id'])) {
					$author		= userInfo('name',$row['author_id']);
					if(empty($author)) $author = "Administrator";		
					$autMail	= userInfo('email',$row['author_id']);	
					$autBio		= userInfo('about',$row['author_id']);	
				}
				else {		
					$author		= 'Administrator';				
					$autMail	= "-";	
					$autBio		= "Bio";	
				}	
					
							
				if($autBio === true) $autBio = "Sorry, no description about me.";
				$autBio	 	= str_replace("\n","<br>",$autBio);	
				
				
				if(!empty($row['author'])) $author = $row['author'];
					
				self::articleHits($row['hits']);			
				$tag 		= mod_param('tags',$row['parameter']);
				$sdate 		= mod_param('show_date',$row['parameter']);
				$shits 		= mod_param('show_hits',$row['parameter']);
				$srate 		= mod_param('show_rate',$row['parameter']);
				$tpanel		= mod_param('panel_top',$row['parameter']);
				$bpanel		= mod_param('panel_bottom',$row['parameter']);
				$stag		= mod_param('show_tags',$row['parameter']);
				$voter 		= mod_param('rate_counter',$row['parameter']);
				$rate 		= mod_param('rate_value',$row['parameter']);
				$stitle 	= mod_param('show_title',$row['parameter']);
				$sauthor 	= mod_param('show_author',$row['parameter']);
				$comment	= mod_param('show_comment',$row['parameter']);
				$scategory 	= mod_param('show_category',$row['parameter']);
				$catLinks	= self::categoryLink($row['category']);	
				$catHref	= "<a href='$catLinks'>$category</a>";
				
				$fpanel = "*" . menu_param('panel_format',Page_ID);
				$panel = str_replace('%rel',"",$fpanel);
				if(empty($panel) or !strpos($panel,'%')) {
					$a = "<b>%A</b>  &#183;";
					if(!$sauthor) $a = '';
					if(siteConfig('lang') == 'id')
					$date = "%f %m %Y &#183;";
					else
					$date = "%m, %f %Y &#183;";
					if(!$sdate) $date = '';
					if(siteConfig('lang') == 'id')
					$panel = "$a $date %c";
					else
					$panel = "$date $a %c";
					
				}
				$panel = str_replace('%A',"$author",$panel);
				
				if($scategory) 
					$panel = str_replace('%c',"$catHref",$panel);
				else
					$panel = str_replace('&#183; %c','',$panel);
				if(!$sdate AND !$scategory) {
					$panel = str_replace('&#183;','',$panel);
					$panel = str_replace('%c','',$panel);
				}
					
				$panel = str_replace('%h',$row['hits'],$panel);
				
				$timeRel = dateRelative($row['H'],$row['i'],$row['s'],$row['n'],$row['f'],$row['Y']);
				if($timeRel AND strpos($fpanel,'%rel')) {
					$panel = str_replace(', ',"",$panel);
					$panel = str_replace('%d',"",$panel);
					$panel = str_replace('%b',"",$panel);
					$panel = str_replace('%f',"$timeRel",$panel);
					$panel = str_replace('%m',"",$panel);
					$panel = str_replace('%n',"",$panel);
					$panel = str_replace('%y',"",$panel);
					$panel = str_replace('%Y',"",$panel);
					$panel = str_replace('%H',"",$panel);
					$panel = str_replace('%h',"",$panel);
					$panel = str_replace('%i',"",$panel);
					$panel = str_replace('%s',"",$panel);
					$panel = str_replace('%p',"",$panel);
					if(strlen($panel) < 3 )
					$panel   =  $timeRel;
				}
				else {
					if(siteConfig('lang') == 'id')
						$panel = str_replace('%f',$row['f'],$panel);
					else
						$panel = str_replace('%f',$row['d'],$panel);
				
					$panel = str_replace("%rel",$panel,$panel);
					$panel = str_replace('%d',$row['d'],$panel);
					$panel = str_replace('%D',$row['D'],$panel);
					$panel = str_replace('%b',$row['b'],$panel);
					$panel = str_replace('%a',$row['a'],$panel);
					$panel = str_replace('%m',$row['m'],$panel);
					$panel = str_replace('%n',$row['n'],$panel);
					$panel = str_replace('%y',$row['y'],$panel);
					$panel = str_replace('%Y',$row['Y'],$panel);
					$panel = str_replace('%H',$row['H'],$panel);
					$panel = str_replace('%h',$row['h'],$panel);
					$panel = str_replace('%i',$row['i'],$panel);
					$panel = str_replace('%s',$row['s'],$panel);
					$panel = str_replace('%p',$row['p'],$panel);
				}
				$panel = str_replace('*',"",$panel);
				$panel = str_replace('*',"",$panel);
								
				/* voter */
				if(!is_numeric($voter) or !is_numeric($rate)) $voter = 0;
				$rate = (@round($rate / $voter,1)) * 20; 
				/* tags */
				$tags = null;
				if(!empty($row['tags'])) {
					$tags = self::tagToLink($row['tags'], true);		
				}
				
				$article = $row['article'];
				if(checkLocalhost()) {
					$article = str_replace(FLocal."media/","media/",$article);
					$article = str_replace("/media/",FUrl."media/",$article);			
				}
				
				/* perijinan akses artikel */				
				if(USER_LEVEL > $catLevel AND USER_LEVEL > $row['level']) {
					return false;
				}
				else {
                    $data = [
                    'param'    => (object)[
                        'stag'		=> $stag,	
                        'sdate'		=> $sdate,
                        'sauthor'	=> $sauthor,
                        'scategory'	=> $scategory,
                        'shits'		=> $shits,	
                        'srate'		=> $srate,			
                        'stitle'	=> $stitle,
                        'tpanel'	=> $tpanel,
                        'bpanel'	=> $bpanel,	
                    ],
					'category'	=> $category,
					'catlink'	=> $catLink,
					'author'	=> $author,
					'autmail'	=> $autMail,
					'autbio'	=> $autBio,
					'title'		=> $row['title'],
					'day' 		=> $row['f'],
					'month' 	=> $row['m'],
					'year' 		=> $row['y'],
					'hits' 		=> digit($row['hits']),
					'comment'	=> $comment,
					'panel'		=> $panel,
					'tags'		=> $tags,	
					'rate'		=> $rate,	
					'voter'		=> $voter,	
					'article'	=> $article,
                    ];
                    
                    if($output == 'array')
                        return $data;
                    else if($output == 'object')
                        return (object)$data;
                    else if($output == 'json')
                        return json_encode(['status' => 'ok', $data]);
				}
			}
		}
	}

	public static function category($type, $id = null,$format = null) {
		$link = null;
		/* Set global parameter */
		$show_panel	= menu_param('show_panel',Page_ID);
		$show_rss	= menu_param('show_rss',Page_ID);
		$read_more  = menu_param('read_more',Page_ID);
		$per_page	= menu_param('per_page',Page_ID);
		$intro		= menu_param('intro',Page_ID);
		$format		= menu_param('format');
		

		if(empty($intro)) $intro = $per_page;
		
		/* Set Access_Level */
		$accessLevel = Level_Access;
		
		if($type == 'archives')  {	
			$where = "status=1";
		} 
		else if($type == 'category')  {
			$catName = self::categoryInfo('name',$id);
			$catDesc = self::categoryInfo('description',$id);
			$catLink  = self::categoryLink($id);	
			$where = "status=1 AND category = $id";
		}
		else if($type == 'featured') {
			$where = "status=1 AND featured = 1";
		
		}
		else if($type == 'tag') {
			if(empty($per_page))
				$per_page = 10;
			$tag = app_param('tag');
			$tag = str_replace("-"," ",$tag);
			$where = "status=1 AND tags LIKE '%".$tag."%'";
			
			$db = new FQuery();
			if(!oneQuery('article_tags','name',"$tag"))
			$qr=$db->insert(FDBPrefix.'article_tags',array("","$tag","","1"));
			else
			$db->update(FDBPrefix.'article_tags',array('hits'=> '+hits'),"name='$tag'");
		}

		if($type == 'rss') {
			$per_page = 20;
			$pages = url_param('page');
			if($pages != null) {
				$link = str_replace("?page=$pages","",getUrl());
				redirect("$link?feed=rss");					
			}
		}		
			
		loadPaging();		
		$paging = new Paging();
		
		$result = $paging->pagerQuery(FDBPrefix.'article',"*,
		DATE_FORMAT(date,'%d %M %Y') as date,
		DATE_FORMAT(date,'%Y-%m-%d %H:%i:%s') as order_date,
		DATE_FORMAT(date,'%a, %m %d %Y %H:%i:%s') as time,
		DATE_FORMAT(date,'%d') as f,
		DATE_FORMAT(date,'%D') as d,
		DATE_FORMAT(date,'%b') as b,
		DATE_FORMAT(date,'%a') as a,
		DATE_FORMAT(date,'%W') as D,
		DATE_FORMAT(date,'%m') as n,
		DATE_FORMAT(date,'%M') as m,
		DATE_FORMAT(date,'%y') as y,
		DATE_FORMAT(date,'%Y') as Y,
		DATE_FORMAT(date,'%h') as h,
		DATE_FORMAT(date,'%H') as H,
		DATE_FORMAT(date,'%p') as p,
		DATE_FORMAT(date,'%i') as i,
		DATE_FORMAT(date,'%s') as s","$where $accessLevel",'order_date DESC',$per_page);
		
		$no = 0;
        $o = new stdClass();
		$perrows =  count($result);		
		foreach($result as $row) {
		
			/* Category Details */		
			$catLinks	= self::categoryLink($row['category']);					
			$category	= self::categoryInfo('name',$row['category']);
			$catHref	= "<a href='$catLinks'>$category</a>";
			
			/* Author */			
			if(empty($row['author'])) {
				if(!empty($row['author_id']))
				$author = userInfo('name',$row['author_id']);
				if(empty($author))
				$author = "Administrator";
			}
			else  {
				$author = $row['author'];
			}
			
			/* Article Links */
			$link	= "?app=article&amp;view=item&amp;id=$row[id]";	
			$vlink  = str_replace("&amp;","&",$link);
			$vlink  = make_permalink($vlink);
				
			/* Article Title */				
			$title 	= "<a href='$vlink'>$row[title]</a>";
			
			$link  	= $vlink;
				
			/* Article Tags */
			$tags 	= self::tagToLink($row['tags']);
				
			/* Article Content */
			$article = $row['article'];	
			
			if(checkLocalhost()) {
				$article = str_replace(FLocal."media/","media/",$article);
				$article = str_replace("/media/",FUrl."media/",$article);		
			}	
			
			$comment = null;
			/* Article Comments */
			
	
			$comm = FQuery('comment',"link='$link'AND status=1");
			if(FQuery('apps',"folder='app_comment'")) { 
				$comment =  "<a class='send-comment' href='$link#comment'>";
				if($comm > 1) $comment .= "<span>$comm</span> ".Comments;
				if($comm ==1) $comment .= "<span>$comm</span> ".Comment; 
				if($comm < 1) $comment .= Send_Comment;
				$comment .= "</a>";
			}
			$scomment	= mod_param('show_comment',self::articleInfo('parameter',$row['id']));
			if(!$scomment) $comment = '';
			
			/* Read More */
			if(empty($read_more)) $read_more= Readmore;
			$readmore = "<a href='$link' class='readmore'>$read_more</a> $comment";	
			
			/* Intro limit (read more) */			
			$content = $article;	
			
            $data = [];
			/* Blog Style */
            $image = null;
			$imgH  = menu_param('imgH',Page_ID);
			$imgW  = menu_param('imgW',Page_ID);	
			if($format == 'blog' or $type == 'tag' or $format == 'list' or $format == 'grid') {
				$image	= self::articleImage($content);	

				$image2	= str_replace("/media","/media/.thumbs",$image);				
				if(file_exists($image2)) $image = $image2;
                $data['content'][$no]['image']	= $image;		
				$content = preg_replace("/<img[^>]+\>/i", "", $content);
				
			}
			$content = self::articleIntro($content);	
					
				$panel	= menu_param('panel_format',Page_ID);
				$fpanel = "#" . menu_param('panel_format',Page_ID);
				$dpanel = str_replace('%rel',"",$fpanel);
				$ctname = strtolower($category);
				if(empty($panel) or !strpos($dpanel,'%')) {
					if($format == 'grid')
					$panel = "<span class='author-link'><b>%A</b>,</span> <date><span>%f</span> <span>%m</span> <span>%Y</span>  &#183;</date> <span class='category-link category-$ctname'>%c</span>";
					else if(siteConfig('lang') == 'id')
					$panel = "<span class='author-link'><b>%A</b> &#183;</span> <date><span>%f</span> <span>%m</span> <span>%Y</span></date> &#183; <span class='category-link category-$ctname'>%c</span>";
					else
					$panel = "<date>%m, %f %Y &#183;</date> <span class='author-link'><b>%A</b> &#183;</span> <span class='category-link category-$ctname'>%c</span>";					
				}
				$panel = str_replace('%A',$author,$panel);
				
				$panel = str_replace('%c',"$catHref",$panel);
					
				$panel = str_replace('%h',$row['hits'],$panel);				
				
				$timeRel = dateRelative($row['H'],$row['i'],$row['s'],$row['n'],$row['f'],$row['Y']);

				if($timeRel AND strpos($fpanel,'%rel')) {
					$panel = str_replace(', ',"",$panel);
					$panel = str_replace('%d',"",$panel);
					$panel = str_replace('%f',"$timeRel",$panel);
					$panel = str_replace('%m',"",$panel);
					$panel = str_replace('%n',"",$panel);
					$panel = str_replace('%y',"",$panel);
					$panel = str_replace('%Y',"",$panel);
					$panel = str_replace('%H',"",$panel);
					$panel = str_replace('%h',"",$panel);
					$panel = str_replace('%i',"",$panel);
					$panel = str_replace('%s',"",$panel);
					$panel = str_replace('%p',"",$panel);
					if(strlen($panel) < 3 )
					$panel   =  $timeRel;
				}
				else {
					if(siteConfig('lang') == 'id')
						$panel = str_replace('%f',$row['f'],$panel);
					else
						$panel = str_replace('%f',$row['d'],$panel);
						
					$panel = str_replace("%rel",$panel,$panel);
					$panel = str_replace('%d',$row['d'],$panel);
					$panel = str_replace('%a',$row['a'],$panel);
					$panel = str_replace('%b',$row['b'],$panel);
					$panel = str_replace('%m',$row['m'],$panel);
					$panel = str_replace('%n',$row['n'],$panel);
					$panel = str_replace('%y',$row['y'],$panel);
					$panel = str_replace('%Y',$row['Y'],$panel);
					$panel = str_replace('%H',$row['H'],$panel);
					$panel = str_replace('%h',$row['h'],$panel);
					$panel = str_replace('%i',$row['i'],$panel);
					$panel = str_replace('%s',$row['s'],$panel);
					$panel = str_replace('%p',$row['p'],$panel);
				}
			$panel = str_replace('*',"",$panel);	
			
			if($format == 'grid');			
			/* RSS Feed */	
            $o->panel[$no]   = $panel;
            $o->category[$no]   = $category;
            $o->catlink[$no]    = $catLinks;
            $o->readmore[$no]	= $readmore;
            $o->comment[$no]	= $comment;
            $o->author[$no]	    = $author;
            $o->title[$no] 	    = $title;
            $o->link[$no] 		= $link;
            $o->tags[$no]		= $tags;
            $o->ftime[$no]		= $row['time'];
            $o->hits[$no]		= $row['hits'];
            $o->desc[$no]	    = clearXMLString("$content");
            $o->ftitle[$no] 	= clearXMLString($row['title']);
            $o->article[$no]    = $content;
            $o->image[$no]	    = $image;


			if(defined('SEF_URL')) {		
				$link = link_paging('?');
				if (strpos(getUrl(),'&') > 0)  {			
					$link = link_paging('&');
				}				
			}
			else if(isHomePage())  {
				$link = "?";
			}
			else if(!url_param('id'))  {			
				$tag  = app_param('tag');
				$link = "?app=article&tag=$tag";	
				$link = make_permalink($link,Page_ID);
				$link = $link."&amp;";
			}
			else {		
				$link="?app=article&view=category&id=$categoryId";	
				$link = make_permalink($link,Page_ID);
				$link = $link."&amp;";		
			}				
			$no++;
		}
        $data['content'] = $o;
			
		
		$imgH  = menu_param('imgH',Page_ID);
		$imgW  = menu_param('imgW',Page_ID);
        //parameter
        $data['param'] =  (object)[
             'imgH'	=> $imgH,				
             'imgW' => $imgW,	
             'intro' => $intro,
             'perrows' => $perrows,
             'show_rss' => $show_rss,
             'show_panel' => $show_panel];

		// pageLink	
        $data['pagelink'] = $paging->createPaging($link);
		
		// rssLink
		if($type == 'tag')		{	
			$tag = str_replace(" ","-",$tag);	
			$rssLink = "?app=article&tag=$tag&feed=rss";	
		}
		else if($type == 'category')	{
			$rssLink = "?app=article&view=category&id=$id&feed=rss";	
		}
		else {
			$rssLink = "?app=article&view=archives&feed=rss";	
		}
		
		if(_FEED_ == 'rss') {
			$rssLink = make_permalink($rssLink);			
			$categoryLink = @clearXMLString($rssLink);
			$categoryLink = str_replace(".xml","",$categoryLink);
            
            $data['rssTitle'] = @clearXMLString(SiteTitle);
			$data['rssLink']  	= $categoryLink;
			$data['rssDesc']  	= @$categoryDesc;	
		}
		else {
			$data['rssLink']  	=  make_permalink($rssLink);
		}


        if(isset($data['content']))
        return (object)$data;

	}	



    public static function articleInfo($output,$id = null) {
        if(empty($id)) $id = app_param('id');
        $output = oneQuery('article','id',$id ,$output);
        return  $output;
    }

    public static function articleParameter($value) {	
        $menu_id = Page_ID;
        $param	 = pageInfo($menu_id ,'parameter');
        $param	 = mod_param($value,$param);
        return 1;
    }

    public static function articleHits($vid) {
        $id = app_param('id');
        DB::table(FDBPrefix.'article')->where('id='.$id)->update(['hits'=>'+hits']);	
    }

    public static function categoryInfo($output, $id = null) {
        if(empty($id)) 
            if(app_param('view') == 'item')
                $id = self::articleInfo('category');
            else
                $id = app_param('id');		
        $output = oneQuery('article_category','id',$id ,$output);
        return  $output;
    }

    public static function categoryLink($value) {
        $link = make_permalink("?app=article&view=category&id=$value");
        return $link ;
    }


    private static function itemLink($value) {
        $link = make_permalink("?app=article&view=item&id=$value");
        return $link ;
    }

    static function tagToLink($tgs, $hits = null) {
		$tgs =json_decode($tgs);
        if(empty($tgs)) return 
			false;
        	$tags = null;		
        foreach($tgs as $tag) {			
            $ltag = str_replace(" ","-",$tag);	
            $ltag = "?app=article&tag=$ltag";	
            $ltag = make_permalink($ltag);
            $tags .= "<li><a href='$ltag' alt='See article for tag $tag'>$tag</a></li>";
            if($hits){
                if(!oneQuery('article_tags','name',"$tag"))
                DB::table(FDBPrefix.'article_tags')->insert("","$tag","","1");
                else
                DB::table(FDBPrefix.'article_tags')->where("name='$tag'")->update(array('hits' => '+hits'));			
            }		
        }
        return $tags;
    }

    public static function articleIntro($article) {
        $article = str_replace('"',"'",$article);
        $article = str_replace('&nbsp;'," ",$article);
        $limit = strpos("$article","<hr id=");	
        if(empty($limit)) 
        $limit = strpos("$article","<div style='page-break-after: always");	
        if(!empty($limit))
            return substr("$article",0,$limit);
        else 
            return substr("$article",0);
    }

    public static function articleImage($article) {
        $opentag = strpos($article,"<img");
        if($opentag) {
            $closetag = substr($article,$opentag);
            $closetag = strpos($closetag,">");
            $image = substr($article,$opentag,$opentag+$closetag);
            $a = strpos($image,'src="');
            
            if(empty($a)) 
                $a = strpos($image,"src='");
                
            $b = substr($image,$a+5);					
            $c = strpos($b,'"');
            if(empty($c))$c = strpos($b,"'");
            return  substr($image,$a+5,$c);					
        }	
        else return false;
    }
        

}
