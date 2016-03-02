<?php
/* @var $this SettingsController */
/* @var $model Settings */

$this->menu=array(
    array('label'=>'Шаблоны получателей', 'url'=>array('template')),
);
?>

<div class="headline">
    <h1>Настройки пользователя</h1>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'cssFile'=>Yii::app()->baseUrl.'/css/detail2.css',
	'attributes'=>array(
		'set_user_id',
		'set_alert',
        'set_old',
		'set_archive',
        array(
            'name'=>'set_auto',
            'type'=>'raw',
            'value'=>$model->set_auto==0 ? 'вручную' : 'автоматически',
        )
	),
)); ?>

<br>
<div class="row buttons">
<?=CHtml::button('Изменить', array('class'=>'btn', 'submit' => array('update', 'id'=>$model->set_user_id)));?>
</div>

<h1>Профиль пользователя</h1>

<style>
    #profile th
    {
        text-align: left;
        width: 160px;
    }

    .note
    {
        font-style: italic;
        margin: 15px 0 0 10px;
    }
</style>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model2,
    'id'=>'profile',
    'cssFile'=>Yii::app()->baseUrl.'/css/detail2.css',
    'attributes'=>array(
        'user_login',
        'user_password',
        'user_full_name',
        'user_post',
        'user_phone',
        'user_faculty',
        'user_depart',
    ),
)); ?>

<div class="note">По вопросам изменения личной информации обращайтесь к администратору с помощью контактной формы.</div>