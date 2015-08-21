<h1>Sobre o Hotel</h1>

<div class="col-md-12 grid-wrapper">
	<div id="attraction-video-box" class="col-md-5">
		<div id="attraction-video-wrapper">
			<?php
				if (isset($video)) {
					echo '<video id="hotel-video" class="video-js vjs-default-skin">';
					echo '<source src="';
					echo $this->webroot . $video['Video']['file_path'];
					echo '" type="';
					echo $video['Video']['type'];
					echo '"/>';
					echo '</video>';
				}
				else {
					echo '<p>O hotel ainda não possui um vídeo</p>';
				}
			?>
		</div>
	</div>

	<div id="attraction-description-box" class="col-md-7">
		<h3><?php echo $userHotel['name']; ?></h3>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>
</div>

<div class="col-md-12 grid-wrapper">
	<div id="attraction-video-box" class="col-md-7">
		<h2>Galeria</h2>

		<div id="hotel-photos">
			<div class="photo-slide">
				<img src="https://socialnaukar.files.wordpress.com/2014/10/hotel_krc3b3lewski_interior_01.jpeg" />
			</div>
			<div class="photo-slide">
				<img src="http://www.interiordaily.pics/wp-content/uploads/2014/06/VIENNA-Share-My-Travel.jpg" />
			</div>
			<div class="photo-slide">
				<img src="http://www.idesignarch.com/wp-content/uploads/FourSeasonsBosphorus_1.jpg" />
			</div>
			<div class="photo-slide">
				<img src="http://cdn.freshome.com/wp-content/uploads/2013/07/luxury-modern-hotel-room-interior-design-ideas.jpg" />
			</div>
			<div class="photo-slide">
				<img src="http://hotelespremier.com/wp-content/uploads/2015/03/Collection-Hotel-Interior-Collection-3D-Model-max-CGTrader-.jpg" />
			</div>
		</div>
	</div>
	<div id="attraction-video-box" class="col-md-5">
		<h2>Horários</h2>

		<p>7 às 10h - Café da manhã</p>
		<p>12h às 15h - Almoço</p>
		<p>13h às 22h - Hidromassagem</p>
		<p>etc</p>
	</div>
</div>

<script>

	$(document).ready(function() {

		videojs('hotel-video', {controls: true, preload: 'auto'}, function() {

			var player = this;

			$('#hotel-video').click(function() {
				// When user clicks, the video starts playing before the click event triggers
				if (!player.paused()) {
					player.requestFullscreen();
				}
			});

			player.on('ended', function() {
				player.exitFullscreen();
			});

			player.on('fullscreenchange', function() {
				// Stop playing video if user exists fullscreen
				if (!player.isFullscreen()) {
					player.pause();
					$('.vjs-control-bar').hide();
				}
				else {
					$('.vjs-control-bar').show();
				}
			});

		});

		$('#hotel-photos').slick({
			centerMode: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			prevArrow: '<a class="btn btn-lg slick-prev"><i class="fa fa-angle-double-left"></i></a>',
			nextArrow: '<a class="btn btn-lg slick-next"><i class="fa fa-angle-double-right"></i></a>',
		});

	});

</script>