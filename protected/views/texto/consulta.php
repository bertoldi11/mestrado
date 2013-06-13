<?php $dadosQuestoes = $dataProviderQuestoes->getData();?>
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

<h1>Consulta de Textos</h1>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'consulta-form',
	'enableAjaxValidation'=>false,
	'action'=> $this->createUrl('texto/buscar')
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
		<p style="padding: 0;"><input id="checkTodosTexto" type="checkBox" name="todos" /> Todos os textos</p>
	</div>
	<hr>
	<div class="clearfix" style="width: 100%;">
		<div class="pull-left divConsulta borda">
			<fieldset>
				<?php 
					$itens = CHtml::listData(Item::model()->findAll(array('order'=>'idTema, idItem')), 'idItem', 
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
					$itens = CHtml::listData(Item::model()->findAll(array('order'=>'idTema, idItem')), 'idItem', 
						function($item) {
							return CHtml::encode($item->idTema0->codigo.".".$item->codigo." ".$item->descricao );
						},
						function($item){
							return CHtml::encode($item->idTema0->codigo." . ".$item->idTema0->descricao);
						}
					);
					echo $form->dropDownListRow($modelConsulta,'comboContem', $itens, array('class'=>'span2', 'prompt'=>'selecione'));
				?>
				<button class="btn btnPadding" id="btnAddContem"><span class="icon-plus-sign"></span></button>
			</fieldset>
			<table class="items table table-striped" width="90%">
				<thead>
					<tr>
						<th id="yw1_c0">Item</th>
						<th class="button-column" id="yw1_c3">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="tbodyContem">
					
				</tbody>
			</table>
		</div>
		<!--
			Subistituir por Fontes
			<div class="pull-left">
				<fieldset>
					<?php 
						$itens = CHtml::listData(Item::model()->findAll(array('order'=>'idTema, idItem')), 'idItem', 
							function($item) {
								return CHtml::encode($item->idTema0->codigo.".".$item->codigo." ".$item->descricao );
							},
							function($item){
								return CHtml::encode($item->idTema0->codigo." . ".$item->idTema0->descricao);
							}
						);
						echo $form->dropDownListRow($modelConsulta,'comboNaoContem', $itens, array('class'=>'span2', 'prompt'=>'selecione'));
					?>
					<button class="btn btnPadding" id="btnAddNaoContem"><span class="icon-plus-sign"></span></button>
				</fieldset>
				<table class="items table table-striped" width="90%">
					<thead>
						<tr>
							<th id="yw1_c0">Item</th>
							<th class="button-column" id="yw1_c3">&nbsp;</th>
						</tr>
					</thead>
					<tbody id="tbodyNaoContem">
						
					</tbody>
				</table>
			</div>
		-->
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
		$('#ConsultaForm_comboConjunto').attr('disabled',status);
		$('#btnAddConjunto').attr('disabled',status);
	});

	// Funções Não Contem
	jQuery(function(){
		$('#btnAddNaoContem').click(function(e){
			e.preventDefault();
			var item = $('#ConsultaForm_comboNaoContem').val();
			if(item > 0)
			{
				var texto = $('#ConsultaForm_comboNaoContem option[value="'+item+'"]').text();
				var linha=$('<tr>').append('<td>'+texto+'</td>').append('<td><a href="#" class="excluirNaoContem" id="temp_'+item+'"><i class="icon-trash"></i></a></td>');;
				$('#tbodyNaoContem').append(linha);
				
				$('#consulta-form').append('<input type="hidden" name="NaoContem[]" value="'+item+'" />');
				
			}
			else
			{
				alert('Selecione um Item');
				$('#ConsultaForm_comboNaoContem').focus();
			}
			
		});
		
		$('.excluirNaoContem').live('click',function(e){
			e.preventDefault();
			
			if(confirm('Deseja Excluir esse registro?'))
			{
				var id = $(this).attr('id');
			
				if(id.indexOf('temp_') >= 0)
				{
					id = id.replace('temp_', '');
					
					$('input[name="NaoContem[]"]').each(function(i,e){
						if($(this).val() == id){
							$(this).remove();
						}
					});
					$(this).parent().parent().remove();
				}
			}
		});
	});

	// Funções Contem
	jQuery(function(){
		$('#btnAddContem').click(function(e){
			e.preventDefault();
			var item = $('#ConsultaForm_comboContem').val();
			if(item > 0)
			{
				var texto = $('#ConsultaForm_comboContem option[value="'+item+'"]').text();
				var linha=$('<tr>').append('<td>'+texto+'</td>').append('<td><a href="#" class="excluirContem" id="temp_'+item+'"><i class="icon-trash"></i></a></td>');;
				$('#tbodyContem').append(linha);
				
				$('#consulta-form').append('<input type="hidden" name="Contem[]" value="'+item+'" />');
				
			}
			else
			{
				alert('Selecione um Item');
				$('#ConsultaForm_comboContem').focus();
			}
			
		});
		
		$('.excluirContem').live('click',function(e){
			e.preventDefault();
			
			if(confirm('Deseja Excluir esse registro?'))
			{
				var id = $(this).attr('id');
			
				if(id.indexOf('temp_') >= 0)
				{
					id = id.replace('temp_', '');
					
					$('input[name="Contem[]"]').each(function(i,e){
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
			var item = $('#ConsultaForm_comboConjunto').val();
			if(item > 0)
			{
				var texto = $('#ConsultaForm_comboConjunto option[value="'+item+'"]').text();
				var linha=$('<tr>').append('<td>'+texto+'</td>').append('<td><a href="#" class="excluirConjunto" id="temp_'+item+'"><i class="icon-trash"></i></a></td>');;
				$('#tbodyConjunto').append(linha);
				
				$('#consulta-form').append('<input type="hidden" name="Conjunto[]" value="'+item+'" />');
				
			}
			else
			{
				alert('Selecione um Item');
				$('#ConsultaForm_comboConjunto').focus();
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
