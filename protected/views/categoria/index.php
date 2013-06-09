<?php
$this->breadcrumbs=array(
	'Categorias',
);

?>

<h1>Categorias</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<br><hr><br>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped',
	'template'=>"{items}",
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array('name'=> 'idCategoria', 'header'=>'Código'),
		array('name'=> 'descricao', 'header'=>'Categoria'),
		array('name'=> 'repetir', 'header'=>'Repetir', 'value'=>'($data->repetir == "S")? "Sim" : "Não";'),
		array(
			'htmlOptions' => array('nowrap'=>'nowrap'),
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update} {delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("categoria/alterar", array("id"=>"$data->idCategoria"))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("categoria/delete", array("id"=>"$data->idCategoria"))',
		)
	),
));?>