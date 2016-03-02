<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $order_id
 * @property string $order_text
 * @property string $order_data_from
 * @property string $order_data_to
 * @property integer $order_type
 * @property integer $order_group
 * @property integer $order_status
 * @property integer $order_lstatus
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */
class Orders extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

    const ORDER_IN_WORK = 'В работе';
    const ORDER_NEW = 'Новый';
    const ORDER_DONE = 'Исполнен';
    const ORDER_OLD = 'На хранении';

    public $order_date_to;
    public $order_date;
    public $order_lstatus;

	public function tableName()
	{
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_header, order_data_from, order_data_to, order_type', 'required'),
			array('order_type, order_status', 'numerical', 'integerOnly'=>true),
            array('order_header', 'length', 'max'=>200),
			array('order_text', 'safe'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_id, order_date_to, order_date, order_type, order_header, order_lstatus', 'safe', 'on'=>'search'),
            array('order_text, order_data_from, order_data_to, order_type, order_status, order_header', 'safe'),
            //array('upfiles','file','allowEmpty'=>true,'maxFiles'=>10, 'maxSize'=>5*1024*1024),
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
            'category' => array(self::BELONGS_TO, 'Category', 'order_type'),
            'status' => array(self::BELONGS_TO, 'Status', 'order_status'),
            'orderFiles' => array(self::HAS_MANY, 'OrderFile', 'of_order_id'),
            'files' => array(self::HAS_MANY, 'Files', 'of_file_id', 'through' => 'orderFiles'),
            'traces' => array(self::HAS_MANY, 'Trace', 'trace_order_id', 'on'=>'trace_user_to='.Yii::app()->user->id),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'order_id' => 'Код документа',
            'order_header' => 'Заголовок',
			'order_text' => 'Текст документа',
			'order_date' => 'Изменение',
			'order_date_to' => 'Выполнить до',
			'order_type' => 'Тип документа',
			'order_lstatus' => 'Статус',
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
	public function search($type)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with = array('traces');
        $criteria->together = true;

        switch ($type)
        {
            case 1: $criteria->condition='traces.trace_order_lstatus="'.Orders::ORDER_NEW.'"'; break;
            case 2: $criteria->condition='traces.trace_order_lstatus="'.Orders::ORDER_IN_WORK.'"'; break;
            case 3: $criteria->condition='traces.trace_order_lstatus="'.Orders::ORDER_DONE.'"'; break;
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function search2()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->with = array('traces');
        $criteria->together = true;

        $criteria->compare('order_id',$this->order_id, true);
        //$criteria->condition = "order_id IN (SELECT trace_order_id FROM trace WHERE trace_user_to='".Yii::app()->user->id."'";
        $criteria->addSearchCondition('order_header',$this->order_header, $like='LIKE');
        $criteria->compare('traces.trace_date_to',$this->order_date_to);
        $criteria->compare('traces.trace_date',$this->order_date);
        $criteria->compare('traces.trace_user_to',Yii::app()->user->id);
        $criteria->compare('order_type',$this->order_type, true);

        if ($this->order_lstatus != 'empty') $criteria->compare('traces.trace_order_lstatus',$this->order_lstatus);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function alertsearch()
    {
        $dataProvider=new CActiveDataProvider('Orders', array(
            'criteria' => array(
                'with'=>array('traces'=>array(
                    'condition'=>'DATEDIFF(CURDATE(), trace_date_to) > -'.Yii::app()->session['set_alert'].' AND trace_order_lstatus != "'.Orders::ORDER_DONE.'" AND trace_order_lstatus != "'.Orders::ORDER_OLD.'"',
                   // 'params'=>array('dTo'=>date('Y-m-d')),
                    'together'=>true,
                )),
            ),
            'pagination'=>array(
                'pageSize'=>50,
            ),
        ));

        return $dataProvider;
    }

    public function TimeToMove($id)
    {
        $trace = Trace::model()->findByAttributes(array('trace_order_id' => $id, 'trace_user_to' => Yii::app()->user->id));
        $datediff = time() - strtotime($trace->trace_date);
        return $trace->trace_time - floor($datediff/86400);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave() {
        if(parent::beforeSave()) {
            $this->order_data_to = date('Y-m-d', strtotime($this->order_data_to));//strtotime($this->order_data_to);
            $this->order_data_from = date('Y-m-d', strtotime($this->order_data_from));//strtotime($this->order_data_from);
            return true;
        } else {
            return false;
        }
    }
/*
    protected function afterSave() {
        parent::afterSave();
        if ($this->isNewRecord) {
            $file = new File;
            $file->file_path = $this->file_path;
            $file->file_name = $this->file_name;
            $file->save();
        }
    }*/

    protected function afterFind() {
        $date = date('d.m.Y', strtotime($this->order_data_to));
        $this->order_data_to = $date;
        $date = date('d.m.Y', strtotime($this->order_data_from));
        $this->order_data_from = $date;
        parent::afterFind();
    }
}
