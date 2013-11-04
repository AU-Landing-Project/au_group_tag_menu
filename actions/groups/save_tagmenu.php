<?php
//save the tags to be used by tagmenu



$guid = get_input("guid");
if($entity = get_entity($guid)){
	if($entity instanceof ElggGroup && $entity->canEdit()){
		$tags = get_input("menu_tags");
		//special tag type used for specified tag menu items
		$entity->menu_tags = string_to_tag_array($tags);
		//save max tags
		$entity->menu_maxtags = get_input("menu_maxtags");
		//save it
		if (!$entity->save()) {
			register_error(elgg_echo("au_group_tag_menu:saveerror"));
			forward(REFERER);
		}
	}
}
forward(REFERER);