<?php

/**
 * This is the model class for table "categoria".
 *
 * The followings are the available columns in table 'categoria':
 * @property integer $idCategoria
 * @property string $descricao
 * @property string $repetir
 *
 * The followings are the available model relations:
 * @property Tema[] $temas
 */
class Categoria extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Categoria the static model class
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
		return 'categoria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descricao', 'required'),
			array('descricao', 'length', 'max'=>45),
			array('repetir', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idCategoria, descricao, repetir', 'safe', 'on'=>'search'),
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
			'temas' => array(self::HAS_MANY, 'Tema', 'idCategoria'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idCategoria' => 'Categoria',
			'descricao' => 'Descrição',
			'repetir' => 'Repetir',
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

		$criteria->compare('idCategoria',$this->idCategoria);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('repetir',$this->repetir,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}