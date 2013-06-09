<?php
$this->breadcrumbs=array(
	'Items',
);

?>

<h1>Items</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<br><hr><br>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped',
	'template'=>"{items}",
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array('name'=> 'codigo', 'header'=>'Código', 'value'=>'$data->idTema0->codigo.".".$data->codigo'),
		array('name'=> 'idTema0.idCategoria0.descricao', 'header'=>'Categoria'),
		array('name'=> 'idTema0.descricao', 'header'=>'Tema'),
		array('name'=> 'descricao', 'header'=>'Item'),
		array(
			'htmlOptions' => array('nowrap'=>'nowrap'),
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{update} {delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("item/alterar", array("id"=>"$data->idItem"))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("item/delete", array("id"=>"$data->idItem"))',
		)
	),
));?>
