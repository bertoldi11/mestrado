<div class="clearfix">
		<div class="pull-left">	
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'texto-form',
			'enableAjaxValidation'=>false,
			'action'=> ($model->isNewRecord)? $this->createUrl('texto/novo') : $this->createUrl('texto/alterar', array('id'=>$model->idTexto)),
		)); ?>
	
			<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>	
		
			<?php echo $form->errorSummary($model); ?>
			<div class="clearfix">
				<div class="pull-left">
					<?php echo $form->textFieldRow($model,'codigo',array('class'=>'span3','maxlength'=>4)); ?>
				</div>
				<div class="pull-left" style="margin-left: 15px;">
					<?php echo $form->datepickerRow($model,'data',array('class'=>'span3', 'options'=>array(
						'defaultDate'=>'01/01/2007',
						'changeMonth'=> true,
						'changeYear'=> true
					))); ?>
				</div>
			</div>
			
			<?php echo $form->textFieldRow($model,'titulo',array('class'=>'span6','maxlength'=>255)); ?>
		</div>
		<div class="pull-left" style="margin-left:15px; padding-left: 15px; border-left: 1px solid #DDD;" >
			<h3>Fontes</h3>
			<div class="pull-left">
				<input type="text" class="span4" name="inputFonte" id="inputFonte" />
			</div>
			<div class="pull-left" style="padding-left: 5px;">
				<button class="btn" id="btnAddFonte"><span class="icon-plus-sign"></span></button>
			</div>
			<table class="items table table-striped">
				<thead>
					<tr>
						<th id="yw1_c0">Fonte</th>
						<th class="button-column" id="yw1_c3">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="tbodyFonte">
				<?php if($model->isNewRecord):?>
					<tr><td colspan="2" class="empty">Nenhuma fonte cadastrada</td></tr>
				<?php else:?>
					<?php foreach($model->fontes as $fonte):?>
						<tr>
							<td>
								<input type="hidden" name="Fonte_existe[<?php echo $fonte->idFonte;?>][]" value="<?php echo $fonte->nome;?>">
								<?php echo $fonte->nome;?>
							</td>
							<td>
								<a href="/fonte/excluir" class="excluirFonte" id="<?php echo $fonte->idFonte;?>"><i class="icon-trash"></i></a>
							</td>
						</tr>
					<?php endforeach;?>
				<?php endif;?>
				</tbody>
			</table>
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
</div>
<script>

	var idFonte = <?php echo (isset($fonte)) ? $fonte->idFonte : 0;?>;

	jQuery('#btnAddFonte').click(function(event){
		event.preventDefault();
		var fonte = $('#inputFonte').val();

		if(fonte != '')
		{
			if(idFonte === 0)
			{
				$('#tbodyFonte').empty();
			}
			//Monta Dados do Formulário
			$('#texto-form').append('<input type="hidden" name="Fonte['+idFonte+'][]" value="'+fonte+'">');
			
			//Monta Tabela de exibição.
			var linha = $('<tr>');
			$(linha).append('<td>'+fonte+'</td>');
			$(linha).append('<td><a href="#" class="excluirFonte" id="temp_'+idFonte+'"><i class="icon-trash"></i></a></td>');
			$('#tbodyFonte').append(linha);
			
			//Prepara variáveis para novo registro
			idFonte ++;
			$('#inputFonte').val('');
		}
		else
		{
			//TODO: Melhorar validação e exibição da mensagem
			alert('Informe a Fonte.');
		}
		
	});
	
	$(".excluirFonte").live('click', function(event){
		event.preventDefault();
		if(confirm('Deseja Excluir esse registro?'))
		{
			var id = $(this).attr('id');
			var link = $(this);
		
			/* O prefixo temp_ indica que o dado ainda não está salvo no BD */
			if(id.indexOf('temp_') >= 0)
			{
				id = id.replace('temp_', '');
				$('input[name="Fonte['+id+'][]"]').remove();			
				$(this).parent().parent().remove();
			}
			else
			{
				if(confirm('Excluir essa fonte, exclui também os dados cadastrados pra ela. Tem certeza que quer excluir?'))
				{//Fazer uma requisição ajax para excluir.
					$.ajax({
						url: $(this).attr('href'),
						dataType: 'json',
						type: 'post',
						data: {idFonte: id},
						
					}).done(function ( JSON ){
						if(JSON.MSG){
							alert(JSON.MSG);
						}
						
						$('input[name="Fonte['+id+'][]"]').remove();			
						$(link).parent().parent().remove();
					});
				}
			}
		}
		
	});

</script>