$(document).ready(function() {
    $('.js-search-autocomplete').each(function() {
         var autocompleteUrl = $(".form-search").data('autocomplete-url');
		 $(this).autocomplete({hint: false}, [
            {
                source: function(query, cb) {
                    $.ajax({
                        url: autocompleteUrl+'?query='+query
                    }).then(function(data) {
                       	cb(data.result);
                    });
                },
				displayKey: 'team_name',
				debounce: 500
            }
        ])

    });
});