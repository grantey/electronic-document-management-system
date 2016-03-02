<?php
/* @var $this OrdersController */
/* @var $model Orders */
if (!Yii::app()->request->isAjaxRequest):


$this->menu=array(
	array('label'=>'Все документы', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('site/admin')),
);
?>

<h1>Новый документ</h1>

<?php endif;

$this->renderPartial('_form', array('model'=>$model)); ?>