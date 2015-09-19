$(".nav-tabs").on("click", "a", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('add-flag')) {
            $(this).tab('show');
        }
    })
    .on("click", "span", function () {
        var anchor = $(this).siblings('a');
        $(anchor.attr('href')).remove();
        $(this).parent().remove();
        $(".nav-tabs li").children('a').first().click();
    });

$('.add-flag').click(function (e) {
    e.preventDefault();
    var id = $(".nav-tabs").children().length;
    var tabId = 'flag_' + id;
    $(this).closest('li').before('<li><a href="#flag_' + id + '">' + id + '</a></li>');
    $('.tab-content').append('<div class="tab-pane" id="' + tabId + '"> <textarea id="' + tabId + '" name="' + tabId + '" class="form-control" rows="10"></textarea></div>');
   $('.nav-tabs li:nth-child(' + id + ') a').click();
});
