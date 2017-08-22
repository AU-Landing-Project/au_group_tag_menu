<?php

namespace AU\GroupTagMenu;

if ($vars['name'] != 'tags') {
	return; // only want to deal with default tags
}

$group = elgg_get_page_owner_entity();
if (!$group instanceof \ElggGroup) {
	return;
}

if (!$group->menu_tags) {
	return;
}

if (elgg_get_plugin_setting('tagmenu_autopopulate', PLUGIN_ID) !== 'no') {
	return;
}

if (elgg_get_plugin_setting('tagmenu_suggest', PLUGIN_ID) != 'yes') {
	return;
}

$tags = (array) $group->menu_tags;
?>
<div class="au-tag-menu-suggestions-title elgg-text-help hidden">Group Tag Suggestions</div>
<div class="au-tag-menu-suggestions">
	<?php foreach ($tags as $tag): ?>
	<span data-auTag="<?= $tag ?>" class="hidden"><a href="javascript:void(0)" class="au-tag-suggestion">+<?= $tag ?></a> </span>
	<?php	endforeach; ?>
</div>
<script>
	require(['au_group_tag_suggestions']);
</script>





















