<?php

namespace AU\GroupTagMenu;

// group_tag_menu default settings
// can choose whether defaults to on or off

if (!isset($vars['entity']->tagmenu_defaulton)){
	$vars['entity']->tagmenu_defaulton = 'yes';
}

echo '<div>';
echo elgg_echo('au_group_tag_menu:defaulton').' ';
echo elgg_view('input/dropdown', array(
	'name' => 'params[tagmenu_defaulton]',
	'options_values' => array(
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes')
	),
	'value' => $vars['entity']->tagmenu_defaulton,
));
echo '</div>';


if (!isset($vars['entity']->tagmenu_autopopulate)) {
	$vars['entity']->tagmenu_autopopulate = 'yes';
}

echo '<div>';
echo elgg_echo('au_group_tag_menu:autopopulate') . ' ';
echo elgg_view('input/dropdown', array(
		'name' => 'params[tagmenu_autopopulate]',
		'options_values' => array(
				'no' => elgg_echo('option:no'),
				'yes' => elgg_echo('option:yes')
		),
		'value' => $vars['entity']->tagmenu_autopopulate,
));
echo '</div>';

if ($vars['entity']->tagmenu_autopopulate != 'yes') {
	echo elgg_view_field([
		'#type' => 'dropdown',
		'#label' => elgg_echo('au_group_tag_menu:suggest'),
		'name' => 'params[tagmenu_suggest]',
		'value' => $vars['entity']->tagmenu_suggest,
		'options_values' => [
			'no' => elgg_echo('option:no'),
			'yes' => elgg_echo('option:yes')
		],
		'#help' => elgg_echo('au_group_tag_menu:suggest:help')
	]);
}