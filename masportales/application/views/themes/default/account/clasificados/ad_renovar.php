<div class="section basicads">
  <div class="header"><h4>CLASIFICADOS</h4></div>
  <div class="content">
    <div class="basicad">
      <?php if ($data["basicad"]): ?>
      <?php foreach ($data["basicad"] as $basicad) : ?>
    <p>¿Que desea hacer con el anuncio <a href="../../../../clasificados/<?php echo ($basicad["slug"]) ?>"><?php echo($basicad["title"]); ?></a> ?</p>
     <form action="/micuenta/clasificados/ad/renovar/<?php echo $basicad["basicad_ID"] ?>" method="post" accept-charset="utf-8">
	        <input type="radio" name="time" value="moredays"> Actualizar el anuncio 
	        <input type="radio" name="time" value="delete"> Borrar el anuncio 
	        <input type="submit" value="actualizar">
		</form>
    <?php endforeach; ?>
  <?php else: ?>
  <p>No tiene ningún anuncio.</p>
<?php endif; ?>
  	</div><!-- .basicad -->
  </div><!-- .content -->
</div>  
  
  