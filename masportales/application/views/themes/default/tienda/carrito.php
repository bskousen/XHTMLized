<div class="section sales">
  <div class="header_individual"><h4>CESTA DE COMPRA GENERAL</h4></div>
  <?php if ($data['cart_products_by_company']): ?>
  	<?php foreach ($data['cart_products_by_company'] as $company): ?>
  	<div class="content cartshop">
  		<p class="header">
  			<?php if ($company['logo']): ?>
  				<?php
  				// get the filename for the logo image:
  				// slice the filename in name and extension, add file size suffix at the en of the name and stick it again
  			  $filename = pathinfo($company['logo'], PATHINFO_FILENAME);
  			  $fileext = strtolower(pathinfo($company['logo'], PATHINFO_EXTENSION));
  			  $logo_path = _reg('site_url') . 'usrs/empresas/' . $filename . '_96x96.' . $fileext;
  			  ?>
  			  <img src="<?php echo $logo_path; ?>" />
  			<?php else: ?>
  			  <img src="<?php echo _reg('site_url') ?>usrs/nouser_96x96.jpg" />
  			<?php endif; ?>
  			<span>Productos de la tienda:</span><a href=""><?php echo $company['name']; ?></a></p>
  		<ul class="shoppingcart">
  			<?php foreach ($company['products'] as $product): ?>
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
  		<form action="<?php _e('module_url'); ?>checkout" method="post" id="cartform-<?php echo $company['company_ID']; ?>">
  			<input type="hidden" name="cid" readonly="readonly" value="<?php echo $company['company_ID']; ?>" />
  		</form>
  		<a href="#" onclick="document.getElementById('cartform-<?php echo $company['company_ID']; ?>').submit();" class="btn-sales">Comprar los productos de esta tienda</a>
  	</div><!-- .content -->
  	<?php endforeach; ?>
  <?php else: ?>
  	<div class="content cartshop">
  		<p>No tiene productos en el carrito de compra.</p>
  		<p><a href="<?php _e('module_url'); ?>">Visita nuestra tienda online</a> para ver nuestros productos y ofertas.</p>
  	</div>
  <?php endif; ?>

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