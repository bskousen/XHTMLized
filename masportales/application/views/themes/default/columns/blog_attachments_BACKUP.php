<?php if ($attachments = $this->registry->column_item('blog_attachments')): ?>
<div id="news-column1" class="section news">
	<div class="header"><h4>Galería</h4></div>
  <div class="content">
  	<div id="newsattach">
  		<ul>
  			<?php foreach ($attachments as $attachment): ?>
  			<li>
  				<img src="<?php echo get_image_url($attachment['uri'], '210x210', _reg('site_url') . 'usrs/blog/'); ?>" alt="" class="photo" />
  			</li>
  			<?php endforeach; ?>
  		</ul>
  	</div><!-- #newsattach -->
  </div><!-- .content -->
</div><!-- #news-column1 .section -->
<?php endif; ?>