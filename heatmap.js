(function($){
    $.fn.extend({
        getFullPath: function()
        {
            alert(this.length);
            function traverseUp(el)
            {
                var result = el.tagName + ':eq(' + $(el).index() + ')';
                var pare = $(el).parent()[0];
                if (pare.tagName !== undefined )
                {
                    result = [traverseUp(pare), result].join(' ');
                }                
                return result;
            };
            return this.length > 0 ? traverseUp(this[0]) : '';
        }
    });
})(jQuery);

$('*').click(function(e)
{
    alert(e.target);
    alert('Clicked');
    var fullPath = $(this).getFullPath();
        // alert(fullPath);
        console.log(fullPath);
});