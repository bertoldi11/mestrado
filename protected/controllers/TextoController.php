<?php

class TextoController extends Controller
{
	// Caso esteja sendo feito um update, salva o modulo aqui para poder ler na action index que monta a view.
	private $_model=null;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array( 
			array('allow', 
				'actions' => array('novo', 'alterar', 'delete', 'index','analisar', 'salvarAnalise', 'consulta', 'buscar','totalFontes','consultaFontes','buscarFontes'), 
				'users' => array('@'), 
			), 
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionBuscarFontes()
	{
		$itensFonte = implode(',', $_POST['Fonte']);
		$sqlData = "";
		$data = false;
		$fontesContem = array();
		
		if(isset($_POST['Conjunto']))
		{
			$conjunto = implode(',', $_POST['Conjunto']);
			$quant = count($_POST['Conjunto']);
			
			$criterio = new CDbCriteria();
			$criterio->select = 'idFonte';
			$criterio->condition ="`idItem` in ($conjunto)";

			$fontesConjunto = FonteItem::model()->findAll($criterio);
			
			$idsFontes= array();
			
			if(count($fontesConjunto) > 0)
			{
				foreach($fontesConjunto as $fonte)
				{
					$idsFontes[$fonte->idFonte]=$fonte->idFonte;
				}
				
	
				$quantConjunto = count($idsFontes);
				$idsFontes = implode(',', $idsFontes);			
			
				$fontesComItens = FonteItem::model()->findAll('idFonte in('.$idsFontes.') AND idItem in('.$itensFonte.')');
	
				$quantContem = count($fontesComItens);
			}
			else
			{
				$quantConjunto = 0;
				$quantContem = 0;
			}
		}
		elseif(isset($_POST['todos']))
		{

			$quantConjunto = Fonte::model()->count();				
			$sqlFonteItem = 'idItem in('.$itensFonte.')';				
			
			$fontesComItens = FonteItem::model()->findAll($sqlFonteItem);
			$quantContem = count($fontesComItens);	
		}
		
		$textoResultado = "Nenhuma fonte foi localizada com os parametros de conjunto.";
		
		if($quantConjunto > 0)
		{		
			$resultado = round(($quantContem/$quantConjunto)*100,2);			
			$textoResultado = "Das $quantConjunto Fontes do conjunto, $quantContem contem os dados procurados. Ou seja: $resultado %.";
		}
		
	
		$this->render('resultado', array(
			'resultado'=>$textoResultado,
			'textosContem'=>array()	
		));
	}
	
	public function actionConsultaFontes()
	{
		$modelConsulta = new ConsultaFonteForm;	

		$this->render('consultafonte', array(
			'modelConsulta'=>$modelConsulta,			
		));
	}
	
	public function actionTotalFontes()
	{
		$criteriaTotalItens = new CDbCriteria();
		$criteriaTotalItens->select = 'COUNT(idFonte) as quant, t.idItem';
		$criteriaTotalItens->group = 't.idItem';
		$criteriaTotalItens->order = 't.idItem';
		
		$this->render('totalfontes', array(
			'totalItens'=>FonteItem::model()->with('idItem0','idItem0.idTema0')->findAll($criteriaTotalItens),
		));
	}
	
	public function actionSalvarAnalise()
	{
		# TODO: Consulta de texto com os itens de cada um (relatório de exibição).	
			
		$idTexto = $_POST['idTexto'];
		if(isset($_POST['itensTexto']) && count($_POST['itensTexto']) > 0)
		{
			//Salva os itens relacionados ao texto.	
			$itens = $_POST['itensTexto'];
			TextoItem::model()->deleteAll('idTexto = :idTexto', array(':idTexto'=>$idTexto));
			foreach($itens as $item)
			{
				$model = new TextoItem;
				$model->attributes= array('idTexto'=>$idTexto,'idItem'=>$item);
				$model->save();
			}
			
			//Salva os itens da fonte
			if(isset($_POST['itensFonte']))
			{
				$itensFonte = $_POST['itensFonte'];
				foreach($itensFonte as $fonte=>$itens)
				{
					FonteItem::model()->deleteAll('idFonte = :idFonte', array(':idFonte'=>$fonte));
					foreach($itens as $item)
					{
						$model = new FonteItem;
						$model->attributes= array('idFonte'=>$fonte,'idItem'=>$item);
						$model->save();
					}
				}
			}
			

			Yii::app()->user->setFlash('success', 'Dados Salvos.');
		}
		else
		{
			Yii::app()->user->setFlash('warning', 'Você deve preencher os dados antes de salvar.');
		}
		
		$this->actionAnalisar($idTexto);
	}
	
	public function actionBuscar()
	{
		$itensContem = implode(',', $_POST['Contem']);
		$sqlData = "";
		$data = false;
		$textosContem = array();
		
		if(!empty($_POST['dataInicio']) && !empty($_POST['dataFim']))
		{
			$data = true;
			$ini = Texto::inverteData($_POST['dataInicio']);
			$fim = Texto::inverteData($_POST['dataFim']);
			
			$sqlData = "(data between '$ini' and '$fim')";
		}
		
		if(isset($_POST['Conjunto']))
		{
			$conjunto = implode(',', $_POST['Conjunto']);
			$quant = count($_POST['Conjunto']);
				
			$criterio = new CDbCriteria();
			$criterio->select = 'count(idItem) as quant,idTexto';
			$criterio->condition =($data) ? "`idItem` in ($conjunto) AND ".$sqlData: "`idItem` in ($conjunto)";
			$criterio->group = 't.idTexto';
			$criterio->having = "`quant` = $quant";
			
			$textosConjunto = ($data) ? TextoItem::model()->with('idTexto0')->findAll($criterio)
									  : TextoItem::model()->findAll($criterio);
			
			$idsTextos = array();
			
			
			if(count($textosConjunto) > 0)
			{
				foreach($textosConjunto as $texto)
				{
					$idsTextos[$texto->idTexto]=$texto->idTexto;
				}
				
	
				$quantConjunto = count($idsTextos);
				$idsTextos = implode(',', $idsTextos);			
			
				$textoComItens = TextoItem::model()->findAll('idTexto in('.$idsTextos.') AND idItem in('.$itensContem.')');
	
				$quantContem = count($textoComItens);
				
				foreach($textoComItens as $item)
				{
					$textosContem[] = $item->idTexto;
				}
			}
			else
			{
				$quantConjunto = 0;
				$quantContem = 0;
			}
		}
		elseif(isset($_POST['todos']))
		{
			if($data)
			{
				$textosConjunto = Texto::model()->findAll($sqlData);
				$idsTextos = array();
				
				foreach($textosConjunto as $texto)
				{
					$idsTextos[$texto->idTexto]=$texto->idTexto;
				}
				
				$quantConjunto = count($idsTextos);
				$idsTextos = implode(',', $idsTextos);			
				
				$sqlTextoItem = 'idTexto in('.$idsTextos.') AND idItem in('.$itensContem.')';

			}	
			else
			{
				$quantConjunto = Texto::model()->count();				
				$sqlTextoItem = 'idItem in('.$itensContem.')';				
			}
			
			$textoComItens = TextoItem::model()->findAll($sqlTextoItem);
			$quantContem = count($textoComItens);
			
			foreach($textoComItens as $item)
			{
				$textosContem[] = $item->idTexto;
			}
		}
		
		$textoResultado = "Nenhum texto foi localizado com os parametros de conjunto.";
		
		if($quantConjunto > 0)
		{		
			$resultado = round(($quantContem/$quantConjunto)*100,2);			
			$textoResultado = "Dos $quantConjunto textos do conjunto, $quantContem contem os dados procurados. Ou seja: $resultado %.";
		}
		
		$resTextoContem = Texto::model()->findAll('idTexto in('.implode(',', $textosContem).')');

		$this->render('resultado', array(
			'resultado'=>$textoResultado,
			'textosContem'=>$resTextoContem	
		));
	}
	
	public function actionConsulta()
	{
		$modelConsulta = new ConsultaForm;	
		$this->render('consulta', array(
			'modelConsulta'=>$modelConsulta,			
		));
	}
	
	public function actionAnalisar($id)
	{
		$model = $this->loadModel($id);
		
		$dataProviderQuestoes=new CActiveDataProvider('Categoria', array(
				'criteria'=>array(
					'with'=>array('temas', 'temas.items')
				),				
			)
		);
		
		$itensTexto = array();
		foreach($model->textoitems as $item)
		{
			$itensTexto[] = $item->idItem;
		}
		
		$itensFontes = array();
		foreach($model->fontes as $fonte)
		{
			$modelFontes = FonteItem::model()->findAllByAttributes(array('idFonte'=>$fonte->idFonte));		
			
			$itensFontes[$fonte->idFonte] = array();
			foreach($modelFontes as $itemFonte)
			{
				$itensFontes[$fonte->idFonte][]=$itemFonte->idItem;
			}
			
		}

		$this->render('analisar',array(
			'model'=>$model,
			'dataProviderQuestoes'=>$dataProviderQuestoes,
			'itensTexto'=>$itensTexto,
			'itensFontes'=>$itensFontes
		));
	}
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionNovo()
	{
		$model=new Texto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Texto']))
		{
			$model->attributes=$_POST['Texto'];
			if($model->save())
			{
				if(isset($_POST['Fonte']))
				{
					$fontes = $_POST['Fonte'];					
					foreach($fontes as $fonte)
					{
						$modelFonte = new Fonte;
						$modelFonte->attributes = array('idTexto'=>$model->idTexto, 'nome'=>$fonte[0]);
						$modelFonte->save();
					}
				}	
				Yii::app()->user->setFlash('success', 'Dados Salvos.');
			}
			else
			{
				$this->_model = $model;
				$this->actionIndex();
				exit;
			}
		}

		$this->redirect('index');
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionAlterar($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Texto']))
		{
			$model->attributes=$_POST['Texto'];
			if($model->save())
			{
				if(isset($_POST['Fonte']))
				{
					$fontes = $_POST['Fonte'];					
					foreach($fontes as $fonte)
					{
						$modelFonte = new Fonte;
						$modelFonte->attributes = array('idTexto'=>$model->idTexto, 'nome'=>$fonte[0]);
						$modelFonte->save();
					}
				}
				
				Yii::app()->user->setFlash('success', 'Dados Alterados.');
				$this->redirect('/texto/index.html');
			}
		}

		$this->_model = $model;		
		$this->actionIndex();
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=(is_null($this->_model)) ? new Texto : $this->_model;		
		$dataProvider=new CActiveDataProvider('Texto', array('pagination'=>false));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Texto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='texto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
