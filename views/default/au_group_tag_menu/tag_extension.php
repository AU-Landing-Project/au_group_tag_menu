<?php

namespace AU\GroupTagMenu;

if ($vars['name'] != 'tags') {
	return; // only want to deal with default tags
}

if ($vars['value']) {
	return; // already has a value set
}

$group = elgg_get_page_owner_entity();
if (!$group instanceof \ElggGroup) {
	return;
}

if (!$group->menu_tags) {
	return;
}

if (elgg_get_plugin_setting('tagmenu_autopopulate', PLUGIN_ID) == 'no') {
	return;
}

// so there's no value, and it's group content
// but we have no way to tell if we're editing existing tagless content
// or creating new content.  So we'll store our tags in a hidden input here, and use js
// to determine the rest and inject our value if necessary

echo elgg_view('input/hidden', [
		'name' => $vars['name'] . '_augtm[]',
		'value' => implode(', ', $group->menu_tags),
		'class' => 'augtm'
]);

?>
<script>
	require(['au_group_tag_menu']);
</script>