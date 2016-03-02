<?php

/**
 * This is the model class for table "files".
 *
 * The followings are the available columns in table 'files':
 * @property integer $file_id
 * @property string $file_path
 * @property string $file_name
 * @property string $file_upload_date
 *
 * The followings are the available model relations:
 * @property OrderFile[] $orderFiles
 */
class Files extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('file_path, file_name, file_upload_date', 'required'),
			array('file_path, file_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('file_id, file_path, file_name, file_upload_date', 'safe', 'on'=>'search'),
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
            'orders' => array(self::MANY_MANY, 'Orders', 'order_file(of_order_id, of_file_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file_id' => 'File',
			'file_path' => 'File Path',
			'file_name' => 'File Name',
			'file_upload_date' => 'File Upload Date',
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

		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('file_path',$this->file_path,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_upload_date',$this->file_upload_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Files the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
