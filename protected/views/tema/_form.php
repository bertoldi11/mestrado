<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tema-form',
	'enableAjaxValidation'=>false,
	'action'=> ($model->isNewRecord)? $this->createUrl('tema/novo') : $this->createUrl('tema/alterar', array('id'=>$model->idTema)),
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="clearfix">
	
		<?php 
			$categorias = CHtml::listData(Categoria::model()->findAll(), 'idCategoria', 'descricao');
			$categorias['']='Selecione';
			ksort($categorias);
			echo $form->dropDownListRow($model,'idCategoria', $categorias, array('class'=>'span2'));
		?>
	</div>
	<div class="clearfix">
		<div class="pull-left">
			<?php echo $form->textFieldRow($model,'codigo',array('class'=>'span1')); ?>
		</div>
		<div class="pull-left" style="margin-left: 15px;">
			<?php echo $form->textFieldRow($model,'descricao',array('class'=>'span3','maxlength'=>255)); ?>
		</div>
	</div>
	<div class="clearfix">
		<div class="pull-left">
			<?php echo $form->checkBoxRow($model,'multiplo', array('value'=>'S', 'uncheckValue'=>'N')); ?>
		</div>
		<div class="pull-left" style="margin-left: 15px;">
			<?php echo $form->checkBoxRow($model,'obrigatorio', array('value'=>'S', 'uncheckValue'=>'N')); ?>
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
