var code = document.getElementById("heatmap").getAttribute("data-code");
// alert(code);
// alert($( window ).width());
// alert($( window ).height());

var allowed_el = ['A','LI','SPAN','BUTTON'];

(function($){
    $.fn.extend({
        getFullPath: function()
        {
            function traverseUp(el)
            {
                var result = el.tagName + ':eq(' + $(el).index() + ')';
                alert(el.tagName+ '-' + $(el).index());
                var pare = $(el).parent()[0];
                if (pare.tagName !== undefined && ( pare.tagName !== 'BODY'))
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
    alert(fullPath);
    if(fullPath!=0)
    {
        var parentOffset = $(this).offset(); 
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top;
        $.ajax({
            url: "http://localhost/heatmap/index.php",
            type: 'POST',
            data: { code:code, path:fullPath, xpos:relX, ypos:relY}
            });
    }
    e.stopPropagation();
});