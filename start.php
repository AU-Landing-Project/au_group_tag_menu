<?php
/**
 * Group tag menu
 * allows tags to become menu items in groups
 * Jon Dron (jond@athabascau.ca)
 */

elgg_register_event_handler('init', 'system', 'au_group_tag_menu_init');

function au_group_tag_menu_init() {
	//add the tag menu at the top of the sidebar
	
//	elgg_extend_view('page/elements/sidebar','au_group_tag_menu/sidebar/tagmenu',get_menu_position());
	elgg_extend_view('groups/sidebar/search','au_group_tag_menu/sidebar/tagmenu',501);
	elgg_extend_view('page/elements/sidebar','au_group_tag_menu/sidebar/searchmenu',499);
//	elgg_extend_view('navigation/menu/elements/section','au_group_tag_menu/sidebar/tagmenu',499);

	// register group option to show tag menu
	// default is to not show it
	add_group_tool_option("tag_menu",elgg_echo("au_group_tag_menu:enable"),true);
	// add settings for tools
	elgg_extend_view('groups/edit','au_group_tag_menu/tagmenu_settings');

	elgg_register_action("au_group_tag_menu/groups/save_tagmenu", dirname(__FILE__) . "/actions/groups/save_tagmenu.php");
	//register the tag type for menu tags
	elgg_register_tag_metadata_name('menu_tags');

}

function get_menu_position(){
	$group = elgg_get_page_owner_entity();
	
	// we are in a group context	
	if(!empty($group) && elgg_instanceof($group, "group")){
		if($group->tag_menu_enable=="yes"){	
			//decide whether to put at top or bottom
			if ($group->menu_position=="top"){
				$position=499;
			}else{
				$position=501;
			}
		}
		return $position;
	} else {
	
		return 499;
		
	}	

}