<?php
/**
 * get settings for the tag menu
 * need the tags themselves
 * to limit results to a specific user's posts
*/

//get current settings
	//$group = elgg_extract("entity", $vars);
	$group = elgg_get_page_owner_entity();

	if(!empty($group) && elgg_instanceof($group, "group")){
		// build form
		if (!$group->menu_tags){
			//populate with existing group tags
			$options = array(
			'container_guids' => $group->getGUID(),
			'types' => 'object',
			'threshold' => 0,
			'limit' => 20,
			'tag_names' => $group->tags,
			'order_by' => 'tag ASC',
			);
			$menutags=elgg_get_tags($options);
		} else {
			//populate with group menu tags
			$menutags = $group->menu_tags;
		}
		$form_body="<div>";
		$form_body.="<label for='group_tags'>".elgg_echo('au_group_tag_menu:tags')."</label>";
		$form_body.= elgg_view('input/tags', array(
			'name' => 'menu_tags',
			'id' => 'menu_tags',
			'value' => $menutags,
		));
	// cannot figure out how to control position of menu so commented out this bit
	//	$form_body.="<label for='group_menu_position'>".elgg_echo('au_group_tag_menu:menuposition')."</label>";
		//drodown box for top/bottom menu - may extend later if I can figure out alternative positions!
	//	$options=array('top'=>'top','bottom'=>'bottom');		
	//	$form_body.=elgg_view("input/dropdown", array ("name"=>"menu_position",
	//													"id"=>"menu_position",
	//													"options_values"=>$options,
	//													));		
		$form_body.="<label for='group_menu_maxtags'>".elgg_echo('au_group_tag_menu:maxtags')."</label>";
		//drodown box for top/bottom menu - may extend later if I can figure out alternative positions!
		$options=array('5'=>'5','10'=>'10','15'=>'15','20'=>'20','30'=>'30','50'=>'50');		
		$form_body.=elgg_view("input/dropdown", array ("name"=>"menu_maxtags",
														"id"=>"menu_maxtags",
														"options_values"=>$options,
														));		

		$form_body.="</div>";
		$form_body .= "<div class='elgg-foot'>";
		$form_body .= elgg_view("input/hidden", array("name" => "guid", "value" => $group->getGUID()));
		$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
		$form_body .= "</div>";
		$title = elgg_echo("au_group_tag_menu:settings");
		$body = elgg_view("input/form", array("action" => $vars["url"] . "action/au_group_tag_menu/groups/save_tagmenu", "body" => $form_body));
		
		echo elgg_view_module("info", $title, $body);

	}
//show tag entry form


//select user from group - default is all

