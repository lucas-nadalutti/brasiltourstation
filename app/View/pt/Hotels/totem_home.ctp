<div class="col-md-9">
	<div id="city-map" class="col-md-12">
		<img src="http://www.rioservicetour.com.br/mapas/rio.jpg" width="100%" alt="Mapa do RJ">
	</div>
	<div id="real-time-info" class="col-md-12">

		<div id="quotes" class="col-md-5 home-info-box">
			<div class="col-md-4 real-time-image">
				<?php echo $this->Html->image('cotacoes.png'); ?>
			</div>
			<div class="col-md-8">
				<h4 class="home-info-box-title">Cotações atuais</h4>
				<?php
					$dollarQuote = $quotes['dollar']['sale'];
					// $dollarVariation = $quotes['dollar']['variation'];
					// if (substr($dollarVariation, 0, 1) === '+') {
					// 	$dollarVariationClass = ' class="positive-variation"';
					// }
					// else if (substr($dollarVariation, 0, 1) === '-') {
					// 	$dollarVariationClass = ' class="negative-variation"';
					// }
					// else {
					// 	$dollarVariationClass = '';
					// }

					$euroQuote = $quotes['euro']['sale'];
					// $euroVariation = $quotes['euro']['variation'];
					// if (substr($euroVariation, 0, 1) === '+') {
					// 	$variationClass = ' class="positive-variation"';
					// }
					// else if (substr($euroVariation, 0, 1) === '-') {
					// 	$variationClass = ' class="negative-variation"';
					// }
					// else {
					// 	$variationClass = '';
					// }

					$poundQuote = $quotes['pound']['sale'];

					echo '<p class="quote-info">';
					//echo '<span class="home-info-box-label">Dólar</span>: ' . $dollarQuote;
					echo '<span class="quote-symbol"><i class="fa fa-usd"></i></span> ' . $dollarQuote;
					echo '</p>';
					/*echo '<p class="quote-latest-update">';
					echo 'Atualizado: ';
					echo '<span>' . $quotes['dollar']['latest_update'] . '</span>';
					echo '</p>';*/
					echo '<p class="quote-info">';
					//echo '<span class="home-info-box-label">Euro</span>: ' . $euroQuote;
					echo '<span class="quote-symbol"><i class="fa fa-eur"></i></span> ' . $euroQuote;
					echo '</p>';
					/*echo '<p class="quote-latest-update">';
					echo 'Atualizado: ';
					echo '<span>' . $quotes['euro']['latest_update'] . '</span>';
					echo '</p>';*/
					echo '<p class="quote-info">';
					//echo '<span class="home-info-box-label">Libra</span>: ' . $poundQuote;
					echo '<span class="quote-symbol"><i class="fa fa-gbp"></i></span> ' . $poundQuote;
					echo '</p>';
					/*echo '<p class="quote-latest-update">';
					echo 'Atualizado: ';
					echo '<span>' . $quotes['pound']['latest_update'] . '</span>';
					echo '</p>';*/
				?>
			</div>
		</div>

		<div class="col-md-2"></div>

		<div id="forecast" class="col-md-5 home-info-box">
			<div class="col-md-4 real-time-image">
				<?php echo $this->Html->image('previsao-tempo.png'); ?>
			</div>
			<div class="col-md-8">
				<div id="forecast-title" class="col-md-12">
					<h4 class="home-info-box-title">Previsão do tempo</h4>
					<?php
						echo '<p class="forecast-subtitle">';
						echo '<span class="forecast-date">' . $forecastData['date'] . '</span> | ';
						echo '<span class="forecast-place">' . $forecastData['place'] . '</span>';
						echo '</p>';
					?>
				</div>
				<div id="forecast-container" class="col-md-12">
					<div class="col-md-6 forecast-icon">
						<?php echo $this->Html->image('previsao-exemplo.png'); ?>
					</div>
					<div class="col-md-6 temperature-info">
						<?php
							echo '<div class="temperature">';
							echo '<i class="fa fa-caret-square-o-up max-temperature"></i> ' . $forecastData['max'];
							echo '°</div>';
							echo '<div class="temperature">';
							echo '<i class="fa fa-caret-square-o-down min-temperature"></i> ' . $forecastData['min'];
							echo '°</div>';
						?>
					</div>
					<?php
						/*echo '<p class="forecast-region">' . $forecastData['place'] . '</p>';
						echo '<p class="forecast-info"><span class="home-info-box-label">Tempo:</span> ';
						echo $forecastData['condition'] . '</p>';
						echo '<p class="forecast-info"><span class="home-info-box-label">Mínima:</span> ';
						echo $forecastData['min'] . '°</p>';
						echo '<p class="forecast-info"><span class="home-info-box-label">Máxima:</span> ';
						echo $forecastData['max'] . '°</p>';*/
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-md-3">
	<div id="most-accessed-attractions" class="col-md-12 home-info-box">
		<h3 class="top-5-title">Top 5 Atrações</h3>
		<!--<p class="top-5-subtitle">Atrações</p>-->
		<?php
			foreach($top5Attractions as $attraction) {
				$id = $attraction['Attraction']['id'];
				$name = $attraction['Attraction']['name'];

				echo $this->Html->link(
					$name,
					array('controller' => 'attractions', 'action' => 'show', $id),
					array('class' => 'top-5-link attraction-link')
				);
			}
		?>
	</div>
	<div id="most-accessed-packages" class="col-md-12 home-info-box">
		<h3 class="top-5-title">Top 5 Pacotes</h3>
		<?php
		
			echo $this->Html->link(
				'Pacote 1',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);

			echo $this->Html->link(
				'Pacote 2',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);

			echo $this->Html->link(
				'Pacote 3',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);

			echo $this->Html->link(
				'Pacote 4',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);

			echo $this->Html->link(
				'Pacote 5',
				array('controller' => 'attractions', 'action' => 'show'),
					array('class' => 'top-5-link package-link')
			);
		?>
	</div>
	<!--<div id="most-accessed-restaurants" class="col-md-12 home-info-box">
		<h4 class="top-5-title">Top 5</h4>
		<p class="top-5-subtitle">Restaurantes</p>
		<?php
			echo '<p>';
			echo $this->Html->link(
				'Verdana Grill',
				array('controller' => 'attractions', 'action' => 'show')
			);
			echo '</p>';
			echo '<p>';
			echo $this->Html->link(
				'Nakami',
				array('controller' => 'attractions', 'action' => 'show')
			);
			echo '</p>';
			echo '<p>';
			echo $this->Html->link(
				'7 Grill',
				array('controller' => 'attractions', 'action' => 'show')
			);
			echo '</p>';
			echo '<p>';
			echo $this->Html->link(
				'Buzin',
				array('controller' => 'attractions', 'action' => 'show')
			);
			echo '</p>';
			echo '<p>';
			echo $this->Html->link(
				'Bob\'s',
				array('controller' => 'attractions', 'action' => 'show')
			);
			echo '</p>';
		?>
	</div>-->
</div>