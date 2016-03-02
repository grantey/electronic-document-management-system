<?php

/**
 * This is the model class for table "archive".
 *
 * The followings are the available columns in table 'archive':
 * @property integer $a_order_id
 * @property string $a_order_header
 * @property string $a_order_text
 * @property string $a_order_data_from
 * @property string $a_order_data_to
 * @property integer $a_order_type
 * @property integer $a_order_status
 * @property integer $a_user_id
 * @property string $a_date
 */
class Archive extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'archive';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('a_order_header, a_order_data_from, a_order_data_to, a_order_type, a_order_status, a_user_id, a_date', 'required'),
			array('a_order_type, a_order_status, a_user_id', 'numerical', 'integerOnly'=>true),
			array('a_order_header', 'length', 'max'=>200),
			array('a_order_text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('a_order_id, a_order_header, a_order_text, a_order_data_from, a_order_data_to, a_order_type, a_order_status, a_user_id, a_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'a_order_id' => 'A Order',
			'a_order_header' => 'A Order Header',
			'a_order_text' => 'A Order Text',
			'a_order_data_from' => 'A Order Data From',
			'a_order_data_to' => 'A Order Data To',
			'a_order_type' => 'A Order Type',
			'a_order_status' => 'A Order Status',
			'a_user_id' => 'A User',
			'a_date' => 'A Date',
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

		$criteria->compare('a_order_id',$this->a_order_id);
		$criteria->compare('a_order_header',$this->a_order_header,true);
		$criteria->compare('a_order_text',$this->a_order_text,true);
		$criteria->compare('a_order_data_from',$this->a_order_data_from,true);
		$criteria->compare('a_order_data_to',$this->a_order_data_to,true);
		$criteria->compare('a_order_type',$this->a_order_type);
		$criteria->compare('a_order_status',$this->a_order_status);
		$criteria->compare('a_user_id',$this->a_user_id);
		$criteria->compare('a_date',$this->a_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Archive the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
