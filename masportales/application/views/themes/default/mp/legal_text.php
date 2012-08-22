<div id="news" class="section user">
  <div class="header"><h4><?php echo $data['legal_text']['title']; ?></h4></div>
  <div class="content">
  	<div id="newslist">
  		<div class="article-header">
  			<h2><a href="<?php echo _reg('site_url') . 'mp/' . $data['legal_text']['slug']; ?>"><?php echo $data['legal_text']['title']; ?></a></h2>
  		</div>
  		<div class="article-content"><?php echo $data['legal_text']['content']; ?></div>
  	</div><!-- #newslist -->
  </div><!-- .content -->
</div><!-- #news .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>