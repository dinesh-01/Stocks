<script src="js/list_stocks_futures.js"></script>

<center>
    <br/>



    <div id="show_list">


          <table class="gridtable">
            <tr>
            <th> No </th>
            <th>Stock Name</th>
            <th>TradingView</th>
            <th>Option</th>
            </tr>

        {foreach $datas as $value name=count}

             <tr class="show">
                <td> {$smarty.foreach.count.iteration} </td>
                <td>
                    <a href="https://in.tradingview.com/symbols/{$value.sName}"  target="blank">{$value.sName}</a>
                </td>
                <td><a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3A{$value.sName}" target="_blank">{$value.sName}</a></td>
                 <td><a href="https://www.google.com/search?q={$value.sName}%20grow%20option%20chain" target="_blank">List</a></td>

            </tr>


        {/foreach}

              <tr class="show">
                  <td> 3 </td>
                  <td>
                      <a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3ANIFTYMIDCAP50"  target="blank">NIFTYMIDCAP50</a>
                  </td>
                  <td><a href="https://in.tradingview.com/chart/AINnrOTv/?symbol=NSE%3ANIFTYMIDCAP50"  target="blank">NIFTYMIDCAP50</a>
                  </td>
                  <td><a href="https://groww.in/options/nifty-midcap-select" target="_blank">List</a></td>

              </tr>


              <tr class="show">
                  <td> 4 </td>
                  <td>
                      <a href="https://www.tradingview.com/chart/AINnrOTv/?symbol=NSE%3AFINNIFTY1%21"  target="blank">FINNIFTY</a>
                  </td>
                  <td>
                      <a href="https://www.tradingview.com/chart/AINnrOTv/?symbol=NSE%3AFINNIFTY1%21"  target="blank">FINNIFTY</a>

                  </td>
                  <td><a href="https://www.google.com/search?q={$value.sName}%20grow%20option%20chain" target="_blank">List</a></td>

              </tr>




          </table>
</div>
</center>