
<?php

$order = Orders::model()->findByPk(4);
echo $order->order_header;
echo $order->main_trace->trace_order_lstatus;