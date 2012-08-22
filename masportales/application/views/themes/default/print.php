<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title><?php echo $this->registry->get_meta('title'); ?></title>
		<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>reset.css" />
		<link rel="stylesheet" href="<?php echo _reg('css_url'); ?>print.css" />
	</head>
	<body onload="window.print()">
		<div class="header">
			<div class="brand"><a href="<?php echo _reg('site_url'); ?>"><img src="<?php _e('site_url'); ?>images/mp_demologo.png" alt="demo+portales" /></a></div>
		</div><!-- .header -->
		<div class="content">
			<div class="header">
				<h1 style="font-size:2em;"><?php echo $item['title']; ?></h1>
				<?php if ($module == 'event'): ?>
					<p class="item-date"><?php echo fecha($item['date_added']); ?></p>
				<?php else: ?>
					<p class="item-date">publicado el <?php echo fecha($item['date_added'], 'medium'); ?></p>
				<?php endif; ?>
			</div><!-- .header -->
			<div class="item-content">
				<?php if ($item['image_uri']): ?>
				<?php $image_size = ($module == 'ecommerce') ? '220x220' : '210x210'; ?>
					<img src="<?php echo get_image_url($item['image_uri'], $image_size, _reg('site_url') . $item['image_folder']); ?>" />
				<?php endif; ?>
				<?php echo $item['content']; ?>
			</div><!-- .item-content -->
		</div><!-- .content -->
		<div style="clear:both;"></div>
		<?php if ($comments): ?>
		<div class="content comments">
			<h2>Comentarios</h2>
			<?php foreach ($comments as $comment): ?>
			<div class="comment">
				<p class="comment-header">Comentario enviado por <b><?php echo $comment['author']; ?></b>
				<br />el <?php echo fecha($comment['date_added'], 'medium'); ?></p>
				<p class="comment-content"><?php echo $comment['content']; ?></p>
			</div>
			<?php endforeach; ?>
		</div><!-- .content comments -->
		<?php endif; ?>
		<div class="footer">
			<p><?php echo $this->registry->site('name'); ?>+Portales, noticias, empresas, productos y servicios para tu localidad - ® 2011 todos los derechos reservados</p>
		</div><!-- .footer -->
	</body>
</html>
