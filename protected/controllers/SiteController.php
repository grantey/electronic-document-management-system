<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    public function actionInfo()
    {
        $dataProvider=new CActiveDataProvider('Orders', array(
            'criteria' => array(
                'with'=>array('traces'=>array(
                    'condition'=>'DATEDIFF(CURDATE(), trace_date_to) > -'.Yii::app()->session['set_alert'].' AND
                                    DATEDIFF(CURDATE(), trace_date_to) <= 0 AND
                                    trace_order_lstatus != "'.Orders::ORDER_DONE.'"
                                    AND trace_order_lstatus != "'.Orders::ORDER_OLD.'"',
                    // 'params'=>array('dTo'=>date('Y-m-d')),
                    'together'=>true,
                )),
            ),
            'pagination'=>array(
                'pageSize'=>50,
            ),
            /*'sort'=>array(
                'attributes'=>array(
                    'order_data_to'=>array(
                        'asc'=>'order_data_to ASC',
                        'desc'=>'order_data_to DESC',
                        'default'=>'desc',
                    )
                ),
                'defaultOrder'=>array(
                    'order_data_to'=>CSort::SORT_ASC,
                )
            ),*/
        ));

        $dataProvider3=new CActiveDataProvider('Orders', array(
            'criteria' => array(
                'with'=>array('traces'=>array(
                    'condition'=>'DATEDIFF(CURDATE(), trace_date_to) > 0 AND trace_order_lstatus != "'.Orders::ORDER_DONE.'" AND trace_order_lstatus != "'.Orders::ORDER_OLD.'"',
                    // 'params'=>array('dTo'=>date('Y-m-d')),
                    'together'=>true,
                )),
            ),
            'pagination'=>array(
                'pageSize'=>50,
            ),
        ));

        $dataProvider2=new CActiveDataProvider('Orders', array(
            'criteria' => array(
                'with'=>array('traces'=>array(
                    'condition'=>'trace_order_lstatus=:oStatus',
                    'params'=>array('oStatus'=>Orders::ORDER_OLD),
                    'together'=>true,
                )),
            ),
            'pagination'=>false,
        ));

        $this->render('info',array(
            'dataProvider'=>$dataProvider,
            'dataProvider2'=>$dataProvider2,
            'dataProvider3'=>$dataProvider3,
        ));
    }

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
                Yii::app()->session['alert'] = '1';

                /* настройки пользователя */
                $settings = Settings::model()->findByPk(Yii::app()->user->id);
                Yii::app()->session['set_alert'] = $settings->set_alert;
                Yii::app()->session['set_old'] = $settings->set_old;
                Yii::app()->session['set_archive'] = $settings->set_archive;
                Yii::app()->session['set_auto'] = $settings->set_auto;
                /* конец настроек пользователя */

                /* проверка на истекшие сроки хранения */
                $list_to_old = Trace::model()->findAllByAttributes(
                    array('trace_user_to' => Yii::app()->user->id),
                    'trace_order_lstatus = "'.Orders::ORDER_DONE.'" AND DATEDIFF(CURDATE(), trace_date) >= trace_time'
                    );
                foreach ($list_to_old as $trace)
                {
                    $trace->trace_order_lstatus = Orders::ORDER_OLD;
                    $trace->trace_time = Yii::app()->session['set_archive'];
                    $trace->trace_date = date('Y-m-d');
                    $trace->save();
                }

                $list_to_archive = Trace::model()->findAllByAttributes(
                    array('trace_user_to' => Yii::app()->user->id),
                    'trace_order_lstatus = "'.Orders::ORDER_OLD.'" AND DATEDIFF(CURDATE(), trace_date) >= trace_time'
                );
                foreach ($list_to_archive as $trace)
                {
                    $order = Orders::model()->findByPk($trace->trace_order_id);
                    $new_archive = new Archive;
                    $new_archive->a_order_id = $order->order_id;
                    $new_archive->a_order_header = $order->order_header;
                    $new_archive->a_order_text = $order->order_text;
                    $new_archive->a_order_data_from = $order->order_data_from;
                    $new_archive->a_order_data_to = $order->order_data_to;
                    $new_archive->a_order_type = $order->order_type;
                    $new_archive->a_order_status = $order->order_status;
                    $new_archive->a_user_id = Yii::app()->user->id;
                    $new_archive->a_date = date('Y-m-d');
                    $new_archive->save();

                    if (!is_null($trace->trace_app_id)) Application::model()->deleteByPk($trace->trace_app_id);
                    Receivers::model()->deleteAll('receiver_order_id=:oid AND receiver_from=:uid', array('oid' => $trace->trace_order_id, 'uid' => Yii::app()->user->id));
                    //$of = OrderFile::model()->findAllByAttributes(array('of_order_id'=>$id));
                    //foreach ($of as $item) Files::model()->findByPk($item->of_file_id)->delete();
                    OrderFile::model()->deleteAll('of_order_id=:oid', array('oid' => $trace->trace_order_id));
                    $trace->delete();
                    $order->delete();
                }
                /* конец проверки на истекшие сроки хранения */

                $this->redirect(Yii::app()->user->returnUrl);
            }
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

    public function  actionTest()
    {
        $this->render('test');
    }

    /** ADMIN */
    public function actionAdmin()
    {
        $model=new Orders('search');

        $model->unsetAttributes();
        if(isset($_GET['Orders']))
            $model->attributes=$_GET['Orders'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

   /* public function actionAgrid()
    {
        $model=new Orders('search2');
        $model->unsetAttributes();
        if(isset($_POST['Orders']))
            $model->attributes=$_POST['Orders'];

        $this->renderPartial('_search',array(
            'model'=>$model,
        ));
    }*/

    /** End of ADMIN  */


    public function actionInstall() {

        $auth=Yii::app()->authManager;
        $auth->clearAll();

        $auth->createOperation('usersView','Просмотр пользователя');
        $auth->createOperation('usersCreate','Создание пользователя');
        $auth->createOperation('usersUpdate','Редактирование пользователя');
        $auth->createOperation('usersDelete','Удаление пользователя');
        $auth->createOperation('usersIndex','Просмотр списка пользователей');
        $auth->createOperation('usersAdmin','Администрирование пользователей');

        $auth->createOperation('ordersView','Просмотр документа');
        $auth->createOperation('ordersCreate','Создание документа');
        $auth->createOperation('ordersUpdate','Редактирование документа');
        $auth->createOperation('ordersDelete','Удаление документа');
        $auth->createOperation('ordersIndex','Просмотр списка документов');
        $auth->createOperation('ordersAdmin','Администрирование документов');

        $bizRule='return Yii::app()->user->id==$params["users"]->user_id;';
        $task=$auth->createTask('usersOwnUpdate','Редактирование своих данных',$bizRule);
        $task->addChild('usersUpdate');

        $role=$auth->CreateRole('user');
        $role->addChild('ordersView');
        $role->addChild('ordersCreate');
        $role->addChild('ordersUpdate');
        $role->addChild('ordersDelete');
        $role->addChild('ordersIndex');
        $role->addChild('ordersAdmin');
        $role->addChild('usersOwnUpdate');

        $role=$auth->createRole('admin');
        $role->addChild('user');
        $role->addChild('usersView');
        $role->addChild('usersCreate');
        $role->addChild('usersUpdate');
        $role->addChild('usersDelete');
        $role->addChild('usersIndex');
        $role->addChild('usersAdmin');

        $auth->save();
        $this->render('install');

        /*
        http://yii-sedo/index.php?r=site/install
        */
    }
}