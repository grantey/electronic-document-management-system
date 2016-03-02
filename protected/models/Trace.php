<?php

/**
 * This is the model class for table "trace".
 *
 * The followings are the available columns in table 'trace':
 * @property integer $trace_id
 * @property integer $trace_order_id
 * @property integer $trace_user_to
 * @property integer $trace_user_from
 * @property string $trace_order_lstatus
 * @property integer $trace_app_id
 * @property string $trace_date
 *
 * The followings are the available model relations:
 * @property Orders $traceOrder
 * @property Users $traceUserTo
 * @property Users $traceUserFrom
 * @property Application $traceApp
 */
class Trace extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trace';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('trace_order_id, trace_user_to, trace_order_lstatus', 'required'),
			array('trace_order_id, trace_user_to, trace_user_from, trace_app_id', 'numerical', 'integerOnly'=>true),
			array('trace_order_lstatus', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('trace_id, trace_order_id, trace_user_to, trace_order_lstatus, trace_app_id, trace_date_to', 'safe', 'on'=>'search'),
            array('trace_date_to, trace_time, trace_date, trace_done_mode', 'safe'),
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
			'traceOrder' => array(self::BELONGS_TO, 'Orders', 'trace_order_id'),
			'traceUserTo' => array(self::BELONGS_TO, 'Users', 'trace_user_to'),
			'traceUserFrom' => array(self::BELONGS_TO, 'Users', 'trace_user_from'),
			'traceApp' => array(self::BELONGS_TO, 'Application', 'trace_app_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'trace_id' => 'Trace',
			'trace_order_id' => 'id документа',
			'trace_user_to' => 'Пользователь',
			'trace_user_from' => 'Отправитель',
			'trace_order_lstatus' => 'Cтатус',
			'trace_app_id' => 'Приложение',
			'trace_date_to' => 'Выполнить до',
            'trace_date' => 'Изменение',
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

		$criteria->compare('trace_id',$this->trace_id);
		$criteria->compare('trace_order_id',$this->trace_order_id);
		$criteria->compare('trace_user_to',$this->trace_user_to);
		$criteria->compare('trace_user_from',$this->trace_user_from);
		$criteria->compare('trace_order_lstatus',$this->trace_order_lstatus,true);
		$criteria->compare('trace_app_id',$this->trace_app_id);
		$criteria->compare('trace_date_to',$this->trace_date_to,true);
        $criteria->compare('trace_date',$this->trace_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function search2($id)
    {
        $criteria=new CDbCriteria;

        $criteria->compare('trace_order_id',$id);
        $criteria->compare('trace_user_from',Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Trace the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
