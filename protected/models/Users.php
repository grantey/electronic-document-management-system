<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property string $user_login
 * @property string $user_password
 * @property string $user_full_name
 * @property string $user_post
 * @property string $user_phone
 * @property string $user_faculty
 * @property string $user_depart
 *
 * The followings are the available model relations:
 * @property Orders[] $orders
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

    public $user_list;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_BANNED = 'banned';

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_login, user_password, user_full_name, user_post', 'required'),
			array('user_login, user_password, user_phone', 'length', 'max'=>50),
			array('user_full_name, user_post, user_faculty, user_depart', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, user_login, user_password, user_full_name, user_post, user_phone, user_faculty, user_depart', 'safe', 'on'=>'search'),
            array('user_login','checkLogin','on'=>'insert'),
		);
	}

    public function checkLogin($attribute)
    {
        $result = Users::model()->findByAttributes(array('user_login' => $this->user_login));
        if (isset($result)) $this->addError($attribute, 'Логин занят');
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'orders' => array(self::HAS_MANY, 'Orders', 'order_owner_id'),
           // 'receivers_from' => array(self::HAS_MANY, 'Receivers', 'receiver_user_from'),
          //  'receivers_to' => array(self::HAS_MANY, 'Receivers', 'receiver_user_to'),
          //  'receivers' => array(self::HAS_MANY, 'Receivers', '', 'on'=>'receiver_from=user_id'),
            'ordersCount'=>array(self::STAT, 'Orders', 'order_owner_id'),
            'settings' => array(self::HAS_ONE, 'Settings', 'set_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'ID пользователя',
			'user_login' => 'Логин',
			'user_password' => 'Пароль',
			'user_full_name' => 'ФИО',
			'user_post' => 'Должность',
			'user_phone' => 'Телефон',
			'user_faculty' => 'Факультет',
			'user_depart' => 'Кафедра',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_login',$this->user_login,true);
		$criteria->compare('user_password',$this->user_password,true);
		$criteria->compare('user_full_name',$this->user_full_name,true);
		$criteria->compare('user_post',$this->user_post,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_faculty',$this->user_faculty,true);
		$criteria->compare('user_depart',$this->user_depart,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function search2($order_id)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

   //     $sql = "SELECT * FROM users WHERE user_id IN (SELECT r.receiver_to FROM receivers r WHERE r.receiver_order_id='".$order_id."' AND r.receiver_from='".Yii::app()->user->id."')";
   //     $rawData = Yii::app()->db->createCommand($sql)->queryAll();

    /*    return new CArrayDataProvider($rawData, array(
        ));*/

        return new CActiveDataProvider('Users', array(
            'criteria'=>array(
                'condition'=>"user_id IN (SELECT r.receiver_to FROM receivers r WHERE r.receiver_order_id='".$order_id."' AND r.receiver_from='".Yii::app()->user->id."')",
            ),
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
