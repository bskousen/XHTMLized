<div class="section basicads">
  <div class="header"><h4>CLASIFICADOS</h4></div>
  <p>¿Que desea hacer con el anuncio <a href="../<?php echo ($data["basicad"]["slug"]) ?>"><?php echo ($data["basicad"]["title"]) ?></a> ?</p>
  <div class="content">
  	<div class="basicad">
    	<form action="../updateMail/<?php echo $data["basicad"]["basicad_ID"] ?>" method="post" accept-charset="utf-8">
	        <input type="radio" name="time" value="moredays"> Actualizar el anuncio 
	        <input type="radio" name="time" value="delete"> Borrar el anuncio 
	        <input type="submit" value="actualizar">
		</form>
  	</div><!-- .basicad -->
  </div><!-- .content -->
</div>  
  
  