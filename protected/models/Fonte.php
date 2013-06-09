<?php

/**
 * This is the model class for table "fonte".
 *
 * The followings are the available columns in table 'fonte':
 * @property integer $idFonte
 * @property integer $idTexto
 * @property string $nome
 *
 * The followings are the available model relations:
 * @property Texto $idTexto0
 * @property Fonteitem[] $fonteitems
 */
class Fonte extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Fonte the static model class
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
		return 'fonte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idTexto, nome', 'required'),
			array('idTexto', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idFonte, idTexto, nome', 'safe', 'on'=>'search'),
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
			'idTexto0' => array(self::BELONGS_TO, 'Texto', 'idTexto'),
			'fonteitems' => array(self::HAS_MANY, 'Fonteitem', 'idFonte'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idFonte' => 'Id Fonte',
			'idTexto' => 'Id Texto',
			'nome' => 'Nome',
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

		$criteria->compare('idFonte',$this->idFonte);
		$criteria->compare('idTexto',$this->idTexto);
		$criteria->compare('nome',$this->nome,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}