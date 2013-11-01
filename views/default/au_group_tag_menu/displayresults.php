<?php
/**
 * displays page of results for selected tag
*/
$group = elgg_get_page_owner_entity();
$user = elgg_get_logged_in_user_entity();
$container=get_input('container_guid');

// are we in a group context?	
if(!empty($group) && elgg_instanceof($group, "group")){
	if($group->tag_menu_enable=="yes"){		

	//get parameter - should be a tag
	$tag=get_input('tag');
	//get entities that match the tag
	$resultlist=elgg_get_entities_from_metadata(array(
		'type' => 'object',
		'metadata_name' => 'tags',
		'metadata_value' => $tag,
		'container_guid' => $container,
		'full_view' => FALSE;
	));
	
	//output the list
	$body="<div>";
	$body.=elgg_list_entities($guids=>$resultlist->guid);
	$body.="</div>";

	} else {
		return true;
	}	
} else {
	return true;
}		