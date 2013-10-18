(function($){
    $.fn.extend({
        getFullPath: function(stopAtBody){
            stopAtBody = stopAtBody || false;
            function traverseUp(el){
                var result = el.tagName + ':eq(' + $(el).index() + ')',
                    pare = $(el).parent()[0];
                if (pare.tagName !== undefined && (!stopAtBody || pare.tagName !== 'BODY')){
                    result = [traverseUp(pare), result].join(' ');
                }                
                return result;
            };
            return this.length > 0 ? traverseUp(this[0]) : '';
        }
    });
})(jQuery);

$('li').click(function(){
    var fullPath = $(this).getFullPath(),
        fullUntilBody = $(this).getFullPath(true);
    
    // just to verify, color the element by this fullPath selector
    $(fullUntilBody).css('color','#FF00FF');
    alert(fullPath);
    
});