<?php
$this->breadcrumbs=array(
	'Textos'=>array('texto/index'),
	'Analisar'
);

?>
<h1>Análise do Texto: <?php echo $model->codigo;?></h1>

<?php $dadosQuestoes = $dataProviderQuestoes->getData();?>

<form id="formAnalise" action="/texto/salvarAnalise.html" method="post">
	<?php foreach($dadosQuestoes as $categoria):?>
		<h3><?php echo $categoria->descricao;?></h3>	
		
		<?php 
			foreach($categoria->temas as $tema)
			{
					if(count($tema->items) > 0)
					{
						echo "<p class='tema'>$tema->codigo - $tema->descricao</p>";
						foreach($tema->items as $item):?>
							<p class="item">
								<input type="checkbox" name="itensTexto[]" value="<?php echo $item->idItem;?>" title="Texto" <?php if(in_array($item->idItem, $itensTexto)) echo 'checked'; ?>/>
								<?php if($categoria->repetir == 'S'):?>
									<?php foreach($model->fontes as $fonte):?>
										<input type="checkbox" <?php if(in_array($item->idItem, $itensFontes[$fonte->idFonte])) echo 'checked';?> name="itensFonte[<?php echo $fonte->idFonte;?>][]" title="<?php echo $fonte->nome;?>" value="<?php echo $item->idItem;?>" />
									<?php endforeach;?>
								<?php endif;?>
								<span><?php echo $tema->codigo;?>.<?php echo $item->codigo;?> - <?php echo $item->descricao;?></span>
							</p>
						<?php endforeach;
					}
					else
					{
						echo "<p class='tema'>$tema->codigo - $tema->descricao <input type='text' name='valor' size='8' class='span2	' /></p>";
					}
			}
		?>
	<?php endforeach;?>
	
	<input type="hidden" name="idTexto" value="<?php echo $model->idTexto;?>" />
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); ?>
	</div>
</form>

