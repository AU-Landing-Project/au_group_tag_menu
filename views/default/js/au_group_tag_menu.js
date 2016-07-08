define(['jquery'], function($) {
	
	$('input[type="hidden"].augtm').each(function(index, element) {
		var $form = $(element).parents('form').first();
		var val = $(element).val();
		
		// look for a guid input
		var $guid_input = $form.find('input[name="guid"]').first();
		
		var guid = 0;
		
		if ($guid_input && $guid_input.length) {
			guid = $guid_input.val();
		}
		
		// no guid, lets make the suggestion
		if (guid == 0) {
			var $tag_input = $form.find('input[type="text"][name="tags"]').first();
			if ($tag_input) {
				$tag_input.val(val);
			}
		}
	});
	
});