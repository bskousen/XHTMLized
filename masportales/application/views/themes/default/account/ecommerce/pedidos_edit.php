<div id="uecommerce" class="section user">
  <div class="header"><h4>Mi Tienda</h4></div>
  <div class="content uecommerce orders-list">
  	<div class="fright">
  	  <p class="order-total"><span>Total</span><br /> <span class="product-price"><?php echo number_format($data['order']['order_total'], 2, ',', '.'); ?></span> <span class="product-currency">€</span></p>
  	</div>
  	<p class="order-title"><span>Pedido de</span><a href="<?php echo _reg('site_url'); ?>micuenta/ecommerce/pedidos/edit/<?php echo $data['order']['order_ID']; ?>"><?php echo $data['order']['customer_name']; ?></a></p>
  	<p class="order-date">Número de pedido: <span><?php echo $data['order']['order_ID']; ?></span></p>
  	<p class="order-date">Recibido el <span><?php echo fecha($data['order']['date_added'], 'medium'); ?></span></p>
  	<p class="order-status"><span><?php echo $data['order']['order_status']; ?></span></p>
  </div><!-- .content .uecommerce .orders-list -->
  <div class="content uecommerce order">
  	<h6>Productos</h6>
  	<table>
  		<thead>
  			<tr>
  				<td class="column-title">Concepto</td>
  				<td class="column-price">Precio</td>
  				<td class="column-qty">Cantidad</td>
  				<td class="column-price">Total</td>
  			</tr>
  		</thead>
  		<tbody>
  		<?php foreach ($data['order_products'] as $product): ?>
  			<tr>
  				<td class="column-title"><?php echo $product['name']; ?></td>
  				<td class="column-price"><?php echo number_format($product['price'], 2, ',', '.'); ?></td>
  				<td class="column-qty"><?php echo $product['quantity']; ?></td>
  				<td class="column-price"><?php echo number_format($product['total'], 2, ',', '.'); ?></td>
  			</tr>
  		<?php endforeach; ?>
  		<?php if ($data['order']['order_subtotal']): ?>	
  			<tr style="border:none;">
  				<td colspan="3" class="column-resume">Subtotal</td>
  				<td class="column-price"><?php echo number_format($data['order']['order_subtotal'], 2, ',', '.'); ?> €</td>
  			</tr>
  		<?php endif; ?>
  		<?php if ($data['order']['order_shipping']): ?>	
  			<tr style="border:none;">
  				<td colspan="3" class="column-resume">Envío</td>
  				<td class="column-price"><?php echo number_format($data['order']['order_shipping'], 2, ',', '.'); ?> €</td>
  			</tr>
  		<?php endif; ?>
  		<?php if ($data['order']['order_tax']): ?>	
  			<tr style="border:none;">
  				<td colspan="3" class="column-resume">Impuestos</td>
  				<td class="column-price"><?php echo number_format($data['order']['order_tax'], 2, ',', '.'); ?> €</td>
  			</tr>
  		<?php endif; ?>	
  			<tr style="border:none;">
  				<td colspan="3" class="column-resume">Total</td>
  				<td class="column-price"><?php echo number_format($data['order']['order_total'], 2, ',', '.'); ?> €</td>
  			</tr>
  		</tbody>
  	</table>
  </div><!-- .content .uecommerce .order -->
  <div class="content cartshop">
  	<h6>Dirección de envío y facturación</h6>
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
  	  		<td class="column-payment"><?php echo $data['order_address']['payment_address']['nif']; ?></td>
  	  	</tr>
  	  	<tr>
  	  		<td class="column-fields">Nombre</td>
  	  		<td class="column-shipping"><?php echo $data['order_address']['shipping_address']['firstname']; ?></td>
  	  		<td class="column-payment"><?php echo $data['order_address']['payment_address']['firstname']; ?></td>
  	  	</tr>
  	  	<tr>
  	  		<td class="column-fields">Apellidos</td>
  	  		<td class="column-shipping"><?php echo $data['order_address']['shipping_address']['lastname']; ?></td>
  	  		<td class="column-payment"><?php echo $data['order_address']['payment_address']['lastname']; ?></td>
  	  	</tr>
  	  	<tr>
  	  		<td class="column-fields">Dirección</td>
  	  		<td class="column-shipping"><?php echo $data['order_address']['shipping_address']['address']; ?></td>
  	  		<td class="column-payment"><?php echo $data['order_address']['payment_address']['address']; ?></td>
  	  	</tr>
  	  	<tr>
  	  		<td class="column-fields">Código Postal</td>
  	  		<td class="column-shipping"><?php echo $data['order_address']['shipping_address']['zipcode']; ?></td>
  	  		<td class="column-payment"><?php echo $data['order_address']['payment_address']['zipcode']; ?></td>
  	  	</tr>
  	  	<tr>
  	  		<td class="column-fields">Ciudad</td>
  	  		<td class="column-shipping"><?php echo $data['order_address']['shipping_address']['city']; ?></td>
  	  		<td class="column-payment"><?php echo $data['order_address']['payment_address']['city']; ?></td>
  	  	</tr>
  	  	<tr>
  	  		<td class="column-fields">Provincia</td>
  	  		<td class="column-shipping"><?php echo $data['order_address']['shipping_address']['state']; ?></td>
  	  		<td class="column-payment"><?php echo $data['order_address']['payment_address']['state']; ?></td>
  	  	</tr>
  	  	<tr>
  	  		<td class="column-fields">Pais</td>
  	  		<td class="column-shipping"><?php echo $data['order_address']['shipping_address']['country']; ?></td>
  	  		<td class="column-payment"><?php echo $data['order_address']['payment_address']['country']; ?></td>
  	  	</tr>
  	  	<tr>
  	  		<td class="column-fields">Teléfono</td>
  	  		<td class="column-shipping"><?php echo $data['order_address']['shipping_address']['phone']; ?></td>
  	  		<td class="column-payment"></td>
  	  	</tr>
  	  </tbody>
  	</table>
  </div><!-- .content -->
</div><!-- #uecommerce .section .user -->