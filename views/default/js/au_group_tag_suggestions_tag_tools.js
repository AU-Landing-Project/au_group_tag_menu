define(['jquery', "jquery.tag-it"], function($) {

    var AUtagSuggestionInit = function() {
        var $form = $('.au-tag-menu-suggestions').parents('form').first();
        var $tag_input = $form.find('input[type="text"][name="tags"]').first();
        var valueArray = $tag_input.tagit("assignedTags");

        // hide any that are already in the values
        $('.au-tag-menu-suggestions > span').show();
        $.each(valueArray, function(index, tag) {
            $('.au-tag-menu-suggestions').find('span[data-auTag="'+ tag +'"]').hide();
        });
        
        // if all are hidden, hide the title, otherwise show the title
        $form.find('.au-tag-menu-suggestions-title').hide();
        $('.au-tag-menu-suggestions > span').each(function(index, elem) {
            if ($(elem).is(':visible')) {
                $form.find('.au-tag-menu-suggestions-title').show();
            }
        });
    };
    
    $(document).on('keyup change', 'input[type="text"][name="tags"]', function(e) {
        AUtagSuggestionInit();
    });
	
    $(document).on('click', '.au-tag-suggestion', function(e) {
       e.preventDefault();
       
       var $form = $('.au-tag-menu-suggestions').parents('form').first();
       var $tag_input = $form.find('input[type="text"][name="tags"]').first();
       var valueArray = $tag_input.tagit("assignedTags");
       
       var $parent = $(this).parent();
       var tag = $parent.attr('data-auTag');
       
       // hide the element
       $parent.hide();
       
       valueArray.push(tag);
       
       // remove duplicates
       valueArray = valueArray.reverse().filter(function (e, i, arr) {
            return arr.indexOf(e, i+1) === -1;
        }).reverse();
        
        valueArray = valueArray.filter(function(v) {
            return v !== '';
        });
       
       $.each(valueArray, function(index, tag) {
            $tag_input.tagit('createTag', tag);
        });
       
       AUtagSuggestionInit();
    });

    return function() {
        AUtagSuggestionInit();
    };
});