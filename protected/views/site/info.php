<?php
$this->menu=array(

array('label'=>'Новый документ', 'url'=>array('create')),
array('label'=>'Управление', 'url'=>array('admin')),
array('label'=>'Информация', 'url'=>array('site/info')),
);
?>

<h1>Информация о документах</h1>

<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Просроченные">Срочно</label>

    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Состояние">Просроченные</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Состояние">Старые</label>

    <section id="content1">
        <div class="view-alert">Следующие документы необходимо обработать в течение <?=Yii::app()->session['set_alert']?> д.</div>
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider'=>$dataProvider,
                'template'=>'{items}',
                'itemView'=>'_view',
            )); ?>
    </section>
    <section id="content2">
        <div class="view-alert">Срок исполнения следующих документов истек</div>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider3,
            'template'=>'{items}',
            'itemView'=>'_view',
        )); ?>
    </section>
    <section id="content3">
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider2,
            'template'=>'{items}',
            'itemView'=>'_view',
        )); ?>
    </section>
</div>

