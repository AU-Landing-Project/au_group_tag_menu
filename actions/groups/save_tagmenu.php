<?php
//save the tags to be used by tagmenu

	$guid = get_input("guid");
	if($entity = get_entity($guid)){
		if($entity instanceof ElggGroup && $entity->canEdit()){
			$tags = get_input("menu_tags");
			$entity->menu_tags = string_to_tag_array($tags);
			//save menu_position (top/bottom) - cannot work out how to implement this!
			//$entity->menu_position = get_input("menu_position");
			//save max tags
			$entity->menu_maxtags = get_input("menu_maxtags");
			//save it
			if (!$entity->save()) {
				register_error(elgg_echo("image:error"));
				forward(REFERER);
			}

//			forward($entity->getURL());
		}
	}
	forward(REFERER);