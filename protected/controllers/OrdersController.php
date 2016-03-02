<?php

class OrdersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'users'=>array('@'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model2 = new Users;
        /*$model2->unsetAttributes();
        if (isset($_GET['Orders']))
            $model2->attributes = $_GET['Orders'];*/

        $model3 = $this->loadApplication($id);
        if (!isset($model3)) $model3 = new Application;

        if(isset($_POST['addChecked'])) {
            if (isset($_POST['check-boxes'])) {
                $items = $_POST['check-boxes'];
                foreach ($items as $uid) {
                    $result = Receivers::model()->findByAttributes(array('receiver_order_id'=>$id,'receiver_to'=>$uid,'receiver_from'=>Yii::app()->user->id));
                    if (!isset($result)) {
                        $receiver = new Receivers;
                        $receiver->receiver_order_id = $id;
                        $receiver->receiver_from = Yii::app()->user->id;
                        $receiver->receiver_to = $uid;
                        $receiver->save();
                    }
                }
            }
        }

        if(isset($_POST['addTemplate'])) {
            if (isset($_POST['Templates'])) {
                $tu_list = TemplUser::model()->findAllByAttributes(array('tu_template_id'=>$_POST['Templates']));
                foreach ($tu_list as $item) {
                    $result = Receivers::model()->findByAttributes(array('receiver_order_id'=>$id,'receiver_to'=>$item->tu_user_id,'receiver_from'=>Yii::app()->user->id));
                    if (!isset($result)) {
                        $receiver = new Receivers;
                        $receiver->receiver_order_id = $id;
                        $receiver->receiver_from = Yii::app()->user->id;
                        $receiver->receiver_to = $item->tu_user_id;
                        $receiver->save();
                    }
                }
            }
        }

        if(isset($_POST['addResolution'])) {
            if (isset($model3)) $application = $model3;
            else $application = new Application;
            $application->attributes = $_POST['Application'];
            $application->save();
            $model3 = $application;

            $trace = Trace::model()->findByAttributes(array('trace_order_id'=>$id,'trace_user_to'=>Yii::app()->user->id));
            $trace->trace_app_id = $application->getPrimaryKey();
            $trace->save();
        }

        if(isset($_POST['delResolution'])) {
            if (isset($model3->app_id)) {
                $model3->delete();
                $model3 = new Application;
            }
        }

        if(isset($_POST['returnOrder'])) {
            if (isset($model3)) $application = $model3;
            else $application = new Application;
            $application->attributes = $_POST['Application'];
            $application->app_date = date('Y-m-d');
            $application->save();
            $model3 = $application;

            $trace = Trace::model()->findByAttributes(array('trace_order_id'=>$id,'trace_user_to'=>Yii::app()->user->id));
            $owner = $trace->trace_user_from;
            $trace->trace_app_id = $application->getPrimaryKey();
            $trace->trace_order_lstatus = Orders::ORDER_DONE;
            $trace->trace_time = Yii::app()->session['set_old'];
            $trace->trace_date = date('Y-m-d');
            $trace->save();

            /* автоматиеческое помещение в исполненные, если адресаты выполнили свое */
            $owner_settings = Settings::model()->findByPk($owner);
            if ($owner_settings->set_auto) {
                $traces = Trace::model()->findAllByAttributes(array('trace_order_id' => $id, 'trace_user_from' => $owner));
                $trace = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => $owner));
                $done_mode = $trace->trace_done_mode;
                if (!$done_mode) {
                    $check_for_done = true;
                    foreach ($traces as $trace)
                        if ($trace->trace_order_lstatus != Orders::ORDER_DONE) {
                            $check_for_done = false;
                            break;
                        }
                }
                else {
                    $check_for_done = true;
                    foreach ($traces as $trace) {
                        $trace->trace_order_lstatus = Orders::ORDER_DONE;
                        $trace->trace_time = Yii::app()->session['set_old'];
                        $trace->trace_date = date('Y-m-d');
                        $trace->save();
                    }
                }
                if ($check_for_done) {
                    $trace->trace_order_lstatus = Orders::ORDER_DONE;
                    $trace->trace_time = Yii::app()->session['set_old'];
                    $trace->trace_date = date('Y-m-d');
                    $trace->save();
                }
            }

        }

        $this->render('view', array(
                'model' => $this->loadModel($id),
                'model2' => $model2,
                'model3' => $model3,
            ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */ //echo "<script>alert(\"1\");</script>";
	public function actionCreate()
	{
		$model=new Orders;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        if(isset($_POST['Orders']))
        {
            $model->attributes = $_POST['Orders'];
            $model->order_status = 6;
            if ($model->save())
            {
                $trace = new Trace;
                $trace->trace_order_id = $model->order_id;
                $trace->trace_user_to = Yii::app()->user->id;
                $trace->trace_order_lstatus = Orders::ORDER_NEW;
                $trace->trace_date_to = $model->order_data_to;
                $trace->trace_date = date('Y-m-d');
                $trace->save();

                $files = CUploadedFile::getInstancesByName('upfiles');
                if (isset($files) && count($files) > 0)
                {
                    foreach ($files as $file => $f)
                    {
                        $folder = Yii::getPathOfAlias('application.uploads');
                        if ($f->saveAs($folder . '\\' . $f->name))
                        {
                            $model2 = new Files;
                            $model2->file_name = $f->name;
                            $model2->file_path = $folder;
                            $model2->save();
                        }
                        $link = new OrderFile;
                        $link->of_order_id = $model->order_id;
                        $link->of_file_id = $model2->file_id;
                        $link->save();
                    }
                }
                if(Yii::app()->request->isAjaxRequest){
                    Yii::app()->end();
                }
                else {
                    $this->redirect(array('view', 'id' => $model->order_id));
                }
            }
        }
        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial('create',array('model'=>$model), false, true);
        else
            $this->render('create',array('model'=>$model));
	}

	 /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        /* изменение набора файлов */
        $files = new CActiveDataProvider('Files', array(
            'criteria'=>array(
                'condition'=>"file_id IN (SELECT of_file_id FROM order_file WHERE of_order_id='".$id."')",
            ),
        ));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
            $trace = Trace::model()->findByAttributes(array('trace_order_id'=>$id,'trace_user_to'=>Yii::app()->user->id));
            if (isset($model->order_data_from)) $trace->trace_date = $model->order_data_from;
            else $trace->trace_date = date('Y-m-d');
            $trace->trace_date_to = $model->order_data_to;
            $trace->save();

            $files = CUploadedFile::getInstancesByName('upfiles');
            if (isset($files) && count($files) > 0)
            {
                foreach ($files as $file => $f)
                {
                    $folder = Yii::getPathOfAlias('application.uploads');
                    if ($f->saveAs($folder . '\\' . $f->name))
                    {
                        $model2 = new Files;
                        $model2->file_name = $f->name;
                        $model2->file_path = $folder;
                        $model2->save();
                    }
                    $link = new OrderFile;
                    $link->of_order_id = $model->order_id;
                    $link->of_file_id = $model2->file_id;
                    $link->save();
                }
            }

			if($model->save()) {
                if (Yii::app()->request->isAjaxRequest) Yii::app()->end();
                else $this->redirect(array('view', 'id' => $model->order_id));
            }

		}

        if(Yii::app()->request->isAjaxRequest)
            $this->renderPartial('update',array('model'=>$model, 'files'=>$files), false, true);
        else
            $this->render('update',array('model'=>$model, 'files'=>$files));
	}

    public function actionCopy ($id)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $check = true;
            $model = Orders::model()->findByPk($id);
            $new_model = new Orders;
            $new_model->attributes = $model->attributes;
            $check = ($check && $new_model->save());
            $new_id = Yii::app()->db->getLastInsertId();

            $of = OrderFile::model()->findAllByAttributes(array('of_order_id' => $id));
            foreach ($of as $item) {
                $new_item = new OrderFile;
                $new_item->of_order_id = $new_id;
                $new_item->of_file_id = $item->of_file_id;
                $check = ($check && $new_item->save());
            }

            $trace = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => Yii::app()->user->id));
            if (!is_null($trace->trace_app_id)) {
                $app = Application::model()->findByPk($trace->trace_app_id);
                $new_app = new Application;
                $new_app->attributes = $app->attributes;
                $check = ($check && $new_app->save());
                $app_id = Yii::app()->db->getLastInsertId();
            }

            $new_trace = new Trace;
            $new_trace->attributes = $trace->attributes;
            $new_trace->trace_order_lstatus = Orders::ORDER_NEW;
            $new_trace->trace_order_id = $new_id;
            if (isset($app_id)) $new_trace->trace_app_id = $app_id;
            $check = ($check && $new_trace->save());

            if ($check) $transaction->commit();
            else $transaction->rollback();
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }

        $this->redirect(array('view', 'id' => $new_id));
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $trace = Trace::model()->findByAttributes(array('trace_order_id'=>$id,'trace_user_to'=>Yii::app()->user->id));

        if ($trace->trace_order_lstatus != Orders::ORDER_NEW)
        {
            $this->render('confirm',array(
                'id'=>$id,
                'success'=>'3',
            ));
        }
        else {
            if (!is_null($trace->trace_app_id)) Application::model()->deleteByPk($trace->trace_app_id);
            $order = Orders::model()->findByPk($trace->trace_order_id);
            Receivers::model()->deleteAll('receiver_order_id=:oid AND receiver_from=:uid', array('oid' => $id, 'uid' => Yii::app()->user->id));
            //$of = OrderFile::model()->findAllByAttributes(array('of_order_id'=>$id));
            //foreach ($of as $item) Files::model()->findByPk($item->of_file_id)->delete();
            OrderFile::model()->deleteAll('of_order_id=:oid', array('oid' => $id));
            $trace->delete();
            $order->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Orders', array(
            'criteria' => array(
                'with'=>array('traces'=>array(
                    'condition'=>'trace_order_lstatus=:oStatus',
                    'params'=>array('oStatus'=>Orders::ORDER_NEW),
                    'together'=>true,
                )),
            ),
            'pagination'=>false,
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
        $dataProvider2=new CActiveDataProvider('Orders', array(
            'criteria' => array(
                'with'=>array('traces'=>array(
                    'condition'=>'trace_order_lstatus=:oStatus',
                    'params'=>array('oStatus'=>Orders::ORDER_IN_WORK),
                    'together'=>true,
                )),
            ),
            'pagination'=>false,
        ));
        $dataProvider3=new CActiveDataProvider('Orders', array(
            'criteria' => array(
                'with'=>array('traces'=>array(
                    'condition'=>'trace_order_lstatus=:oStatus',
                    'params'=>array('oStatus'=>Orders::ORDER_DONE),
                    'together'=>true,
                )),
            ),
            'pagination'=>false,
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
            'dataProvider2'=>$dataProvider2,
            'dataProvider3'=>$dataProvider3,
		));
	}

	/**
	 * Manages all models.
	 */

    public function actionDownload($file, $path)
    {
        Yii::app()->request->sendFile($file,$path);
    }

    public function actionUAbout($id)
    {
        $model=Users::model()->findByPk($id);

        $this->renderPartial('about',array(
            'model'=>$model,
        ), false, true);
    }

    public function actionApp($id)
    {
        $model=Application::model()->findByPk($id);

        $this->renderPartial('app',array(
            'model'=>$model,
        ), false, true);
    }

    public function actionConfirm($id)
    {
        $result = Receivers::model()->findAllByAttributes(array('receiver_order_id' => $id, 'receiver_from' => Yii::app()->user->id));
        if (!empty($result))
        {
            $tr = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => Yii::app()->user->id));
            $tr->trace_done_mode = $_POST['done_mode']; //режим завершения работы
            $template = false; //проверка будет ли новый шаблон получателей
            if ($_POST['save_template'] && !empty($_POST['template_title']))
            {
                $new_template = new Templates;
                $new_template->template_owner_id = Yii::app()->user->id;
                $new_template->template_title = $_POST['template_title'];
                if ($new_template->save()) {
                    $template = true;
                    $template_id = Yii::app()->db->getLastInsertID();
                }
            }

            if (is_null($tr->trace_app_id)) $date_to = $tr->trace_date_to;
            else {
                $app = Application::model()->findByPk($tr->trace_app_id);
                $date_to = $app->app_date;
            }

            $success = 0;
            foreach ($result as $item)
            {
                $is_send = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => $item->receiver_to));
                if (isset($is_send)) continue;

                $trace = new Trace;
                $trace->trace_order_id = $id;
                $trace->trace_user_to = $item->receiver_to;
                $trace->trace_user_from = $item->receiver_from;
                $trace->trace_order_lstatus = Orders::ORDER_NEW;
                $trace->trace_date_to = $date_to;
                $trace->trace_date = date('Y-m-d');
                if ($trace->save())
                {
                    $success = 1;
                    if ($template) {
                        $new_tu = new TemplUser;
                        $new_tu->tu_template_id = $template_id;
                        $new_tu->tu_user_id = $item->receiver_to;
                        $new_tu->save();
                    }
                }
            }

            if ($success) {
                $tr->trace_order_lstatus = Orders::ORDER_IN_WORK;
                $tr->trace_date = date('Y-m-d');
                $tr->save();
            }

            $this->render('confirm',array(
                'id'=>$id,
                'success'=>$success,
            ));
        }
        else $this->redirect(array('view','id'=>$id));
    }

    public function actionUDelete($oid, $uid)
    {
        $result = Receivers::model()->findByAttributes(array('receiver_order_id' => $oid, 'receiver_to' => $uid, 'receiver_from' => Yii::app()->user->id));
        $result->delete();
    }

    /** Перенос */

    public function actionToDone($id)
    {
        $trace = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => Yii::app()->user->id));
        $trace->trace_order_lstatus = Orders::ORDER_DONE;
        $trace->trace_date = date('Y-m-d');
        if (!empty($_POST['time'])) $trace->trace_time = $_POST['time'];
        else $trace->trace_time = Yii::app()->session['set_old'];
        $trace->save();
        $this->redirect(array('view', 'id' => $id));
    }

    public function actionToOld($id)
    {
        $trace = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => Yii::app()->user->id));
        $trace->trace_order_lstatus = Orders::ORDER_OLD;
        $trace->trace_date = date('Y-m-d');
        if (!empty($_POST['time'])) $trace->trace_time = $_POST['time'];
        else $trace->trace_time = Yii::app()->session['set_archive'];
        $trace->save();
        $this->redirect(array('view', 'id' => $id));
    }

    public function actionToArchive($id)
    {
        $trace = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => Yii::app()->user->id));
        $order = Orders::model()->findByPk($id);
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
        Receivers::model()->deleteAll('receiver_order_id=:oid AND receiver_from=:uid', array('oid' => $id, 'uid' => Yii::app()->user->id));
        //$of = OrderFile::model()->findAllByAttributes(array('of_order_id'=>$id));
        //foreach ($of as $item) Files::model()->findByPk($item->of_file_id)->delete();
        OrderFile::model()->deleteAll('of_order_id=:oid', array('oid' => $id));
        $trace->delete();
        $order->delete();

        $this->redirect(array('site/info'));
    }

    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Orders the loaded model
	 * @throws CHttpException
	 */

	public function loadModel($id)
	{
        $trace = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => Yii::app()->user->id));

        if(isset($trace))
        {
            $model=Orders::model()->findByPk($id);
            return $model;
        }
        else throw new CHttpException(403,'Нет доступа');
	}

    public function loadApplication($order_id)
    {
        $trace = Trace::model()->findByAttributes(array('trace_order_id' => $order_id, 'trace_user_to' => Yii::app()->user->id));

        if(isset($trace)) $model=Application::model()->findByPk($trace->trace_app_id);
        if (!isset($model)) $model = new Application;
        return $model;
    }

    public function ownerApplicationID($order_id, $user_id)
    {
        $trace = Trace::model()->findByAttributes(array('trace_order_id' => $order_id, 'trace_user_to' => $user_id));
        return $trace->trace_app_id;
    }

	/**
	 * Performs the AJAX validation.
	 * @param Orders $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orders-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
