<style>
span.destaque{
	font-weight: bold;
	color: #666;
}
</style>
<h3>Totalização das Fontes do Texto</h3>
<?php $idTema = 0;?>
<?php foreach($totalItens as $item):?>	
	<?php if($item->idItem0->idTema!=$idTema){
		echo "<hr><h4>".$item->idItem0->idTema0->codigo." - ".$item->idItem0->idTema0->descricao."</h4>";
		$idTema = $item->idItem0->idTema;
	}?>
	
	<p><span class="destaque">(<?php echo $item->quant;?>)</span>  <?php echo $item->idItem0->idTema0->codigo?>.<?php echo $item->idItem0->codigo;?> - <?php echo $item->idItem0->descricao;?></p>
<?php endforeach;?>