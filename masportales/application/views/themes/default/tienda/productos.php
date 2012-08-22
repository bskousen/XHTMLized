<div class="section sales">
    <div class="header_individual">
        <h4>PRODUCTOS</h4>
    </div>
    <div class="content">
    	<div id="sales">
        <?php if ($data['search_query'] and $data['products']): ?>
        <div>
            <p class="message">Resultados para la búsqueda: <?php echo $data['search_query']; ?></p>
        </div>
        <?php endif; ?>
        
        <?php if (isset($data['products']) and $data['products']): ?>
        <ul>
            <?php foreach($data['products'] as $product): ?>
            <?php
  	  // get the proper image filename and url
  	  if ($product['main_image']) {
  	    $image = _reg('site_url') . 'usrs/productos/' . $product['main_image'] . '_75x75.' . $product['main_ext'];
  	  } else {
  	    $image = _reg('site_url') . 'usrs/nophoto_75x75.jpg';
  	  }
  	  ?>
            <li>
                <a href="<?php echo _reg('module_url') . $product['slug']; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $product['name']; ?>" class="photo fleft" /></a>
                <h3><a href="<?php echo _reg('module_url') . $product['slug']; ?>"><?php echo $product['name']; ?></a></h3>
                <div class="excerpt">
                    <?php echo substr($product['description'], 0, 60); ?>…
                </div>
                <div class="price">
                    <?php echo number_format($product['price'], 2, ',', '.'); ?> €
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p class="message info">No hay ningún producto<?php echo ($data['search_query']) ? ' para la busqueda \'' . $data['search_query'] . '\'' : ' en la tienda'; ?>.</p>
        <?php endif; ?>
        </div><!-- #sales -->
    </div><!-- .content -->
    <div class="search productsearch">
        <form method="post" action="<?php echo _reg('site_url'); ?>tienda/search" name="productsearchform">
            <p>
                <input name="searchquery" type="text" value="Buscar en productos..." />
                <a href="javascript:document.productsearchform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
        </form>
    </div>
    <!-- #productsearch -->
</div>
<!-- .sales .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>
