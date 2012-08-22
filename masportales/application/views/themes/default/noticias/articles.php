<div id="news" class="section news">
  <div class="header"><h4>NOTICIAS</h4></div>
  <div class="content">
  	<?php if ($data['search_query'] and $data['articles']): ?>
  	<div>
  		<p class="message">Resultados para la búsqueda: <?php echo $data['search_query']; ?></p>
  	</div>
  	<?php endif; ?>
    
<div id="newscats">
  		<?php if (isset($data['categories']) and $data['categories']): ?>
  		<ul>
  			<?php foreach ($data['categories'] as $category): ?>
  				<li><a href="<?php echo _reg('site_url') . 'noticias/' . $category['slug'];  ?>" class="btn-news"><?php echo $category['name']; ?></a></li>
  			<?php endforeach; ?>
  		</ul>
  		<?php endif; ?>
  	</div>    
    
  	<div id="newslist">
  		<?php if ($data['articles']): ?>
  			<ul>
  				<?php foreach ($data['articles'] as $article): ?>
  				<li>
  				  <h2><a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug']; ?>"><?php echo $article['title']; ?></a></h2>
  				  <p class="article-date"><?php echo strftime('%d/%m/%G', strtotime($article['date_added'])); ?></p> <a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug'] . '#comments'; ?>" class="comments">
  				  	<img src="<?php _e('site_url'); ?>/images/icon_comments.png" alt="comentarios" />
  				  	<span>(<?php echo $article['comment_count'] ?> comentarios)</span>
  				  </a>
  				  <?php if (isset($article['photo_uri'])): ?>
  						<a class="lightbox" href="<?php echo get_image_url($article['photo_uri'], false, _reg('site_url') . 'usrs/blog/'); ?>" title="<?php echo $article['title']; ?>"><img src="<?php echo get_image_url($article['photo_uri'], '', _reg('site_url') . 'usrs/blog/'); ?>" alt="<?php echo $article['photo_name']; ?>" class="photo fleft" /></a>
  					<?php endif; ?>
  				  <div class="excerpt"><?php echo $article['excerpt']; ?></div>
  				  
  				</li>
  				<?php endforeach; ?>
  			</ul>
  		<?php else: ?>
  			<p class="message">No hay noticias<?php echo ($data['search_query']) ? ' para la busqueda \'' . $data['search_query'] . '\'' : ''; ?>.</p>
  		<?php endif; ?>
  	</div><!-- #newslist -->
  </div><!-- .content -->
  <div id="blogsearch" class="search">
	<form method="post" action="<?php echo _reg('site_url'); ?>noticias/search" name="blogsearchform">
	  <p><input name="searchquery" type="text" value="Buscar en noticias..." />
	  <a href="javascript:document.blogsearchform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
	</form>
	</div><!-- #blogsearch -->
</div><!-- #news .section -->

<?php //$this->mpbanners->print_banner('column-main', 'fullbanner'); ?>