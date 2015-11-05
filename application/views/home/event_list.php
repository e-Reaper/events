<div class="container">			
	<div class="col-md-7 upcoming">
		<h2>Upcoming Events</h2>
		<sub>You all are welcome </sub><hr>
		<?php foreach($upcoming as $event)
		{
		?><div class="row">
			<div class="col-md-3">
				<a href="<?php echo base_url()?>site/events/<?php echo $event->event_id ?>">
					<img src="<?php echo base_url()."images/eventlogos/".$event->event_logo;?>" class="md-icon event-icon">
				</a>
			</div>
			<div class="col-md-9">
					<a class="h3 EventTitle" href="<?php echo base_url()?>site/events/<?php echo $event->event_id ?>">
						<?php echo $event->title; ?><?php if($event->event_public) {?>
				<?php }?>

					</a><img class="tiny-icon" src="<?php echo base_url()."images/public.jpg"?>">
				<br><span class="hashTag">
					<a href="<?php base_url() ?>site/HashTag/"<?php echo $event->event_id; ?> id="hashFor<?php echo $event->event_id; ?>">
					</a>
				</span>
				<div class="Description"><?php echo $event->location; ?><br><span id="cityFor<?php echo $event->event_id; ?>"></span></div>
				<div class="timing"><?php echo $event->sdate." at ".converttimeback($event->stime); ?></div>
				<div id="few_going<?php echo $event->event_id; ?>" ></div>
			</div>
		</div><br>
		<script>
		$(document).ready(function(){
			$.get(base+"site/few_going/"+<?php echo $event->event_id; ?>,function(data,status){			
			$('#few_going<?php echo $event->event_id; ?>').html(data);
			});
			$.get(base+"help/hash_by_event_id/"+<?php echo $event->event_id; ?>,function(data,status){			
			$('#hashFor<?php echo $event->event_id; ?>').html(data);
			});
			$.get(base+"help/city_by_id/"+<?php echo $event->city; ?>,function(data,status){			
			$('#cityFor<?php echo $event->event_id; ?>').html(data);
			});
		});
		</script>
		<?php
		}
		?>
	</div>
	<div class="col-md-5 past">
		<h2>Past Events</h2>
		<sub>See what you've missed or enjoyed</sub><hr>
		<?php foreach($past as $event)
		{
		?><div class="row">
			<div class="col-md-3">
				<a href="<?php echo base_url()?>site/events/<?php echo $event->event_id ?>">
					<img src="<?php echo base_url()."images/eventlogos/".$event->event_logo;?>" class="md-icon event-icon">
				</a>
			</div>
			<div class="col-md-9">
					<a class="h3 EventTitle" href="<?php echo base_url()?>site/events/<?php echo $event->event_id ?>">
						<?php echo $event->title; ?><?php if($event->event_public) {?>
				<?php }?>

					</a><img class="tiny-icon" src="<?php echo base_url()."images/public.jpg"?>">
				<br><span class="hashTag">
					<a href="<?php base_url() ?>site/HashTag/"<?php echo $event->event_id; ?> id="hashFor<?php echo $event->event_id; ?>">
					</a>
				</span>
				
				<div class="Description"><?php echo $event->location; ?><br><span id="cityFor<?php echo $event->event_id; ?>"></span></div>
				<div class="timing"><?php echo $event->sdate." at ".converttimeback($event->stime); ?></div>
				<div id="few_going<?php echo $event->event_id; ?>" ></div>
			</div>
		</div><br>
		<script>
		$(document).ready(function(){
			$.get(base+"site/few_going/"+<?php echo $event->event_id; ?>,function(data,status){			
			$('#few_going<?php echo $event->event_id; ?>').html(data);
			});
			$.get(base+"help/hash_by_event_id/"+<?php echo $event->event_id; ?>,function(data,status){			
			$('#hashFor<?php echo $event->event_id; ?>').html(data);
			});
			$.get(base+"help/city_by_id/"+<?php echo $event->city; ?>,function(data,status){			
			$('#cityFor<?php echo $event->event_id; ?>').html(data);
			});
		});
		</script>
		<?php
		}
		?>
	</div>
</div>