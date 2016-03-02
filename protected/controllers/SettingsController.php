<?php

class SettingsController extends Controller
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
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView()
	{

		$this->render('view',array(
			'model'=>$this->loadModel(Yii::app()->user->id),
            'model2'=>Users::model()->findByPk(Yii::app()->user->id),
		));
	}

    public function actionTemplate()
    {
        $model=new Templates('search');

        if(isset($_POST['addChecked'])) {
            if (isset($_POST['check-boxes'])) {
                $items = $_POST['check-boxes'];
                $tid = $_GET['Templates']['template_id'];
                foreach ($items as $uid) {
                    $result = TemplUser::model()->findByAttributes(array('tu_template_id' => $tid, 'tu_user_id' => $uid));
                    if (!isset($result)) {
                        $receiver = new TemplUser;
                        $receiver->tu_template_id = $tid;
                        $receiver->tu_user_id = $uid;
                        $receiver->save();
                    }
                }
            }
        }

        $model->unsetAttributes();
        if(isset($_GET['Templates']))
            $model->attributes=$_GET['Templates'];

        $this->render('template',array(
            'model'=>$model,
        ));
    }

    public function actionUdelete($tid, $uid)
    {
        $item = TemplUser::model()->findByAttributes(array('tu_template_id'=>$tid, 'tu_user_id'=>$uid));
        $item->delete();
        $this->redirect(array('template'));
    }

    public function actionAlldelete($tid)
    {
        TemplUser::model()->deleteAll('tu_template_id='.$tid);
        Templates::model()->deleteByPk($tid);
        $this->redirect(array('template'));
    }

    public function actionCreate()
    {
        if (!empty($_POST['title'])) {
            $new_template = new Templates;
            $new_template->template_owner_id = Yii::app()->user->id;
            $new_template->template_title = $_POST['title'];
            $new_template->save();
            $this->redirect(array('template'));
        }


    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->set_user_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Settings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Settings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Settings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='settings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
