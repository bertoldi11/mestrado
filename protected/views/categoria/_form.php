<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'categoria-form',
	'enableAjaxValidation'=>false,
	'action'=> ($model->isNewRecord)? $this->createUrl('categoria/novo') : $this->createUrl('categoria/alterar', array('id'=>$model->idCategoria)),
)); ?>

<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

<?php echo $form->errorSummary($model); ?>
	<div class="clearfix">
		<div class="pull-left">
			<?php echo $form->textFieldRow($model,'descricao',array('class'=>'span5','maxlength'=>45)); ?>
		</div>
		<div class="pull-left" style="padding-top:28px; margin-left: 15px;">
			<?php echo $form->checkBoxRow($model,'repetir', array('value'=>'S', 'uncheckValue'=>'N')); ?>
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
