<script src="js/jquery.min.js"></script>
<script src="js/jquery.linkify.min.js"></script>
<script src="js/jquery.livequery.js"></script>
<script>
$(document).ready(function()
{

//Formatting the text that contains URLs (text to link)
$(".sttext").livequery(function ()
{
$(this).linkify({ target: "_blank"});
});

//Parsing JSON object. 
$.getJSON("users.json", function(data)
{
var totalCount=5;
var jsondata='';
$.each(data.Messages, function(i, M)
{
//Generating random numbers for different dot colors 
var num = Math.ceil(Math.random() * totalCount );
jsondata +='<div class="stbody">'
                +'<span class="timeline_square color'+num+'"></span>'
                +'<div class="stimg"><img src="'+M.avatar+'" /></div>'
                +'<div class="sttext"><span class="stdelete">X</span>'
                +'<b>'+M.user +'</b><br/>'
                +M.message+'<div class="sttime">'+M.time
                +'</div><div class="stexpand">'+M.embed+'</div></div></div>';
});
$(jsondata).appendTo("#updates");
});

//Delete record
$('body').on("click",".stdelete",function()
{
var A=$(this).parent().parent();
A.addClass("effectHinge");
A.delay(500).fadeOut("slow",function(){
$(this).remove();
});
});


});
</script>
<div id="updates"></div>