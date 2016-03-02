<?php
/* @var $this UsersController */
/* @var $model Users */


$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Создать пользователя</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>