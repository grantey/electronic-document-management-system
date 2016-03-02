<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Пользователи</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
    'summaryText' => "{start} - {end} из {count}",
    'template'=>"{items}<br>{summary}{pager}",
	'itemView'=>'_view',
)); ?>
