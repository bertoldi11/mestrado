<style>
	.divConsulta{
		margin-right: 10px;
	}
	
	div.borda{
		width: 30%;
		border-left: 1px solid #cccccc;
		padding-left: 10px;
	}
	.btnPadding{
		margin-bottom: 10px;
	}
	fieldset{
		
	}
</style>

<h1>Consulta de Fontes</h1>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'consulta-form',
	'enableAjaxValidation'=>false,
	'action'=> $this->createUrl('texto/buscarfontes')
)); ?>
	<div class="clearfix">
		<div class="pull-left divConsulta">
			<label>Início</label>
			<input type="text" name="dataInicio" class="span2" />
		</div>
		<div class="pull-left divConsulta">
			<label>Fim</label>
			<input type="text" name="dataFim"class="span2" />
		</div>
	</div>
	<div style="clearfix">
		<p style="padding: 0;"><input id="checkTodosTexto" type="checkBox" name="todos" /> Todos as fontes.</p>
	</div>
	<hr>
	<div class="clearfix" style="width: 100%;">
		<div class="pull-left divConsulta borda">
			<fieldset>
				<?php    //TODO: modificar código para que possa ser indicado o id da categoria.
					$itens = CHtml::listData(Item::model()->findAll(array('order'=>'idTema, idItem','condition'=>'idTema between 15 and 24')), 'idItem', 
						function($item) {
							return CHtml::encode($item->idTema0->codigo.".".$item->codigo." ".$item->descricao );
						},
						function($item){
							return CHtml::encode($item->idTema0->codigo.". ".$item->idTema0->descricao);
						}
					);
					echo $form->dropDownListRow($modelConsulta,'comboConjunto', $itens, array('class'=>'span2', 'prompt'=>'selecione'));
				?>
				<button class="btn btnPadding" id="btnAddConjunto"><span class="icon-plus-sign"></span></button>
				
			</fieldset>
			
			<table class="items table table-striped" width="90%">
				<thead>
					<tr>
						<th id="yw1_c0">Item</th>
						<th class="button-column" id="yw1_c3">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="tbodyConjunto">
					
				</tbody>
			</table>
		</div>
		<div class="pull-left divConsulta borda">
			<fieldset>
				<?php 
					$itens = CHtml::listData(Item::model()->findAll(array('order'=>'idTema, idItem','condition'=>'(idTema between 5 and 14) or idTema=25')), 'idItem', 
						function($item) {
							return CHtml::encode($item->idTema0->codigo.".".$item->codigo." ".$item->descricao );
						},
						function($item){
							return CHtml::encode($item->idTema0->codigo." . ".$item->idTema0->descricao);
						}
					);
					echo $form->dropDownListRow($modelConsulta,'comboFonte', $itens, array('class'=>'span2', 'prompt'=>'selecione'));
				?>
				<button class="btn btnPadding" id="btnAddFonte"><span class="icon-plus-sign"></span></button>
			</fieldset>
			<table class="items table table-striped" width="90%">
				<thead>
					<tr>
						<th id="yw1_c0">Item</th>
						<th class="button-column" id="yw1_c3">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="tbodyFonte">
					
				</tbody>
			</table>
		</div>
	</div>
	<div class="clearfix">
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Buscar',
			)); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<script>

	//Validação do checkbox todos os textos. Ser marcado, desabilita o combo	
	$('#checkTodosTexto').click(function(){
		var status = $(this).attr('checked')=='checked'?true:false;
		$('#ConsultaFonteForm_comboConjunto').attr('disabled',status);
		$('#btnAddConjunto').attr('disabled',status);
	});

	// Funções Fonte
	jQuery(function(){
		$('#btnAddFonte').click(function(e){
			e.preventDefault();
			var item = $('#ConsultaFonteForm_comboFonte').val();
			if(item > 0)
			{
				var texto = $('#ConsultaFonteForm_comboFonte option[value="'+item+'"]').text();
				var linha=$('<tr>').append('<td>'+texto+'</td>').append('<td><a href="#" class="excluirFonte" id="temp_'+item+'"><i class="icon-trash"></i></a></td>');;
				$('#tbodyFonte').append(linha);
				
				$('#consulta-form').append('<input type="hidden" name="Fonte[]" value="'+item+'" />');
				
			}
			else
			{
				alert('Selecione um Item');
				$('#ConsultaFonteForm_comboFonte').focus();
			}
			
		});
		
		$('.excluirFonte').live('click',function(e){
			e.preventDefault();
			
			if(confirm('Deseja Excluir esse registro?'))
			{
				var id = $(this).attr('id');
			
				if(id.indexOf('temp_') >= 0)
				{
					id = id.replace('temp_', '');
					
					$('input[name="Fonte[]"]').each(function(i,e){
						if($(this).val() == id){
							$(this).remove();
						}
					});
					$(this).parent().parent().remove();
				}
			}
		});
	});


	// Funções Conjunto
	jQuery(function(){
		$('#btnAddConjunto').click(function(e){
			e.preventDefault();
			var item = $('#ConsultaFonteForm_comboConjunto').val();
			if(item > 0)
			{
				var texto = $('#ConsultaFonteForm_comboConjunto option[value="'+item+'"]').text();
				var linha=$('<tr>').append('<td>'+texto+'</td>').append('<td><a href="#" class="excluirConjunto" id="temp_'+item+'"><i class="icon-trash"></i></a></td>');;
				$('#tbodyConjunto').append(linha);
				
				$('#consulta-form').append('<input type="hidden" name="Conjunto[]" value="'+item+'" />');
				
			}
			else
			{
				alert('Selecione um Item');
				$('#ConsultaFonteForm_comboConjunto').focus();
			}
			
		});
		
		$('.excluirConjunto').live('click',function(e){
			e.preventDefault();
			
			if(confirm('Deseja Excluir esse registro?'))
			{
				var id = $(this).attr('id');
			
				if(id.indexOf('temp_') >= 0)
				{
					id = id.replace('temp_', '');
					
					$('input[name="Conjunto[]"]').each(function(i,e){
						if($(this).val() == id){
							$(this).remove();
						}
					});
					$(this).parent().parent().remove();
				}
			}
		});
	});
	
	
</script>
