<?php
/* @var $this FilesController */
/* @var $model Files */

$this->breadcrumbs=array(
	'Files'=>array('index'),
	$model->file_id,
);

$this->menu=array(
	array('label'=>'List Files', 'url'=>array('index')),
	array('label'=>'Create Files', 'url'=>array('create')),
	array('label'=>'Update Files', 'url'=>array('update', 'id'=>$model->file_id)),
	array('label'=>'Delete Files', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->file_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Files', 'url'=>array('admin')),
);
?>

<h1>View Files #<?php echo $model->file_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'file_id',
		'file_path',
		'file_name',
		'file_upload_date',
	),
)); ?>
