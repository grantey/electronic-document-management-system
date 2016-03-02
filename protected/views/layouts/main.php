<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
                //array('label'=>'== Тест ==', 'url'=>array('/site/test')),
				array('label'=>'Главная', 'url'=>array('/site/index')),
                array('label'=>'Пользователи', 'url'=>array('/users/index'), 'visible'=>Yii::app()->user->role == Users::ROLE_ADMIN),
                array('label'=>'Документы', 'url'=>array('/orders/index'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Дополнительно', 'url'=>array('/site/info'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Справка', 'url'=>array('/site/page', 'view'=>'about'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Контакты', 'url'=>array('/site/contact')),
                array('label'=>'Настройки', 'url'=>array('/settings/view'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Войти', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>

	</div><!-- mainmenu -->

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Дипломная работа &copy; <?php echo date('Y'); ?> <br/>
		Бакулина А.В.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
