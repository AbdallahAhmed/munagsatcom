$('.show-text').popover();
$('.show-text').click(function () {
     $('.show-text').not(this).popover('hide');
});