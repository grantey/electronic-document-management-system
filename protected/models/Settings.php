<?php

/**
 * This is the model class for table "settings".
 *
 * The followings are the available columns in table 'settings':
 * @property integer $set_user_id
 * @property integer $set_alert
 * @property integer $set_archive
 *
 * The followings are the available model relations:
 * @property Users $setUser
 */
class Settings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('set_user_id, set_alert, set_archive, set_old', 'required'),
			array('set_user_id, set_alert, set_archive, set_old', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('set_user_id, set_alert, set_archive, set_old, set_auto', 'safe', 'on'=>'search'),
            array('set_user_id, set_auto','safe'),
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
			'setUser' => array(self::BELONGS_TO, 'Users', 'set_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'set_user_id' => 'ID пользователя',
			'set_alert' => 'Выводить предупреждение о приближении срока исполнения (дней)',
			'set_archive' => 'Переводить документ в архив из раздела "Старые" (дней)',
            'set_old' => 'Переводить документ в раздел "Cтарые" из раздела "Исполненные" (дней)',
            'set_auto' => 'Переводить документ в "Исполненные" при выполнении',
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

		$criteria->compare('set_user_id',$this->set_user_id);
		$criteria->compare('set_alert',$this->set_alert);
		$criteria->compare('set_archive',$this->set_archive);
        $criteria->compare('set_old',$this->set_old);
        $criteria->compare('set_auto',$this->set_auto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Settings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
