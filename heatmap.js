var code = document.getElementById("heatmap").getAttribute("data-code");
// alert(code);
// alert($( window ).width());
// alert($( window ).height());

var allowed_el = ['A','LI','SPAN'];

(function($){
    $.fn.extend({
        getFullPath: function()
        {
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
            if($.inArray(this[0].tagName,allowed_el)!==-1)
            {
                return this.length > 0 ? traverseUp(this[0]) : '';
            }
            else
            {
                return 0;
            }
            
        }
    });
})(jQuery);


$('*').click(function(e)
{
    var fullPath = $(this).getFullPath();
    if(fullPath!=0)
    {
        alert('Send to Server');
        console.log(fullPath);
        var parentOffset = $(this).offset(); 
        var relX = e.pageX - parentOffset.left;
        alert(relX);
        var relY = e.pageY - parentOffset.top;
        alert(relY);
    }
    e.stopPropagation();
});