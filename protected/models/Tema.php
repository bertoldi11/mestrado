<?php

/**
 * This is the model class for table "tema".
 *
 * The followings are the available columns in table 'tema':
 * @property integer $idTema
 * @property integer $idCategoria
 * @property integer $codigo
 * @property string $descricao
 * @property string $obrigatorio
 * @property string $multiplo
 *
 * The followings are the available model relations:
 * @property Item[] $items
 * @property Categoria $idCategoria0
 */
class Tema extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tema the static model class
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
		return 'tema';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idCategoria, codigo, descricao', 'required'),
			array('idCategoria, codigo', 'numerical', 'integerOnly'=>true),
			array('descricao', 'length', 'max'=>255),
			array('obrigatorio, multiplo', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idTema, idCategoria, codigo, descricao, obrigatorio, tipo', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'Item', 'idTema'),
			'idCategoria0' => array(self::BELONGS_TO, 'Categoria', 'idCategoria'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idTema' => 'Cod. Tema',
			'idCategoria' => 'Categoria',
			'codigo' => 'Código',
			'descricao' => 'Descrição',
			'obrigatorio' => 'Obrigatório',
			'multiplo' => 'Múltiplo',
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

		$criteria->compare('idTema',$this->idTema);
		$criteria->compare('idCategoria',$this->idCategoria);
		$criteria->compare('codigo',$this->codigo);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('obrigatorio',$this->obrigatorio,true);
		$criteria->compare('multiplo',$this->multiplo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}