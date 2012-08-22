<div class="section sales">
  <div class="header"><h4>PEDIDO TIENDA</h4></div>
  <?php // Check if there are items in the cart for this company shop ?>
  <?php if ($data['order_received']): ?>
  	<div class="content cartshop">
  		<h3>Pedido recibido</h3>
  		<p>Gracias por realizar su pedido en <?php echo $data['order']['company_name']; ?></p>
  		<p>Pedido con número de referencia <?php echo $data['order']['order_id']; ?> recibido el <?php echo $data['order']['date_added']; ?>.</p>
  		<p>Puede hacer un seguimiento del estado de su pedido en su panel de usuario.</p>
  	</div>
  <?php else: ?>
  	<div class="content cartshop">
  		<p class="header">Pedido no recibido</p>
  		<p>Se ha producido un error al procesar su pedido. Le rogamos vuelva a realizar su compra.</p>
  		<p>Disculpe las molestias.</p>
  	</div>
  <?php endif; ?>
</div><!-- .sales .section -->
<img src="http://placehold.it/468x60/ccc/fff&text=full+banner+(468x60)" alt="full banner (468x60px)" class="fullbanner" />