<div id="uecommerce" class="section user">
  <div class="header"><h4>Mi Tienda</h4></div>
  <div class="content uecommerce">
  	<h6>Bienvenido a su tienda online en +Portales</h6>
  	<p>Desde aquí podrá gestionar los pedidos de su tienda.</p>
  	<div class="buttons-top"></div>
  	<div class="orders-list">
  		<h6>Listado de pedidos</h6>
  		<?php if ($data): ?>
  			<ul>
  			<?php foreach ($data as $pedido): ?>
  				<li>
  					<div class="fright">
  						<p class="order-total"><span>Total</span><br /> <span class="product-price"><?php echo number_format($pedido['order_total'], 2, ',', '.'); ?></span> <span class="product-currency">€</span></p>
  						<p class="order-status"><span><?php echo $pedido['order_status']; ?></span></p>
  					</div>
  					<p class="order-title"><span>Pedido de</span><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/pedidos/edit/<?php echo $pedido['order_ID']; ?>"><?php echo $pedido['customer_name']; ?></a></p>
  					<p class="order-date">Recibido el <span><?php echo fecha($pedido['date_added'], 'medium'); ?></span></p>
  					<div class="buttons">
  						<a href="<?php _e('account_url'); ?>ecommerce/pedidos/edit/<?php echo $pedido['order_ID']; ?>" class="btn">Ver pedido</a>
  						<a href="<?php _e('account_url'); ?>ecommerce/pedidos/delete/<?php echo $pedido['order_ID']; ?>" class="btn">Borrar</a>
  					</div>
  				</li>
  			<?php endforeach; ?>
  			</ul>
  		<?php else: ?>
  			<p>No tiene aun ningún pedido en su tienda online.</p>
  		<?php endif; ?>
  	</div>
  	<div class="buttons-bottom"></div>
  </div><!-- .content -->
</div><!-- #uecommerce .section .user -->