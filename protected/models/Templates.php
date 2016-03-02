<?php

/**
 * This is the model class for table "templates".
 *
 * The followings are the available columns in table 'templates':
 * @property integer $template_id
 * @property integer $template_owner_id
 * @property string $template_title
 *
 * The followings are the available model relations:
 * @property TemplUser[] $templUsers
 * @property Users $templateOwner
 */
class Templates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'templates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('template_owner_id, template_title', 'required'),
			array('template_owner_id', 'numerical', 'integerOnly'=>true),
			array('template_title', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('template_id, template_owner_id, template_title', 'safe', 'on'=>'search'),
            array('template_title','safe'),
            array('template_title','checkTitle', 'on'=>'insert'),
		);
	}

    public function checkTitle($attribute)
    {
        $result = Templates::model()->findByAttributes(array('template_title' => $this->template_title, 'template_owner_id' => Yii::app()->user->id));
        if (isset($result)) $this->addError($attribute, 'Название шаблона занято');
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'templUsers' => array(self::HAS_MANY, 'TemplUser', 'tu_template_id'),
			'templateOwner' => array(self::BELONGS_TO, 'Users', 'template_owner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'template_id' => 'Template',
			'template_owner_id' => 'Создатель шаблона',
			'template_title' => 'Название шаблона',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
        return new CActiveDataProvider('Users', array(
            'criteria'=>array(
                'condition'=>"user_id IN (SELECT tu_user_id FROM templ_user WHERE tu_template_id='".$this->template_id."')",
            ),
        ));
	}

    public function getTemplates($user_id)
    {
        $models = Templates::model()->findAllByAttributes(array('template_owner_id'=>$user_id));
        return CHtml::listData($models,'template_id','template_title');
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Templates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function All()
    {
        $models = Templates::model()->findAll('template_owner_id=:id', array(':id'=>Yii::app()->user->id),
            array('order' => 'template_title'));
        $list = CHtml::listData($models,
            'template_id', 'template_title');
        return $list;
    }
}
