<?php
/* @var $this OrdersController */
/* @var $dataProvider CActiveDataProvider */


$this->menu=array(

    array('label'=>'Новый документ', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('site/admin')),
    array('label'=>'Дополнительно', 'url'=>array('site/info')),
);
?>

<h1>Документы</h1>


<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Новые">Новые (<?=$dataProvider->getTotalItemCount()?>)</label>

    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="В работе">В работе (<?=$dataProvider2->getTotalItemCount()?>)</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Исполненные">Исполненные (<?=$dataProvider3->getTotalItemCount()?>)</label>

    <section id="content1">
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dataProvider,
                'template'=>'{items}',
                'itemView'=>'_view',
            )); ?>
    </section>
    <section id="content2">
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dataProvider2,
                'template'=>'{items}',
                'itemView'=>'_view',
            )); ?>
    </section>
    <section id="content3">
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dataProvider3,
                'template'=>'{items}',
                'itemView'=>'_view',
            )); ?>
    </section>
</div>