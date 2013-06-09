<?php
$this->breadcrumbs=array(
	'Temas',
);

?>

<h1>Temas</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<br><hr><br>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped',
	'template'=>"{items}",
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array('name'=> 'codigo', 'header'=>'Código'),
		array('name'=> 'idCategoria0.descricao', 'header'=>'Categoria'),
		array('name'=> 'descricao', 'header'=>'Tema'),
		array('name'=> 'obrigatorio', 'header'=>'Obrigatório', 'value'=>'($data->obrigatorio == "S")? "Sim" : "Não";'),
		array('name'=> 'multiplo', 'header'=>'Múltiplo', 'value'=>'($data->multiplo == "S")? "Sim" : "Não";'),
		array(
			'htmlOptions' => array('nowrap'=>'nowrap'),
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update} {delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("tema/alterar", array("id"=>"$data->idTema"))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("tema/delete", array("id"=>"$data->idTema"))',
		)
	),
));?>
