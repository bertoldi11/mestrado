<?php
$this->breadcrumbs=array(
	'Textos',
);

?>

<h1>Textos</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

<br><hr><br>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped',
	'template'=>"{items}",
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array('name'=> 'idTexto', 'header'=>'ID Texto'),
		array('name'=> 'codigo', 'header'=>'Código'),
		array('name'=> 'titulo', 'header'=>'Título'),
		array('name'=> 'data', 'header'=>'Data', 'value'=>'Texto::inverteData($data->data)'),
		array(
			'htmlOptions' => array('nowrap'=>'nowrap'),
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{analisar}&nbsp;&nbsp; {update}&nbsp;&nbsp; {delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("texto/alterar", array("id"=>"$data->idTexto"))',
			'deleteButtonUrl'=>'Yii::app()->createUrl("texto/delete", array("id"=>"$data->idTexto"))',
			'buttons'=>array(
				'analisar'=>array(
					'label'=>'Analisar Texto',
					'url'=>'Yii::app()->createUrl("texto/analisar", array("id"=>"$data->idTexto"))',
					'icon'=>'icon-th-list',
					'options'=>array('class'=>'analisarTexto'),
					//'click'=>"js: function(event){event.preventDefault(); montarModalPefil(this);}",
				),
			),
		)
	),
));?>
