<?php if (_reg('section') !== 'carrito' and _reg('section') !== 'checkout' and _reg('section') !== 'pedido' and _reg('section') !== 'confirm'): ?>
<?php
if ($this->registry->cart()) {
  $display_cart_class = '';
} else {
  $display_cart_class = 'nodisplay';
}
?>
<div id="column2cart" class="section sales <?php echo $display_cart_class; ?>">
  <div class="header"><h4>CARRITO</h4></div>
  <div class="content">
  	<ul class="shoppingcart">
  	<?php if ($this->registry->cart()): ?>
  		<?php foreach($this->registry->cart('items') as $cart_item): ?>
  		<li id="<?php echo $cart_item['rowid']; ?>">
  		  <p class="product-name"><?php echo $cart_item['name']; ?></p>
  		  <a href="#" class="btn-sales btn-delete">borrar</a>
  		  <p><?php if ($cart_item['qty'] > 1) echo '(' . $cart_item['qty'] . ') '; ?><span class="product-price"><?php echo number_format($cart_item['price'] * $cart_item['qty'], 2, ',', '.'); ?></span><span class="product-currency"> €</span></p>
  		</li>
  		<?php endforeach; ?>
  	<?php endif; ?>
  	</ul>
  	<div class="cart-totals">
  		<p><span class="bold">Total</span> <span class="product-price"><?php echo number_format($this->registry->cart('total'), 2, ',', '.'); ?></span> <span class="product-currency">€</span></p>
  	</div>
  	<a href="<?php echo _reg('site_url') . 'tienda/carrito' ?>" class="btn-sales">Comprar</a>
  </div>
</div>
<?php endif; ?>