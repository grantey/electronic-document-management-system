<?php
/* @var $this UsersController */
/* @var $model Users */

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
$('.search-button').click(function(){
	$('.search-form').slideToggle();
	return false;
});
");
?>

<h1>Управление пользователями</h1>
<br>
<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
        'model'=>$model,
    )); ?>
</div>



        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'users-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'selectableRows'=>1,
            'summaryText' => "Пользователи {start} - {end} из {count}",
            'columns'=>array(
                'user_id',
                'user_login',
                'user_password',
                'user_full_name',
                'user_post',
                'user_phone',
                array(
                    'class'=>'CButtonColumn',
                ),
            ),
        )); ?>





