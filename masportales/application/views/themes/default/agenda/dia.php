<div id="events" class="section">
	<div class="header"><h4>AGENDA</h4></div>
  <div class="content" id="eventslist">
  	<h2>Eventos para el día <span><?php echo $data['dia']; //echo "ffffd";var_dump($data["events"]);?></span></h2>
  	<?php if ($data['events']): ?>
		<ul>
  	<?php foreach ($data['events'] as $event): ?>
  	  <li>
  	  	<h3><a href="<?php echo _reg('site_url'); ?>agenda/<?php echo $event['slug']; ?>"><?php echo $event['title']; ?></a></h3>
  	  	<div class="excerpt"><?php echo character_limiter($event['content'], 260); ?></div>
  	  </li>
  	<?php endforeach; ?>
  	</ul>

  	<?php else: ?>
  		<p>No hay eventos para este día.</p>
  	<?php endif; ?>
  </div><!-- .content -->
</div><!-- #events .section -->