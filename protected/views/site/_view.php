<?php
/* @var $this OrdersController */
/* @var $data Orders */
?>

<a href="<?php echo Yii::app()->createUrl('orders/view', array('id'=>$data->order_id))?>" class="view">

<div>

    <b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
    <?php echo CHtml::encode($data->order_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('order_header')); ?>:</b>
    <?php echo CHtml::encode($data->order_header); ?>
    <br />

    <?php if (isset($data->traces[0]->trace_user_from)) {
        $name = Users::model()->findByPk($data->traces[0]->trace_user_from)->user_full_name;
        echo '<b>' . CHtml::encode($data->traces[0]->getAttributeLabel('trace_user_from')) . ':</b> ' . $name . '<br />';
    }
    ?>

	<b><?php echo CHtml::encode($data->traces[0]->getAttributeLabel('trace_date_to')); ?>:</b>
	<?php echo CHtml::encode($data->traces[0]->trace_date_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_type')); ?>:</b>
	<?php echo CHtml::encode($data->category->category_type); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('order_status')); ?>:</b>
    <?php echo CHtml::encode($data->status->status_type); ?>
    <br />

    <?php
    $count = OrderFile::model()->countByAttributes(array('of_order_id' => $data->order_id));
    if($count > 0) echo '<b>Прикрепленных файлов:</b> '.$count;
    else echo '<b>Прикрепленных файлов:</b> нет';
    ?>


</div>

    </a>