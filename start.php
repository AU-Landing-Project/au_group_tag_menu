<?php
/**
 * Group tag menu
 * allows tags to become menu items in groups
 * Jon Dron (jond@athabascau.ca)
 * copyright Athabasca University 2013
 * GPL2 licence - see manifest.xml
 */

elgg_register_event_handler('init', 'system', 'au_group_tag_menu_init');

function au_group_tag_menu_init() {

	// add settings for tools
	elgg_extend_view('groups/edit','au_group_tag_menu/tagmenu_settings');

	//add the tag menu at the bottom of the sidebar
	elgg_extend_view('page/elements/sidebar','au_group_tag_menu/sidebar/tagmenu');

	// register group option to show tag menu
	add_group_tool_option("tag_menu",elgg_echo("au_group_tag_menu:enable"),true);

	//register action to save settings
	elgg_register_action("au_group_tag_menu/groups/save_tagmenu", dirname(__FILE__) . "/actions/groups/save_tagmenu.php");

	//register the tag type for menu tags
	elgg_register_tag_metadata_name('menu_tags');

	//register the page to show results
	elgg_register_page_handler('group_tag_menu', 'au_group_tag_menu_page_handler');



}



function au_group_tag_menu_page_handler($page,$identifier){
	
	//show the page of search results
	// assumes url of group/guid/tag
	// if the tag is 'all' then will display a tagcloud
	switch ($page[0]){
		case 'group':
			$entity=get_entity($page[1]);
			if (!elgg_instanceof($entity, 'group') || $entity->au_group_tag_menu_enable == 'no') {
				return false;
			}
			elgg_push_breadcrumb($entity->name, $entity->getURL());
			//should be OK if this is empty
			$tag=$page[2];
			elgg_push_breadcrumb($tag);
			if ($tag=="all"){
				//show a tag cloud for all group tags
				//arbitrarily set to a max of 640 tags - should be enough for anyone :-)
				$title = elgg_echo("au_group_tag_menu:tagcloud");
				$options = array(
							'container_guid' => $entity->getGUID(),
							'type' => 'object',
							'threshold' => 0,
							'limit' => 640,
							'tag_names' => array('tags'),
				//			'order_by' => 'tag ASC',
							);
				$thetags = elgg_get_tags($options);
				//make it an alphabetical tag cloud, not with most popular first
				sort($thetags);
				//find the highest tag count for scaling the font
				
				$max=0;
				foreach ($thetags as $key){
					if ($key->total>$max){
						$max=$key->total;
					}
					
				}
				$content = "  ";
				//loop through and generate tags so they display nicely
				//in the group, not as a dumb search page				
				foreach ($thetags as $key){
					$url = elgg_get_site_url()."group_tag_menu/group/".$entity->getGUID()."/". urlencode($key->tag);
					$taglink=elgg_view('output/url', array(
						'text' => ' '.$key->tag,
						'href' => $url,
						'title' => "$key->tag ($key->total)",
						'rel' => 'tag',
					));
					
					//  get the font size for the tag (taken from elgg's own tagcloud code - not sure I love this)
					$size = round((log($key->total) / log($max + .0001)) * 100) + 30;
					if ($size < 100) {
						$size = 100;
					}
					// generate the link 
					$content.=" <a href='$url' style='font-size:$size%'>".$key->tag."</a> &nbsp; ";
					
				}

				
			}else{
				//show the results for the selected tag
				$title = elgg_echo("au_group_tag_menu:title")."$tag";
				$options = array(	'type'=>'object',
									'metadata_name' => 'tags',
									'metadata_value'=>$tag, 
									'container_guid'=>$entity->guid,
									'full_view'=>false,);
				$content= elgg_list_entities_from_metadata ($options);

			}
			//display the page
			if (!$content) {
					$content = elgg_echo('au_group_tag_menu:noresults');
			}
			
			$layout = elgg_view_layout('content', array(
									'title' => elgg_view_title($title),
									'content' => $content,
									'filter' => false,)
									);
			
			echo elgg_view_page($title, $layout);
			break;	
	}
	return true;
	
}

