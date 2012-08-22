<div id="news" class="section news">
    <div class="header">
        <h4>NOTICIAS</h4>
    </div>
    <div class="content">
        <div id="newscats">
            <?php if ($blog['categories']): ?>
            <ul>
                <?php foreach($blog['categories'] as $category): ?>
                <li><a href="<?php echo _reg('site_url') . 'noticias/' . $category['slug'];  ?>" class="btn-news"><?php echo $category['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        <div id="newslist">
            <?php if ($blog['articles']): ?>
            <ul>
                <?php foreach ($blog['articles'] as $article): ?>
                <li>
                    <h2><a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug']; ?>"><?php echo $article['title']; ?></a></h2>
                    <p class="article-date"><?php echo strftime('%d/%m/%G', strtotime($article['date_added'])); ?></p>
                    <a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug'] . '#comments'; ?>" class="comments"> <img src="<?php _e('site_url'); ?>/images/icon_comments.png" alt="comentarios" /> <span>(<?php echo $article['comment_count'] ?> comentarios)</span> </a>
                    <?php if (isset($article['photo_uri'])): ?>
                    <a href="<?php echo _reg('site_url') . 'noticias/' . $article['slug']; ?>" title="<?php echo $article['title']; ?>"> <img src="<?php echo get_image_url($article['photo_uri'], '', _reg('site_url') . 'usrs/blog/'); ?>" alt="<?php echo $article['photo_name']; ?>" class="photo fleft" /> </a>
                    <?php endif; ?>
                    <div class="excerpt">
                        <?php echo $article['excerpt']; ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p>No hay noticias.</p>
            <?php endif; ?>
            </ul>
        </div>
        <!-- #newslist -->
    </div>
    <!-- .content -->
    <div class="search-btn">
        <form method="post" action="<?php echo _reg('site_url'); ?>noticias/search" name="blogsearchform">
            <p><label class="input"> <span>Buscar en noticias</span>
                <input name="searchquery" type="text" class="input-text"/></label>
                <a href="javascript:document.blogsearchform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
        </form>
    </div>
    <!-- #blogsearch -->
</div>
<!-- #news .section -->
<?php $this->mpbanners->print_banner('column-main', 'fullbanner'); ?>
<div id="events" class="section">
    <div class="header">
        <h4>AGENDA</h4>
    </div>
    <div class="content">
        <div class="searcheventday">
            <div class="datepicker-launcher">
                <a href="#" class="btn-events">Buscar un día…</a>
            </div>
            <div class="datepicker-container">
            </div>
        </div>
        <?php if ($events): ?>
        <div id="eventslist">
            <?php foreach($events as $day => $events_per_day): ?>
            <div class="events-column">
                <div class="date-column">
                    <?php echo fecha($day, 'day'); ?> <?php echo fecha($day, 'shortmonthname'); ?>
                </div>
                <ul>
                    <?php foreach ($events_per_day as $event_id => $event): ?>
                    <li>
                        <?php if ($event['image']): ?>
                        <img src="<?php echo get_image_url($event['image'], '96x96', _reg('site_url') . 'usrs/events/'); ?>" alt="<?php echo $event['title']; ?>" class="photo fleft" />
                        <?php endif; ?>
                        <h3><a href="<?php echo _reg('site_url'); ?>agenda/<?php echo $event['slug']; ?>"><?php echo $event['title']; ?></a></h3>
                        <div class="excerpt">
                            <?php echo character_limiter($event['content'], 160); ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
        <!-- #eventslist -->
        <?php else: ?>
        <p>No hay eventos en este momento.</p>
        <?php endif; ?>
    </div>
    <!-- .content -->
    <div class="search-btn">
        <form method="post" action="<?php echo _reg('site_url'); ?>agenda/search" name="eventssearchform">
            <p><label class="input"> <span>Buscar en agenda</span>
                <input name="searchquery" type="text" /></label>
                <a href="javascript:document.eventssearchform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
        </form>
    </div>
    <!-- #eventssearch -->
</div>
<!-- #events .section --> 

<script>
$(document).ready(function () {
	var search_event_day = $('.searcheventday .datepicker-container').datepicker({
  	onSelect: function (dateText, inst) {
  		console.log(formatDateDB(dateText).substr(0,10));
  		console.log(inst);
  		window.location.href = '/agenda/dia/'+formatDateDB(dateText).substr(0,10);
  	}
  });
  
  $('.datepicker-launcher a').click( function(event) {
  	event.preventDefault();
  	search_event_day.toggle();
  });

});
</script>