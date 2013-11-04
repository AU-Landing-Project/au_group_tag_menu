<?php
/**
 * au_group_tag_menu
 * get settings for the tag menu
 * need the tags themselves
 * to limit results to a specific user's posts
*/

	//get current settings
	$group = elgg_get_page_owner_entity();

	if(!empty($group) && elgg_instanceof($group, "group")){
		// build form to enter tags
		if (!$group->menu_tags){
			//populate with top existing group tags
			$options = array(
			'container_guids' => $group->getGUID(),
			'types' => 'object',
			'threshold' => 0,
			'limit' => 5,
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
		$form_body.="<p>".elgg_echo('au_group_tag_menu:tagblurb')."</p>";
		$form_body.= elgg_view('input/tags', array(
			'name' => 'menu_tags',
			'id' => 'menu_tags',
			'value' => $menutags,
		));
		$form_body.="</div><div>";
		//select the number of tags to show if using auto menu	
		$form_body.="<label for='menu_maxtags'>".elgg_echo('au_group_tag_menu:maxtags')."</label> ";
		$menumax= $group->menu_maxtags;
		$options=array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','15'=>'15','20'=>'20','25'=>'25','30'=>'30','40'=>'40','50'=>'50');		
		$form_body.=elgg_view("input/dropdown", array ("name"=>"menu_maxtags",
														"id"=>"menu_maxtags",
														"options_values"=>$options,
														"value" => $menumax,
														));		
		$form_body.="</p>";
		$form_body.="</div>";
		$form_body .= "<div class='elgg-foot'>";
		$form_body .= elgg_view("input/hidden", array("name" => "guid", "value" => $group->getGUID()));
		$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
		$form_body .= "</div>";
		$title = elgg_echo("au_group_tag_menu:settings");
		$body = elgg_view("input/form", array("action" => $vars["url"] . "action/au_group_tag_menu/groups/save_tagmenu", "body" => $form_body));
		
		echo elgg_view_module("info", $title, $body);

	}
// to do at some point - select specific user, select specific type of post to show

