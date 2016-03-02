<?php
/* @var $this UsersController */
/* @var $model Users */

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Просмотр', 'url'=>array('view', 'id'=>$model->user_id)),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Изменить профиль пользователя</h1>
<h2><?=$model->user_full_name;?> (логин: <?=$model->user_login;?>)</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>