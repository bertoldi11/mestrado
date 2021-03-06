<?php

/**
 * This is the model class for table "item".
 *
 * The followings are the available columns in table 'item':
 * @property integer $idItem
 * @property integer $idTema
 * @property string $descricao
 * @property integer $codigo
 * @property string $tipo
 *
 * The followings are the available model relations:
 * @property Tema $idTema0
 * @property Textoitem[] $textoitems
 */
class Item extends CActiveRecord
{
	public $codigoTema;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Item the static model class
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
		return 'item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idTema, descricao, codigo', 'required'),
			array('idTema, codigo', 'numerical', 'integerOnly'=>true),
			array('descricao', 'length', 'max'=>255),
			array('tipo', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idItem, idTema, descricao, codigo, tipo', 'safe', 'on'=>'search'),
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
			'idTema0' => array(self::BELONGS_TO, 'Tema', 'idTema'),
			'textoitems' => array(self::HAS_MANY, 'Textoitem', 'idItem'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idItem' => 'Id Item',
			'idTema' => 'Tema',
			'descricao' => 'Descrição',
			'codigo' => 'Código',
			'tipo' => 'Tipo',
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

		$criteria->compare('idItem',$this->idItem);
		$criteria->compare('idTema',$this->idTema);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('codigo',$this->codigo);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}