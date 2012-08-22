<div id="news" class="section user">
  <div class="header"><h4>Mapa Web</h4></div>
  <div class="content">
  	<div class="sitemap">
  		<ul>
  		<?php foreach ($data['legal_texts'] as $legal_text): ?>
  			<li><a href="<?php echo $legal_text['slug']; ?>"><?php echo $legal_text['title']; ?></a></li>
  		<?php endforeach; ?>
  			<li><a href="">Mapa Web</a></li>
  			<li><a href="">Contacto</a></li>
  			<?php foreach ($data['sections'] as $section_key => $section): ?>
  			<li>
  				<a href="<?php echo $section['slug']; ?>"><?php echo $section['title']; ?></a>
  				<ul>
  				<?php foreach ($data[$section_key] as $section_item): ?>
  					<li><a href="<?php echo $section_item['slug']; ?>"><?php echo $section_item['title']; ?></a></li>
  				<?php endforeach; ?>
  				</ul>
  			</li>
  			<?php endforeach; ?>
  		</ul>
  	</div><!-- #newslist -->
  </div><!-- .content -->
</div><!-- #news .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>