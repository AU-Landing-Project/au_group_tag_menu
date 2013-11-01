<?php
/**
 * tagmenu display for sidebar
*/

$group = elgg_get_page_owner_entity();
$user = elgg_get_logged_in_user_entity();
$container=get_input('container_guid');

// are we in a group context?	
if(!empty($group) && elgg_instanceof($group, "group")){
	if($group->tag_menu_enable=="yes"){		
		$groupname = $group->name;
		if (!$group->menu_tags){
			// use default tags for the group
			if (!$group->menu_maxtags){
				$maxtags=10;
			}else{
				$maxtags=$group->menu_maxtags;
			}		
			$options = array(
			'container_guids' => $group->getGUID(),
			'types' => 'object',
			'threshold' => 0,
			'limit' => $maxtags,
			'tag_names' => array('tags'),
			'order_by' => 'tag ASC',
			);
			$tags=elgg_get_tags($options);
			sort($tags);
		}else {
			//use owner-set tags
			$tags=$group->menu_tags;

		}	
		$body='<ul class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-default">';
		//  different arrays depending on whether tag cloud or saved menu tags	
		if (!$group->menu_tags){
			//using standard group tags
			foreach ($tags as $key){
				$url = "search?q=". urlencode($key->tag) . "&search_type=tags&container_guid=$group->guid";
				$taglink=elgg_view('output/url', array(
					'text' => $key->tag,
					'href' => $url,
					'title' => "$key->tag ($key->total)",
					'rel' => 'tag',
				));
					$body.='<li>'.$taglink.'</li>';	
			}	
		} else {
			//using menu tags
			foreach ($tags as $key){
				$url = "search?q=". urlencode($key) . "&search_type=tags&container_guid=$group->guid";
				$taglink=elgg_view('output/url', array(
					'text' => $key,
					'href' => $url,
					'title' => "$key->tag ($key->total)",
					'rel' => 'tag',
				));
					$body.='<li>'.$taglink.'</li>';	
			}	
		
		}				
		$body .= "</ul>";
		echo elgg_view_module('aside', elgg_echo('au_group_tag_menu:menu'), $body);
	} else {
		return true;
	}		
} else {
		
	return true;
}	

// if we are in search context, indicate all search for tidyness
if($container && elgg_get_context('search')){
	echo elgg_view_module('aside', elgg_echo('au_group_tag_menu:searchall'), '');
		
}