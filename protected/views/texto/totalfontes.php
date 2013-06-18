<h3>Totalização das Fontes do Texto</h3>
<?php $idTema = 0;?>
<?php foreach($totalItens as $item):?>	
	<?php if($item->idItem0->idTema!=$idTema){
		echo "<hr>";
		$idTema = $item->idItem0->idTema;
	}?>
	
	<p><?php echo $item->quant;?> - <?php echo $item->idItem0->descricao;?></p>
<?php endforeach;?>