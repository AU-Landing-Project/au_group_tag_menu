<?php
/**
 * tagmenu display for sidebar
 * @uses container_guid
*/

$group = elgg_get_page_owner_entity();
$user = elgg_get_logged_in_user_entity();
$container=get_input('container_guid');

// are we in a group context?	
if(!empty($group) && elgg_instanceof($group, "group")){
	//making this appear by default. Admin can change this to default to off if not wanted in settings 
	if((!$group->tag_menu_enable=="no" && elgg_get_plugin_setting('tagmenu_defaulton')!='no')||($group->tag_menu_enable=="yes")){		
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
			// make alphabetical
			sort($tags);			
		}else {
			//use owner-set tags. Do not sort - need to show in correct order
			$tags=$group->menu_tags;
			
		}	
		


		//start setting up the owner block - note this 
		//is emulating the menu - needs to be separate from the actual menu
		 
		$body='<ul class="elgg-menu elgg-menu-owner-block elgg-menu-owner-block-default">';
		
		//add the title link that points to the group tagcloud ('all' is a special tag)
		$url = elgg_get_site_url()."group_tag_menu/group/".$group->guid."/all";
		$body.="<li><a href='$url'><strong>".elgg_echo('au_group_tag_menu:menu')."</strong></a></li>";
		
		//as yet unused option to display as a tag cloud
		if ($group->menu_showastagcloud && !$group->menu_tags){
			
			$body .= elgg_view_tagcloud(array(
						'$container_guids'=> $group->getGUID(),
						'types'=>'object',
						'threshold' => 0,
						'limit' => $maxtags,
						'tag_names' => array('tags'),
						));
		}
		
		//  different arrays depending on whether tag cloud or saved menu tags	
		if (!$group->menu_tags){
			//using standard group tags so we have a tag cloud - multi-dimensional array
			foreach ($tags as $key){
				$url = "group_tag_menu/group/".$group->guid."/". urlencode($key->tag);
				$taglink=elgg_view('output/url', array(
					'text' => ' - '.$key->tag,
					'href' => $url,
					'title' => "$key->tag ($key->total)",
					'rel' => 'tag',
				));
					$body.='<li>'.$taglink.'</li>';	
			}	
		} else {
			//using menu tags so we just have a simple array of tags to read in
			foreach ($tags as $key){
				$url = "group_tag_menu/group/".$group->guid."/". urlencode($key);
				$taglink=elgg_view('output/url', array(
					'text' => ' - '.$key,
					'href' => $url,
					'title' => "$key",
					'rel' => 'tag',
				));
					$body.='<li>'.$taglink.'</li>';	
			}	
		
		}			
		$body .= "</ul>";
		
		//display the results
		echo elgg_view_module('aside', "", $body);
	
	} else {
		return true;
	}		
	
} else {
	//this is not a group so do nothing		
	return true;
}	
