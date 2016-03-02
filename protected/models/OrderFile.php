<?php

/**
 * This is the model class for table "order_file".
 *
 * The followings are the available columns in table 'order_file':
 * @property integer $of_order_id
 * @property integer $of_file_id
 *
 * The followings are the available model relations:
 * @property Orders $ofOrder
 * @property Files $ofFile
 */
class OrderFile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_file';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('of_order_id, of_file_id', 'required'),
			array('of_order_id, of_file_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('of_order_id, of_file_id', 'safe', 'on'=>'search'),
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
			'ofOrder' => array(self::BELONGS_TO, 'Orders', 'of_order_id'),
			'ofFile' => array(self::BELONGS_TO, 'Files', 'of_file_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'of_order_id' => 'Of Order',
			'of_file_id' => 'Of File',
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

		$criteria->compare('of_order_id',$this->of_order_id);
		$criteria->compare('of_file_id',$this->of_file_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderFile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
