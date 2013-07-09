<h1>Resultado da consulta</h1>

<div>
	<b><?php echo $resultado;?></b>
</div>
<div>
	<?php if(count($textosContem)>0):?>
		<h3>Textos Encontrados</h3>
		<?php foreach($textosContem as $texto):?>
		<div>
			<?php echo $texto->idTexto;?> - <?php echo $texto->titulo;?> 
		</div>
		<?php endforeach;?>	
	<?php endif;?>
</div>