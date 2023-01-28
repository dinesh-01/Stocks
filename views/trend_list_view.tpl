<center>
    <br/>


    <center>

        <div id="show_list">

            <table class="gridtable">


                <tr>
                    <th>No</th>
                    <th>Stock Name</th>
                    <th>Trend Date</th>
                    <th>ChartInk</th>
                    <th>Notes</th>
                    <th>Trend Image</th>
                </tr>



                {foreach $datas as $value name=count}


                    <tr class="show">
                        <td>{$smarty.foreach.count.iteration}</td>
                        <td>{$value.stock_name}</td>
                        <td>{$value.createdDate}</td>
                        <td><a href="{$value.chart_ink}" target="_blank">ChartInk</a></td>
                        <td>{$value.notes}</td>
                        <td><a href="{$value.trend_file_date}" target="_blank">Trend Image</a></td>

                    </tr>

                {/foreach}

            </table>
        </div>
    </center>