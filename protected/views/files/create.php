<?php
/* @var $this FilesController */
/* @var $model Files */

$this->breadcrumbs=array(
	'Files'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Files', 'url'=>array('index')),
	array('label'=>'Manage Files', 'url'=>array('admin')),
);
?>

<h1>Create Files</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>