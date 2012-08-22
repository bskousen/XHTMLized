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
  				<a href="#" name="<?php echo $product['rowid']; ?>" class="btn-sales btn-delete">borrar</a>
  				<a href="#" class="btn-sales btn-addqty">+</a>
  				<input class="quantity" name="quantity" maxlength="2" ovalue="<?php echo $product['qty'] ?>" value="<?php echo $product['qty'] ?>" />
  				<a href="#" class="btn-sales btn-subqty">–</a>
  				<p class="product-info"><span class="product-price"><?php echo number_format($product['price'] * $product['qty'], 2, ',', '.'); ?></span><span class="product-currency"> €</span></p>
  			</li>
  			<?php endforeach; ?>
  		</ul>
  		<div class="cart-totals">
  			<p><span class="bold">Total</span> <span class="product-price"><?php echo number_format($this->registry->cart('total'), 2, ',', '.'); ?></span> <span class="product-currency">€</span></p>
  		</div>
  	</div><!-- .content .cartshop -->
  	<?php // Check if the are any user logged ?>
  	<?php if ($this->registry->user()): ?>
  	<?php echo validation_errors(); ?>
  	<div class="content cartshop" style="text-align:right;">
			<a href="#" onclick="document.getElementById('orderform').submit();" class="btn-sales">Enviar pedido</a>
		</div>
  	<form action="<?php _e('module_url'); ?>pedido" method="post" id="orderform" class="salesform">
			<fieldset>
			  <h6>Datos de envío</h6>
			  <p style="margin:12px 0;">Puede modificar estos datos si no son los mismos de su usuario.</p>
			  <label for="shipping_name">Nombre</label><input type="text" name="shipping_name" id="shipping_name" value="<?php echo set_value('shipping_name', $this->registry->user('name')); ?>" />
			  <label for="shipping_surname">Apellidos</label><input type="text" name="shipping_surname" id="shipping_surname" value="<?php echo set_value('shipping_surname', $this->registry->user('surname')); ?>" />
			  <label for="shipping_address">Dirección</label><input type="text" name="shipping_address" id="shipping_address" value="<?php echo set_value('shipping_address', $this->registry->user('address')); ?>" />
			  <label for="shipping_zipcode">Código Postal</label><input type="text" name="shipping_zipcode" id="shipping_zipcode" value="<?php echo set_value('shipping_zipcode', $this->registry->user('zipcode')); ?>" />
			  <label for="shipping_city">Ciudad</label><input type="text" name="shipping_city" id="shipping_city" value="<?php echo set_value('shipping_city', $this->registry->user('city')); ?>" />
			  <label for="shipping_state">Provincia</label><input type="text" name="shipping_state" id="shipping_state" value="<?php echo set_value('shipping_state', $this->registry->user('state')); ?>" />
			  <label for="shipping_country">Pais</label><input type="text" name="shipping_country" id="shipping_country" value="<?php echo set_value('shipping_country', $this->registry->user('country')); ?>" />
			  <label for="shipping_phone">Teléfono</label><input type="text" name="shipping_phone" id="shipping_phone" value="<?php echo set_value('shipping_phone', $this->registry->user('phone')); ?>" />
			  <input type="hidden" name="shipment_address_ID" value="0" />
			</fieldset>
			<fieldset>
			  <h6>Datos de facturación</h6>
			  <p style="margin:12px 0;">Puede modificar estos datos si no son los mismos de su usuario.</p>
			  <label for="payment_nif">N.I.F.</label><input type="text" name="payment_nif" id="payment_nif" value="<?php echo set_value('payment_nif', $this->registry->user('nif')); ?>" />
			  <label for="payment_name">Nombre</label><input type="text" name="payment_name" id="payment_name" value="<?php echo set_value('payment_name', $this->registry->user('name')); ?>" />
			  <label for="payment_surname">Apellidos</label><input type="text" name="payment_surname" id="payment_surname" value="<?php echo set_value('payment_surname', $this->registry->user('surname')); ?>" />
			  <label for="payment_address">Dirección</label><input type="text" name="payment_address" id="payment_address" value="<?php echo set_value('payment_address', $this->registry->user('address')); ?>" />
			  <label for="payment_zipcode">Código Postal</label><input type="text" name="payment_zipcode" id="payment_zipcode" value="<?php echo set_value('payment_zipcode', $this->registry->user('zipcode')); ?>" />
			  <label for="payment_city">Ciudad</label><input type="text" name="payment_city" id="payment_city" value="<?php echo set_value('payment_city', $this->registry->user('city')); ?>" />
			  <label for="payment_state">Provincia</label><input type="text" name="payment_state" id="payment_state" value="<?php echo set_value('payment_state', $this->registry->user('state')); ?>" />
			  <label for="payment_country">Pais</label><input type="text" name="payment_country" id="payment_country" value="<?php echo set_value('payment_country', $this->registry->user('country')); ?>" />
			  <input type="hidden" name="payment_address_ID" value="0" />
			</fieldset>
			<?php // Check if there are shipping methods ?>
			<?php if ($data['shipping']): ?>
			<fieldset>
			  <h6>Método de envío</h6>
			  <ul>
			  <?php foreach ($data['shipping'] as $shipping_method): ?>
			  	<li><input type="radio" name="shipping_method" value="<?php echo $shipping_method['shipping_method_ID']; ?>" /> <?php echo $shipping_method['name']; ?></li>
			  <?php endforeach; ?>
			  </ul>
			</fieldset>
			<?php else: // !$data['shipping'] ?>
			<div class="content">
			  <h6>Método de envío</h6>
			  <p class="message">Esta empresa no tiene indicado ningún método de envío. Envíe su pedido y se pondrá en contacto con usted para indicarle el procedimiento para el envío del pedido.</p>
			  <input type="hidden" name="shipping_method" value="0" />
			</div>
			<?php endif; // end ($data['shipping'])  ?>
			<?php // Check if there are payment gateways ?>
			<?php if ($data['payment']): ?>
			<fieldset>
			  <h6>Forma de pago</h6>
			  <ul>
			  <?php foreach ($data['payment'] as $payment_gateway): ?>
			  	<li>
			  		<?php $pgid = $payment_gateway['payment_gateway_ID']; ?>
			  		<input type="radio" name="payment_gateway" value="<?php echo $pgid; ?>" <?php echo set_radio('payment', $pgid); ?> />
			  		<?php echo $payment_gateway['name']; ?>
			  	</li>
			  <?php endforeach; ?>
			  </ul>
			</fieldset>
			<?php else: // !$data['payment'] ?>
			<div class="content">
			  <h6>Forma de pago</h6>
			  <p class="message">Esta empresa no tiene indicado ninguna forma de pago. Envíe su pedido y se pondrá en contacto con usted para indicarle el procedimiento para el pago del pedido.</p>
			  <input type="hidden" name="payment_gateway" value="0" />
			</div>
			<?php endif; // end ($data['payment']) ?>
			<input type="hidden" name="cid" value="<?php echo $data['company_cart']['company_ID']; ?>" />
		</form>
		<div class="content cartshop" style="text-align:right;">
			<a href="#" onclick="document.getElementById('orderform').submit();" class="btn-sales">Enviar pedido</a>
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
<script>
$(function () {
  $(document).on('click', '.shoppingcart > li > .btn-addqty', function (event) {
  	event.preventDefault();
  	var item_li = $(this).parent();
  	var rowid = $(this).parent().attr('id');
  	
  	$.ajax({
  	  url: '<?php echo _reg('site_url'); ?>cart/addqty',
  	  data: {rid: rowid},
  	  type: 'post',
  	  success: function(data, textStatus, jqXHR){
  	  	if (data.rowid) {
  	  		item_li.children('.quantity').attr('value', data.rowinfo.qty);
  	  		item_li.find('.product-price').text(data.rowinfo.price);
  	  		cart_total = parseFloat(data.rowinfo.cart_total);
  	  		cart_n_items = cart_n_items + 1;
        	$('.cart-totals > p > .product-price').text(data.rowinfo.cart_total);
        } else {
        	alert(data.message);
        }
  	  }
  	});
  });
  
  $(document).on('click', '.shoppingcart > li > .btn-subqty', function (event) {
  	event.preventDefault();
  	var item_li = $(this).parent();
  	var rowid = $(this).parent().attr('id');
  	
  	$.ajax({
  	  url: '<?php echo _reg('site_url'); ?>cart/subqty',
  	  data: {rid: rowid},
  	  type: 'post',
  	  success: function(data, textStatus, jqXHR){
  	  	if (data.rowid) {
  	  		if (data.rowinfo) {
  	  			item_li.children('.quantity').attr('value', data.rowinfo.qty);
  	  			item_li.find('.product-price').text(data.rowinfo.price);
  	  			cart_total = parseFloat(data.rowinfo.cart_total);
  	  			$('.cart-totals > p > .product-price').text(data.rowinfo.cart_total);
  	  		} else {
  	  			item_li.remove();
  	  		}
  	  		cart_n_items = cart_n_items - 1;
  	  	} else {
  	  		alert(data.message);
  	  	}
  	  	
  	  	if (cart_n_items == 0) {
  	  		window.location.replace('<?php echo _reg('site_url'); ?>');
  	  	}
  	  }
  	});
  });
  
  $('.shoppingcart > li > .quantity').blur( function () {
  	//console.log(this);
  	//console.log($(this).val());
  	
  	var item_li = $(this).parent();
  	var rowid = $(this).parent().attr('id');
  	var old_qty = $(this).attr('ovalue');
  	var qty = $(this).val();
  	
  	//console.log(item_li);
  	//console.log(qty);
  	//console.log($(this).data('old_value'));
  	if (qty == 0) {
  		$(this).val(old_qty);
  		alert('La cantidad no puede ser 0. Si quere borrar el producto pulse el botón borrar.');
  	} else if (qty != old_qty) {
  		$.ajax({
  		  url: '<?php echo _reg('site_url'); ?>cart/setqty',
  		  data: {rid: rowid, qty: qty, old_qty: old_qty},
  		  type: 'post',
  		  success: function(data, textStatus, jqXHR){
  		  	console.log(data);
  		  	if (data.rowid) {
  		  		item_li.find('.product-price').text(data.rowinfo.price);
  		  		cart_total = parseFloat(data.rowinfo.cart_total);
  		  		$('.cart-totals > p > .product-price').text(data.rowinfo.cart_total);
  		  		cart_n_items = cart_n_items + parseInt(data.rowinfo.difference);
  		  	} else {
  		  		alert(data.message);
  		  	}
  		  	
  		  	if (cart_n_items == 0) {
  		  		window.location.replace('<?php echo _reg('site_url'); ?>');
  		  	}
  		  }
  		});
  	}
  });
});
</script>