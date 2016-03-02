<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->menu=array(
	array('label'=>'Все документы', 'url'=>array('index')),
	array('label'=>'Новый документ', 'url'=>array('create')),
	array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->order_id)),
	array('label'=>'Управление', 'url'=>array('site/admin')),
);
?>

<h1>Изменить документ №<?php echo $model->order_id; ?></h1>

<?php if ($model->traces[0]->trace_order_lstatus != Orders::ORDER_NEW): ?>

    <h4>Нельзя изменить документ, отправленный в работу или находящийся в архиве.<br>
    Скопируйте документ и внесите требуемые изменения для новой отправки.</h4>

    <div>
        <?php echo CHtml::button('К документу', array('class'=>'btn', 'submit' => array('orders/view', 'id'=>$model->order_id))); ?>
        <?php echo CHtml::button('К списку', array('class'=>'btn', 'submit' => array('orders/index'))); ?>
    </div>

<?php else: $this->renderPartial('_form', array('model'=>$model, 'files'=>$files)); endif; ?>
