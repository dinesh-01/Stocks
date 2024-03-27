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

//DownTrend
if(p == "pipattern") {
    $('#candle_sample').html("<img src='candle_sample/pipattern.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "phammer") {
    $('#candle_sample').html("<img src='candle_sample/phammer.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "enpattern") {
    $('#candle_sample').html("<img src='candle_sample/enpattern.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "doji") {
    $('#candle_sample').html("<img src='candle_sample/doji.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "sptop") {
    $('#candle_sample').html("<img src='candle_sample/sptop.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "sptop") {
    $('#candle_sample').html("<img src='candle_sample/sptop.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "morningstar") {
    $('#candle_sample').html("<img src='candle_sample/morningstar.png'  alt='candlesample' width='500' height='200'>");
}

//Uptrend
if(p == "darkcover") {
    $('#candle_sample').html("<img src='candle_sample/darkcover.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "eveningstar") {
    $('#candle_sample').html("<img src='candle_sample/eveningstar.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "brpattern") {
    $('#candle_sample').html("<img src='candle_sample/brpattern.png'  alt='candlesample' width='500' height='200'>");
}

if(p == "nhammer") {
    $('#candle_sample').html("<img src='candle_sample/nhammer.png'  alt='candlesample' width='500' height='200'>");
}

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

function search_futures_company() {

    r = $('#fname').val();

    $('#show_list').html("<b>Loading...</b>");

    $.post("search_company_futures.php", {r: r},function(data){
        $('#show_list').html(data);
    });



}

function change_priority(id) {


pri = $('#pri'+id).val();

  $.post("change_priority.php", {pri: pri,id: id},function(data){});


}


function add_support(id) {

    support_value = $('#support_value'+id).val();
    $.post("add_support_value.php", {support_value: support_value,id: id},function(data){});


}
