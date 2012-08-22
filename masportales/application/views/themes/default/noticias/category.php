<div id="news" class="section news">
  <div class="header"><h4>NOTICIAS</h4></div>
  <div class="content">
  
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
  						<img src="<?php echo get_image_url($article['photo_uri'], '', _reg('site_url') . 'usrs/blog/'); ?>" alt="<?php echo $article['photo_name']; ?>" class="photo fleft" />
  					<?php endif; ?>
  				  <div class="excerpt"><?php echo $article['excerpt']; ?></div>
  				  
  				</li>
  				<?php endforeach; ?>
  			</ul>
  		<?php else: ?>
  			<p>No hay noticias para la categoría <?php echo $data['category']['name']; ?></p>
  		<?php endif; ?>
  	</div><!-- #newslist -->
  </div><!-- .content -->
</div><!-- #news .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>