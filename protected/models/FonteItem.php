<?php

/**
 * This is the model class for table "fonteitem".
 *
 * The followings are the available columns in table 'fonteitem':
 * @property integer $idFonteItem
 * @property integer $idFonte
 * @property integer $idItem
 *
 * The followings are the available model relations:
 * @property Fonte $idFonte0
 * @property Item $idItem0
 */
class FonteItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FonteItem the static model class
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
		return 'fonteItem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idFonte, idItem', 'required'),
			array('idFonte, idItem', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idFonteItem, idFonte, idItem', 'safe', 'on'=>'search'),
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
			'idFonte0' => array(self::BELONGS_TO, 'Fonte', 'idFonte'),
			'idItem0' => array(self::BELONGS_TO, 'Item', 'idItem'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idFonteItem' => 'Id Fonte Item',
			'idFonte' => 'Id Fonte',
			'idItem' => 'Id Item',
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

		$criteria->compare('idFonteItem',$this->idFonteItem);
		$criteria->compare('idFonte',$this->idFonte);
		$criteria->compare('idItem',$this->idItem);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}