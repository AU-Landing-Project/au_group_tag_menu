<?php
// add return to group option in search bar

$group = elgg_get_page_owner_entity();
$user = elgg_get_logged_in_user_entity();
$container=get_input('container_guid');
$tag=get_input('q');
// we are in a search context
if($container && elgg_get_context('search')){
	//there is a group in the search term
	$group=get_entity($container);
	$groupname = $group->name;
	$url="groups/profile/$container";
	$body=elgg_echo('au_group_tag_menu:return');
	$body.= elgg_view('output/url', array(
		'text' => $groupname,
		'href' => $url,
		'title' => elgg_echo('au_group_tag_menu:return').$groupname,
		));
	$title=	elgg_view('output/url', array(
		'text' => elgg_echo('au_group_tag_menu:searchresults', array($tag)).$groupname,
		'href' => $url,
		'title' => elgg_echo('au_group_tag_menu:return').$groupname,
		));
	//try to sustain the group context
	set_input ('container_guid', $container);	
	echo elgg_view_module('aside', $title, $body);
	// show the rest of the search stuff with a meaningful heading
	echo elgg_view_module('aside', elgg_echo('au_group_tag_menu:searchall').': '.$tag, '');

}else {
	//debug
}	