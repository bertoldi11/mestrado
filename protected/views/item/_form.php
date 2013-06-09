<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-form',
	'enableAjaxValidation'=>false,
	'action'=> ($model->isNewRecord)? $this->createUrl('item/novo') : $this->createUrl('item/alterar', array('id'=>$model->idItem)),
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="clearfix">
		<?php 
			$temas = CHtml::listData(Tema::model()->findAll(array('order'=>'idCategoria, idTema')), 'idTema', 
				function($tema) {
					return CHtml::encode($tema->codigo." . ".$tema->descricao );
				},
				function($tema){
					return CHtml::encode($tema->idCategoria0->descricao);
				}
			);
			echo $form->dropDownListRow($model,'idTema', $temas, array('class'=>'span2', 'prompt'=>'selecione'));
		?>
	</div>
	<div class="clearfix">	
		<div class="pull-left">
			<?php echo $form->textFieldRow($model,'codigo',array('class'=>'span1', 'prepend'=>($model->codigoTema > 0) ? $model->codigoTema."." : " ")); ?>
		</div>
		<div class="pull-left" style="margin-left: 15px;">
			<?php echo $form->textFieldRow($model,'descricao',array('class'=>'span5','maxlength'=>255)); ?>
		</div>
	</div>
	<div class="clearfix">
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Salvar' : 'Alterar',
			)); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>
<script>
$('#Item_idTema').change(function(e){	
	e.preventDefault();
	var patt1=/\D/g;
	var id = $(this).val();
	var codigo = $("#Item_idTema option[value='"+id+"']").text().replace(patt1,'');
	$('#Item_codigo').parent().children('span').remove();
	$('#Item_codigo').parent().prepend('<span class="add-on">'+codigo+'.</span>');
});

</script>