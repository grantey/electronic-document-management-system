<?php
/* @var $this UsersController */
/* @var $model Users */

if (!Yii::app()->request->isAjaxRequest):
$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Изменить', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Вы уверены что хотите удалить этого пользователя ?')),
	array('label'=>'Управление', 'url'=>array('admin')),
); endif;
?>

<h2><?php echo $model->user_full_name; ?></h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'user_login',
		'user_password',
		'user_full_name',
		'user_post',
		'user_phone',
		'user_faculty',
		'user_depart',
	),
)); ?>
