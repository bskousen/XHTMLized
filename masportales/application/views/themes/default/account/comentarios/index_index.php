<div id="ucomments" class="section user">
  <div class="header"><h4>Comentarios</h4></div>
  <div class="content ucomments">
  	<p>Le mostramos a continuación un listado con todos los comentarios que ha enviado a las distintas noticias, eventos, productos, etc.</p>
  	<!-- 
  	<div class="buttons-top">
  		<a href="<?php echo _reg('site_url'); ?>micuenta/comentarios/category" class="btn-acc">Noticias</a>
  		<a href="<?php echo _reg('site_url'); ?>micuenta/comentarios/category" class="btn-acc">Eventos</a>
  		<a href="<?php echo _reg('site_url'); ?>micuenta/comentarios/category" class="btn-acc">Productos</a>
  	</div>
  	-->
  </div><!-- .content -->
  <div class="content ucomments">
  	<h6>Comentarios en las noticias</h6>
    <?php if ($data['blog']): ?>
    <ul>
    <?php foreach ($data['blog'] as $blog_comment): ?>
    	<li>
    		<p>
    			<span class="comment-stitle">Noticia</span>
    			<a href="<?php echo _reg('site_url'); ?>/noticias/<?php echo $blog_comment['article_slug']; ?>" class="comment-atitle"><?php echo $blog_comment['article_title']; ?></a>
    		</p>
    		<div class="comment-content nodisplay">
    			<p><span class="comment-stitle">Comentario</span> <?php echo $blog_comment['content']; ?></p>
    			<p><span class="comment-stitle">enviado el:</span><?php echo strftime('%d/%m/%G a las %T', strtotime($blog_comment['date_added'])); ?></p>
    		</div>
    		<p class="buttons-bottom">
    			<?php $approved = ($blog_comment['approved']) ? 'aprobado' : 'pendiente'; ?>
    			<span class="comment-status"><?php echo $approved; ?></span>
    			<a href="#" class="btn-acc show-comment">mostrar / ocultar</a>
    			<a href="#" class="btn-acc delete-comment">borrar</a>
    			<form action="" method="post" class="delete-comment-form">
    				<input type="hidden" name="ctpe" value="blog" />
    				<input type="hidden" name="cmid" value="<?php echo $blog_comment['comment_ID']; ?>" />
    			</form>
    		</p>
    	</li>
    <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <p>No tiene comentarios en ningún artículo.</p>
    <?php endif; ?>
  </div><!-- .content -->
  <div class="content ucomments">
  	<h6>Comentarios en los productos</h6>
    <?php if ($data['products']): ?>
    <ul>
    <?php foreach ($data['products'] as $product_comment): ?>
    	<li>
    		<p>
    			<span class="comment-stitle">Producto</span>
    			<a href="<?php echo _reg('site_url'); ?>/tienda/<?php echo $product_comment['slug']; ?>" class="comment-atitle"><?php echo $product_comment['name']; ?></a>
    		</p>
    		<div class="comment-content nodisplay">
    			<p><span class="comment-stitle">Comentario</span> <?php echo $product_comment['content']; ?></p>
    			<p><span class="comment-stitle">enviado el:</span><?php echo strftime('%d/%m/%G a las %T', strtotime($product_comment['date_added'])); ?></p>
    		</div>
    		<p class="buttons-bottom">
    			<?php $approved = ($product_comment['approved']) ? 'aprobado' : 'pendiente'; ?>
    			<span class="comment-status"><?php echo $approved; ?></span>
    			<a href="#" class="btn-acc show-comment">mostrar / ocultar</a>
    			<a href="#" class="btn-acc delete-comment">borrar</a>
    		</p>
    		<form action="" method="post" class="delete-comment-form">
    			<input type="hidden" name="ctpe" value="product" />
    		  <input type="hidden" name="cmid" value="<?php echo $product_comment['comment_ID']; ?>" />
    		</form>
    	</li>
    <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <p>No tiene comentarios en ningún producto.</p>
    <?php endif; ?>
  </div><!-- .content -->
</div><!-- #uprofile .section .user -->
<script>
$(document).ready(function() {
	$(document).on('click', '.show-comment', function (event) {
  	event.preventDefault();
  	//$(this).text('') TODO
  	$(this).parent().parent().find('.comment-content').toggle();
  });
  
  $(document).on('click', '.delete-comment', function (event) {
  	event.preventDefault();
  	//$(this).text('') TODO
  	console.log('delete');
  	$(this).parent().parent().find('.delete-comment-form').submit();
  	console.log($(this).parent().parent().find('.delete-comment-form'));
  });
});
</script>
