#!/bin/bash
while true; do
     /Applications/MAMP/bin/php/php7.4.33/bin/php /Applications/MAMP/htdocs/intra/order_trigger_jenkins.php
     /Applications/MAMP/bin/php/php7.4.33/bin/php /Applications/MAMP/htdocs/intra/monitor_order_status_jenkins.php
    sleep 2
done
