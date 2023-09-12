function show_calculator(id) {

 
qb = $('#qbuy'+id).val();
qv = $('#qvolume'+id).val();
stock_signal =   $('#stock_signal'+id).val();
order_type =  $('#order_type'+id).val();
stop_loss =   $('#stop_loss'+id).val();
target = $('#target'+id).val();
tar_data = 0;
stop_loss_data = 0;

result = Number(qb) * Number(qv);
qt = result;

$('#qtotal'+id).val(qt);

pdata = (1.5 / 100) ;
sdata = (0.5 / 100) ;
qbdata = qb * pdata;
qbsdata = qb * sdata;

if(stock_signal == "SELL") {

    tar_data = Number(qb) - Number(qbdata);
    stop_loss_data = Number(qb) + Number(qbsdata);

}

if(stock_signal == "BUY") {

    tar_data = Number(qb) + Number(qbdata);;
    stop_loss_data = Number(qb) - Number(qbsdata);;

}


    tar_data = Math.round(tar_data * 10) / 10
    stop_loss_data = Math.round(stop_loss_data * 10) / 10



$('#target'+id).val(tar_data);
$('#stop_loss'+id).val(stop_loss_data);

$.post("show_calculator_process.php", { qbuy: qb,
                                        qvolume: qv,
                                        qtotal: qt,
                                        stock_signal:stock_signal,
                                        order_type:order_type,
                                        stop_loss:stop_loss_data,
                                        target:tar_data,
                                        sid:id},function(data){

          $('#ttotals').html(data);
   });



}

function show_calculator_reset(id) {

 
qb = 0;
qv = 0;
qt = 0;
stock_signal = "SELL"

$('#qtotal'+id).val(qt);
$('#qbuy'+id).val(qb);
$('#qvolume'+id).val(qt);
$('#stock_signal'+id).val(stock_signal);

$.post("show_calculator_process.php", {qbuy: qb,qvolume: qv,qtotal: qt,stock_signal:stock_signal, sid:id},function(data){

          $('#ttotals').html(data);
   });


}