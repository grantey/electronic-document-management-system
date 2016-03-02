<?php

/**
 * This is the model class for table "application".
 *
 * The followings are the available columns in table 'application':
 * @property integer $app_id
 * @property integer $app_user_id
 * @property string $app_text
 * @property integer $app_resolution
 * @property string $app_data
 *
 * The followings are the available model relations:
 * @property Users $appUser
 * @property Resolution $appResolution
 * @property Trace[] $traces
 */
class Application extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'application';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('app_resolution', 'required'),
			array('app_user_id, app_resolution', 'numerical', 'integerOnly'=>true),
            array('app_text, app_resolution, app_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('app_id, app_user_id, app_text, app_resolution, app_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'appUser' => array(self::BELONGS_TO, 'Users', 'app_user_id'),
			'appResolution' => array(self::BELONGS_TO, 'Resolution', 'app_resolution'),
			'traces' => array(self::HAS_MANY, 'Trace', 'trace_app_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'app_id' => 'Код',
			'app_user_id' => 'Автор',
			'app_text' => 'Комментарии',
			'app_resolution' => 'Заключение',
			'app_date' => 'Выполнить до',
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

		$criteria=new CDbCriteria;

		$criteria->compare('app_id',$this->app_id);
		$criteria->compare('app_user_id',$this->app_user_id);
		$criteria->compare('app_text',$this->app_text,true);
		$criteria->compare('app_resolution',$this->app_resolution);
		$criteria->compare('app_date',$this->app_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Application the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
