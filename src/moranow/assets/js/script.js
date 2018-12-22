'use strict';

jQuery('document').ready(function($) {

    if ($('.moranow-select').length) {
        $('.moranow-select').SumoSelect({
            search: true,
            searchText: 'Tìm counselor'
        });
    }
});