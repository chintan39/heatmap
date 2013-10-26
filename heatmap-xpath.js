var code = document.getElementById("heatmap").getAttribute("data-code");
// alert(code);
// alert($( window ).width());
// alert($( window ).height());

var allowed_el = ['A','LI','SPAN','BUTTON'];


function getXPath( element ) 
{
    var val=element.tagName;
    alert(val);
    if($.inArray(val,allowed_el)!==-1)
    {
        var xpath = ''; 
        for ( ; element && element.nodeType == 1; element = element.parentNode ) 
        { 
            //alert(element); 
            var id = $(element.parentNode).children(element.tagName).index(element) + 1; id > 1 ? (id = '[' + id + ']') : (id = ''); 
            xpath = '/' + element.tagName.toLowerCase() + id + xpath; 
        } 
        return xpath; 
    }
    else
    {
        return 0;
    }
}

$('*').click(function(e)
{
    var value = getXPath(this);
    alert(value);
    if(value!=0)
    {
        var parentOffset = $(this).offset(); 
        var relX = e.pageX - parentOffset.left;
        var relY = e.pageY - parentOffset.top;
        $.ajax({
            url: "http://localhost/heatmap/index.php",
            type: 'POST',
            data: { code:code, path:value, xpos:relX, ypos:relY}
            });
    }
    e.stopPropagation();
});