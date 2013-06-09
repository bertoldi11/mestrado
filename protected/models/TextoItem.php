<?php

/**
 * This is the model class for table "textoitem".
 *
 * The followings are the available columns in table 'textoitem':
 * @property integer $idTextoItem
 * @property integer $idItem
 * @property integer $idTexto
 *
 * The followings are the available model relations:
 * @property Item $idItem0
 * @property Texto $idTexto0
 */
class TextoItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TextoItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'textoitem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idItem, idTexto', 'required'),
			array('idItem, idTexto', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idTextoItem, idItem, idTexto', 'safe', 'on'=>'search'),
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
			'idItem0' => array(self::BELONGS_TO, 'Item', 'idItem'),
			'idTexto0' => array(self::BELONGS_TO, 'Texto', 'idTexto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idTextoItem' => 'Id Texto Item',
			'idItem' => 'Id Item',
			'idTexto' => 'Id Texto',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idTextoItem',$this->idTextoItem);
		$criteria->compare('idItem',$this->idItem);
		$criteria->compare('idTexto',$this->idTexto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}