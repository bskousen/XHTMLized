<style type="text/css" media="screen">
    /* override free days background in jquery ui datepicker */
    .free-day {
      background: #2e9500;
    }
     
    .free-day a {
      opacity: 0.7;
    }
</style>
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
        <?php if ($data['search_query'] and $data['events']): ?>
        <div>
            <p class="message">Resultados para la búsqueda: <?php echo $data['search_query']; ?></p>
        </div>
        <?php endif; ?>
        <?php if ($data['events']): ?>
        <div id="eventslist">
            <?php foreach($data['events'] as $day => $events_per_day): ?>
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
                        <h3><a href="<?php echo _reg('site_url'); ?>agenda/<?php echo $event['slug']; ?>">
                            <?php echo $event['title']; ?></a></h3>
                            <?php if($event['have_comment']) : ?>
                             <a href="http://demo.masportales.es/agenda/<?php echo $event["slug"] ?>#comments" class="comments">
       <img src="http://demo.masportales.es/images/icon_comments.png" alt="comentarios">
      <span>(<?php echo $event["comment_number"] ?> comentarios)</span>
    </a>
            <?php endif; ?>
                        <div class="excerpt">
                            <?php echo character_limiter($event['content'], 160); ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- #events-column -->
            <?php endforeach; ?>
        </div>
        <!-- #eventslist -->
        <?php else: ?>
        <p class="message">No hay eventos<?php echo ($data['search_query']) ? ' para la busqueda \'' . $data['search_query'] . '\'' : ''; ?>.</p>
        <?php endif; ?>
    </div>
    <!-- .content -->
</div>
<!-- #events .section -->
<div id="eventssearch" class="search">
    <form method="post" action="<?php echo _reg('site_url'); ?>agenda/search" name="eventssearchform">
        <p>
            <input name="searchquery" type="text" value="Buscar en la agenda..." />
            <a href="javascript:document.eventssearchform.submit();" id="search-btn"><img src="<?php echo _reg('site_url') . _reg('theme_path'); ?>images/btn_search.png" alt="buscar" /></a></p>
    </form>
</div>
<!-- #eventssearch --> 
  <script>
  // declare freeDays global
var freeDays = [];
 
// perform initial json request for free days

fetchFreeDays();

$(document).ready(function () {
	
  
 
});

// query for free days in datepicker
function fetchFreeDays()
{
    
    $.get("/agenda/calendar/", function(data){
      $.each(data, function(index, value) {
            //console.log(value.freeDate);
            //freeDays = data;
          freeDays.push(value);
          //highlightDays(value);
         // highlightDays(value.freeDate);
     });

    var search_event_day = $('.searcheventday .datepicker-container').datepicker({
    changeMonth: true,
    changeYear: true,
    showOtherMonths: true,
    selectOtherMonths: true,
    //numberOfMonths: 2,
    dateFormat: 'DD, d MM, yy',
    altField: '#date_due',
    altFormat: 'yy-mm-dd',
    //beforeShowDay: $.datepicker.noWeekends,
    beforeShowDay: highlightDays,
    //onChangeMonthYear: fetchDayUsage,
    firstDay: 1, // rows starts on Monday
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
   // console.log(freeDays);
}
 
// runs for every day displayed in datepicker, adds class and tooltip if matched to days in freeDays array
function highlightDays(date)
{
  console.log(freeDays);
    var x = 0;
    for (var i = 0; i < freeDays.length; i++) {
      console.log("FOREACH");
    // if (freeDays[i] == date) {
      console.log(new Date(freeDays[i]).toString());
      console.log("DESPUES");
      console.log(date.toString());
      if (new Date(freeDays[i]).toString() === date.toString()) {
      console.log('ELEGIDO');
       return [true, 'free-day'];
      }
    }
    console.log('SIN');
      return [true, ''];
}

</script>