/**
 * http://blog.ricodigo.com/blog/2012/02/17/easy-tooltips-with-jquery-ui/
 *
 * jQuery UI 1.9 with tooltips support isn't released yet, so this is a
 *  bit more of a manual effort
 *
 */

jQuery(document).ready(function ($)
{
    $('.show_tooltip').hover(function()
    {
        $(this).parent().find('.tooltip').stop(true, true).fadeIn();
        $(this).parent().find('.tooltip').position({ my:'left', at:'right', of:$(this), offset: '5px 2px'})
    });

    $('.show_tooltip').mouseleave(function()
    {
        $(this).parent().find('.tooltip').stop(true, true).fadeOut()
    })

})

