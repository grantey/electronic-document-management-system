<?php

/**
 * This is the model class for table "receivers".
 *
 * The followings are the available columns in table 'receivers':
 * @property integer $receiver_id
 * @property integer $receiver_order_id
 * @property integer $receiver_from
 * @property integer $receiver_to
 *
 * The followings are the available model relations:
 * @property Users $receiverTo
 * @property Orders $receiverOrder
 * @property Users $receiverFrom
 */
class Receivers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receivers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receiver_order_id, receiver_from, receiver_to', 'required'),
			array('receiver_id, receiver_order_id, receiver_from, receiver_to', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('receiver_id, receiver_order_id, receiver_from, receiver_to', 'safe', 'on'=>'search'),
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
			'receiverTo' => array(self::BELONGS_TO, 'Users', 'receiver_to'),
			'receiverOrder' => array(self::BELONGS_TO, 'Orders', 'receiver_order_id'),
			'receiverFrom' => array(self::BELONGS_TO, 'Users', 'receiver_from'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'receiver_id' => 'Receiver',
			'receiver_order_id' => 'Receiver Order',
			'receiver_from' => 'Receiver From',
			'receiver_to' => 'Receiver To',
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

		$criteria->compare('receiver_id',$this->receiver_id);
		$criteria->compare('receiver_order_id',$this->receiver_order_id);
		$criteria->compare('receiver_from',$this->receiver_from);
		$criteria->compare('receiver_to',$this->receiver_to);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Receivers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
