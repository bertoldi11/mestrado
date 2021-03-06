<?php

class TemaController extends Controller
{
	// Caso esteja sendo feito um update, salva o modulo aqui para poder ler na action index que monta a view.
	private $_model=null;
	
	//Manter a categoria selecionada para facilitar salvar.
	private $_idCategoria=null;

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
				'actions' => array('novo', 'alterar', 'delete', 'index'), 
				'users' => array('@'), 
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionNovo()
	{
		$model=new Tema;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tema']))
		{
			$model->attributes=$_POST['Tema'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Dados Salvos.');
				$model=new Tema;
				$model->idCategoria = $_POST['Tema']['idCategoria'];
			}
		}

		$this->_model = $model;
		$this->actionIndex();
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

		if(isset($_POST['Tema']))
		{
			$model -> attributes = $_POST['Tema'];
			if($model->save())
			{
				Yii::app()->user->setFlash('success', 'Dados Alterados.');
				$this->redirect('/tema/index.html');
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
		$model=(is_null($this->_model)) ? new Tema : $this->_model;
			
		$dataProvider=new CActiveDataProvider('Tema', array('pagination'=>false));

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
		$model=Tema::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tema-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
