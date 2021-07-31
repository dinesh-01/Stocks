function show_new_list() {

 id = $('#type').val();
$('#show_result').html("<b>Loading...</b>");

   $.post("new_list.php", {t: id},function(data){
        $('#show_result').html(data);
    });


}

function show_watch_list() {

 //id = $('#type').val();

id = "nifty";
$('#show_result').html("<b>Loading...</b>");

   $.post("show_watch_list.php", {t: id},function(data){
        $('#show_result').html(data);
    });


}

function show_pattern_list() {

 t = $('#type').val();
 p = $('#pattern').val();
$('#show_result').html("<b>Loading...</b>");

   $.post("show_pattern_list.php", {t: t,p: p},function(data){
        $('#show_result').html(data);
    });


}

function show_range() {

 r = $('#range').val();
$('#show_list').html("<b>Loading...</b>");

  $.post("list_stocks_range.php", {r: r},function(data){
       $('#show_list').html(data);
   });



}


function search_company() {

 r = $('#cname').val();

$('#show_list').html("<b>Loading...</b>");

  $.post("search_company.php", {r: r},function(data){
       $('#show_list').html(data);
   });



}

function change_priority(id) {


pri = $('#pri'+id).val();

  $.post("change_priority.php", {pri: pri,id: id},function(data){});


}
