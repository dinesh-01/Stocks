//ToolTip
 $( function() {
    $( document ).tooltip();
  } );



//Ajax call for watch list Process
$(function() {
 $(".unwatch").click(function(){
 var element = $(this);
 var w_id = element.attr("id");
 var info = 'id=' + w_id;

  $.ajax({
    type: "POST",
    url: "watch_unlist_process.php",
    data: info,
    success: function(){}
 });
   $(this).parents(".show").animate({ backgroundColor: "#003" }, "fast")
   .animate({ opacity: "hide" }, "fast");
 });
 });




