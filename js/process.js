function show_calculator(id) {

 
qb = $('#qbuy'+id).val();
qv = $('#qvolume'+id).val();

result = Number(qb) * Number(qv);
qt = result;

$('#qtotal'+id).val(qt);

$.post("show_calculator_process.php", {qbuy: qb,qvolume: qv,qtotal: qt,sid:id},function(data){

          $('#ttotals').html(data);
   });



}

function show_calculator_reset(id) {

 
qb = 0;
qv = 0;
qt = 0;

$('#qtotal'+id).val(qt);
$('#qbuy'+id).val(qb);
$('#qvolume'+id).val(qt);

$.post("show_calculator_process.php", {qbuy: qb,qvolume: qv,qtotal: qt,sid:id},function(data){

          $('#ttotals').html(data);
   });


}