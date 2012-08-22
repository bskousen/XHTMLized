<div class="section sales">
  <div class="header"><h4>PEDIDO TIENDA</h4></div>
  <?php // Check if there are items in the cart for this company shop ?>
  <?php if ($data['company_cart']): ?>
  	<div class="content cartshop">
  		<p class="header">
  			<?php if ($data['company_cart']['logo']): ?>
  				<?php
  				// get the filename for the logo image:
  				// slice the filename in name and extension, add file size suffix at the en of the name and stick it again
  			  $filename = pathinfo($data['company_cart']['logo'], PATHINFO_FILENAME);
  			  $fileext = strtolower(pathinfo($data['company_cart']['logo'], PATHINFO_EXTENSION));
  			  $logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '_96x96.' . $fileext;
  			  ?>
  			  <img src="<?php echo $logo_path; ?>" />
  			<?php else: ?>
  			  <img src="<?php echo _reg('site_url') ?>usrs/nouser_96x96.jpg" />
  			<?php endif; ?>
  			<span>Productos de la tienda</span><a href=""><?php echo $data['company_cart']['name']; ?></a></p>
  		<ul class="shoppingcart">
  			<?php foreach ($data['company_cart']['products'] as $product): ?>
  			<li id="<?php echo $product['rowid']; ?>">
  				<?php
  				// get the proper image filename and url
  				if ($product['main_image']) {
  				  $image = _reg('site_url') . 'usrs/productos/' . $product['main_image'] . '_75x75.' . $product['main_ext'];
  				} else {
  				  $image = _reg('site_url') . 'usrs/nophoto_75x75.jpg';
  				}
  				?>
  				<img src="<?php echo $image; ?>" alt="<?php echo $product['name']; ?>" />
  				<p class="product-name"><?php echo $product['name']; ?></p>
  				<p><?php echo substr($product['description'], 0, 130); ?>…</p>
  				<p class="product-info">
  					<span class="quantity">Cantidad: <?php echo $product['qty']; ?></span>
  					<span class="fright">
  						<span class="product-price"><?php echo number_format($product['price'] * $product['qty'], 2, ',', '.'); ?></span>
  						<span class="product-currency"> €</span>
  					</span>
  				</p>
  			</li>
  			<?php endforeach; ?>
  		</ul>
  		<div class="cart-totals">
  			<p><span class="bold">Total</span> <span class="product-price"><?php echo number_format($this->registry->cart('total'), 2, ',', '.'); ?></span> <span class="product-currency">€</span></p>
  		</div>
  	</div><!-- .content .cartshop -->
  	<?php // Check if the are any user logged ?>
  	<?php if ($this->registry->user()): ?>
  	<div class="content cartshop" style="text-align:right;">
			<a href="<?php echo _reg('site_url'); ?>" class="btn-sales">Cancelar</a>
			<a href="#" onclick="document.getElementById('orderform').submit();" class="btn-sales">Confirmar</a>
		</div>
  	<div class="content cartshop">
  		<h6>Datos del pedido</h6>
  		<table style="width:100%;">
  			<thead>
  				<tr>
  					<td class="column-fields"></td>
  					<td class="column-shipping">Envío</td>
  					<td class="column-payment">Facturación</td>
  				</tr>
  			</thead>
  			<tfoot>
  				<tr>
  					<td class="column-fields"></td>
  					<td class="column-shipping"></td>
  					<td class="column-payment"></td>
  				</tr>
  			</tfoot>
  			<tbody>
  				<tr>
  					<td class="column-fields">N.I.F.</td>
  					<td class="column-shipping"></td>
  					<td class="column-payment"><?php echo $data['order_data']['payment_nif']; ?></td>
  				</tr>
  				<tr>
  					<td class="column-fields">Nombre</td>
  					<td class="column-shipping"><?php echo $data['order_data']['shipping_name']; ?></td>
  					<td class="column-payment"><?php echo $data['order_data']['payment_name']; ?></td>
  				</tr>
  				<tr>
  					<td class="column-fields">Apellidos</td>
  					<td class="column-shipping"><?php echo $data['order_data']['shipping_surname']; ?></td>
  					<td class="column-payment"><?php echo $data['order_data']['payment_surname']; ?></td>
  				</tr>
  				<tr>
  					<td class="column-fields">Dirección</td>
  					<td class="column-shipping"><?php echo $data['order_data']['shipping_address']; ?></td>
  					<td class="column-payment"><?php echo $data['order_data']['payment_address']; ?></td>
  				</tr>
  				<tr>
  					<td class="column-fields">Código Postal</td>
  					<td class="column-shipping"><?php echo $data['order_data']['shipping_zipcode']; ?></td>
  					<td class="column-payment"><?php echo $data['order_data']['payment_zipcode']; ?></td>
  				</tr>
  				<tr>
  					<td class="column-fields">Ciudad</td>
  					<td class="column-shipping"><?php echo $data['order_data']['shipping_city']; ?></td>
  					<td class="column-payment"><?php echo $data['order_data']['payment_city']; ?></td>
  				</tr>
  				<tr>
  					<td class="column-fields">Provincia</td>
  					<td class="column-shipping"><?php echo $data['order_data']['shipping_state']; ?></td>
  					<td class="column-payment"><?php echo $data['order_data']['payment_state']; ?></td>
  				</tr>
  				<tr>
  					<td class="column-fields">Pais</td>
  					<td class="column-shipping"><?php echo $data['order_data']['shipping_country']; ?></td>
  					<td class="column-payment"><?php echo $data['order_data']['payment_country']; ?></td>
  				</tr>
  				<tr>
  					<td class="column-fields">Teléfono</td>
  					<td class="column-shipping"><?php echo $data['order_data']['shipping_phone']; ?></td>
  					<td class="column-payment"></td>
  				</tr>
  			</tbody>
  		</table>
  	</div>
  	<div class="content cartshop">
  		<h6>Método de envío</h6>
  		<?php if ($data['order_data']['shipping_method']): ?>
  			<?php $shipping_id = $data['order_data']['shipping_method']; ?>
  			<?php echo $data['shipping'][$shipping_id]['name']; ?>
  		<?php else: ?>
  			<p>Nos pondremos en contacto con usted para indicarle el método de envío.</p>
  		<?php endif; ?>
  	</div>
  	<div class="content cartshop">
  		<h6>Forma de pago</h6>
  		<?php if ($data['order_data']['payment_gateway']): ?>
  			<?php
  			$payment_id = $data['order_data']['payment_gateway'];
  			echo $data['payment'][$payment_id]['name'];
  			?>
  		<?php else: ?>
  			<p>Nos pondremos en contacto con usted para indicarle la forma de pago.</p>
  		<?php endif; ?>
  	</div>
  	
  	<form action="<?php _e('module_url'); ?>confirm" method="post" id="orderform" class="salesform">
  		<?php foreach ($data['company_cart']['products'] as $product): ?>
  		<input type="hidden" name="products_id[]" value="<?php echo $product['product_ID'] ?>" />
  		<input type="hidden" name="products_name[]" value="<?php echo $product['name'] ?>" />
  		<input type="hidden" name="products_model[]" value="<?php echo $product['model'] ?>" />
  		<input type="hidden" name="products_price[]" value="<?php echo $product['price'] ?>" />
  		<input type="hidden" name="products_quantity[]" value="<?php echo $product['qty'] ?>" />
  		<?php endforeach; ?>
  		<?php foreach ($data['order_data'] as $key => $value): ?>
  		<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
  		<?php endforeach; ?>
  		<input type="hidden" name="shipment_address_ID" value="0" />
  		<input type="hidden" name="payment_address_ID" value="0" />
  	</form>
  	
  	<div class="content cartshop" style="text-align:right;">
			<a href="<?php echo _reg('site_url'); ?>" class="btn-sales">Cancelar</a>
			<a href="#" onclick="document.getElementById('orderform').submit();" class="btn-sales">Confirmar</a>
		</div>
  	
  	
		<?php else: // !$user_data ?>
		<div class="content">
		  <p>Debe estar registrado para continuar con la compra. <a href="<?php echo _reg('site_url'); ?>/entrar" class="btn-sales">entrar</a> <a href="<?php echo _reg('site_url') ?>/registrarse" class="btn-sales">registrarse…</a></p>
		</div>
		<?php endif; // end ($user_data) ?>
	<?php else: // !$data['company_cart'] ?>
  	<div class="content cartshop">
  		<p>No tiene productos de esta tienda en su carrito de la compra.</p>
  		<p><a href="<?php _e('module_url'); ?>">Visita nuestra tienda online</a> para ver nuestros productos y ofertas.</p>
  	</div><!-- .content -->
  <?php endif; // end ($data['company_cart']) ?>
</div><!-- .sales .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>