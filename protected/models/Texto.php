<?php

/**
 * This is the model class for table "texto".
 *
 * The followings are the available columns in table 'texto':
 * @property integer $idTexto
 * @property string $codigo
 * @property string $titulo
 * @property string $data
 *
 * The followings are the available model relations:
 * @property Fonte[] $fontes
 * @property Textoitem[] $textoitems
 */
class Texto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Texto the static model class
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
		return 'texto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo, titulo, data', 'required'),
			array('codigo', 'length', 'max'=>4),
			array('titulo', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idTexto, codigo, titulo, data', 'safe', 'on'=>'search'),
		);
	}
	
	protected function beforeSave()
	{
		parent::beforeSave();
		//Faz tratamento das datas
		$this->data = $this->inverteData($this->data);
		
		return true;
	}
	
	public static function inverteData($date, $mostrarHora =  FALSE)
	{
		if(is_null($date) || empty($date) || $date == '0000-00-00') return '';
		
		/**
		 * TODO: Validar se vai mostrar a hora ou não
		 * TODO: Se for pra mostrar a hora, e não tiver a hora, pegar hora do sistema
		 */
		if(strpos($date,"-")!==false){
			$date = str_replace("-","/",$date);
		}
		
		$dados = explode(" ", $date);
		$data = explode("/",$dados[0]);
	        if(count($dados) == 1)
	            return $data[2]."/".$data[1]."/".$data[0];
	        else
	            return $data[2]."/".$data[1]."/".$data[0]." - ".$dados[1];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'fontes' => array(self::HAS_MANY, 'Fonte', 'idTexto'),
			'textoitems' => array(self::HAS_MANY, 'Textoitem', 'idTexto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idTexto' => 'Id Texto',
			'codigo' => 'Código',
			'titulo' => 'Título',
			'data' => 'Data',
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

		$criteria->compare('idTexto',$this->idTexto);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}