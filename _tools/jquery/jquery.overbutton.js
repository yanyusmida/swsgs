/**
 * 
 * 对指定的元素 设置mouseover 效果。
 * 需要在指定的原始设置width，height
 * 如果没有定义background 需要添加一个over-img的属性并指定图片路径
 * @name jQuery overButton
 * @author jErRy(jeriyeh@gmail.com)
 * @category jQuery plugin
 * @copyright copyleft
 * Version: 0.1
 * 
 */
(function($){
    $.fn.overButton = function() {
        return this.each(function(){
            var over_height = $(this).height();
            var over_img =  $(this).css('background-image') != 'none'?$(this).css('background-image')+' no-repeat':'url('+$(this).attr('over-img')+') no-repeat'
            $(this).css({
                height:over_height,
                background:over_img
            }).hover(function(){
                $(this).css({
                    backgroundPosition:'0 -' + over_height + 'px'
                });
            },function(){
                $(this).css({
                    backgroundPosition:'0 0'
                });
            });
        });
    }
})(jQuery);
