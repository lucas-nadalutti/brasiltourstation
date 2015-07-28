<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>Projeto Turismo</title>
	<?php
		//echo $this->Html->meta('icon');

		echo $this->Html->css('//vjs.zencdn.net/4.12/video-js.css');

		echo $this->Html->css(
			'//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'
		);
		// echo $this->Html->css('bootstrap.min.css');

		echo $this->Html->css(
			'//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'
		);
		// echo $this->Html->css('font-awesome.min.css');

		echo $this->Html->css('slick');
		echo $this->Html->css('bootstrap-tagsinput');
		echo $this->Html->css('jquery.qtip.min');
		echo $this->Html->css('main');

		echo $this->Html->scriptBlock('var wr = ' . $this->webroot);

		echo $this->Html->script(
			'//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'
		);
		// echo $this->Html->script('jquery.min.js');

		echo $this->Html->script(
			'//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'
		);
		// echo $this->Html->script('bootstrap.min.js');

		echo $this->Html->script('//vjs.zencdn.net/4.12/video.js');
		// echo $this->Html->script('video.js');

		echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places');
		echo $this->Html->script('slick.min');
		echo $this->Html->script('bootstrap-tagsinput.min');
		echo $this->Html->script('bootpag.min');
		// echo $this->Html->script('jquery.twbsPagination.min');
		echo $this->Html->script('jquery.qtip.min');
		echo $this->Html->script('typeahead');
		echo $this->Html->script('plupload.full.min');
		echo $this->Html->script('popcorn');
		echo $this->Html->script('popcorn.capture');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		$signedUser = $this->Session->read('Auth.User');
	?>
</head>
<body>

	<?php //echo 'AAAAAAAA ' . $this->webroot; ?>

	<?php if ($signedUser && $signedUser['role'] == 'Cliente'): ?>
		<!-- TOTEM LAYOUT -->

		<!-- Remove scrollbar in browsers that support this removal -->
		<style type = "text/css">
	    	body::-webkit-scrollbar {
				width: 0 !important;
			}
	    </style>

	    <!-- jQuery Carousel for sponsors -->
	    <script>
	    	$(document).ready(function() {
		    	$('#sponsors').slick({
					autoplay: true,
					autoplaySpeed: 5000,
					arrows: false,
					pauseOnHover: false,
		    	});
	    	});
	    </script>

		<div id="left-bar-placeholder" class="col-md-1"></div>
		<div class="col-md-1 fixed-bar fixed-bar-left">
			<div class="col-md-12 bar-container">
				<div id="our-logo" class="col-md-12 fixed-bar-link-box bar-logo">
					<?php
						echo $this->Html->link(
							'
							<p><img src="http://img1.wikia.nocookie.net/__cb20100113135842/starwars/images/4/4e/PurplePlanet-FT.jpg"></p>
							',
							array(
								'controller' => 'hotels',
								'action' => 'totemHome',
							),
							array(
								'class' => 'fixed-bar-link',
								'escape' => false,
							)
						);
					?>
				</div>
				<div id="bar-home" class="col-md-12 fixed-bar-link-box">
					<?php
						echo $this->Html->link(
							'
							<p><i class="fa fa-home"></i></p>
							',
							array(
								'controller' => 'hotels',
								'action' => 'totemHome',
							),
							array(
								'class' => 'fixed-bar-link',
								'escape' => false,
							)
						);
					?>
				</div>
				<div class="col-md-12 fixed-bar-link-box bar-logo">
					<?php
						echo $this->Html->link(
							'
							<p><img src="http://www.underconsideration.com/brandnew/archives/ibis_budget_logo.jpg"></p>
							',
							array(
								'controller' => 'hotels',
								'action' => 'hotelInfo',
							),
							array(
								'class' => 'fixed-bar-link',
								'escape' => false,
							)
						);
					?>
				</div>
				<div id="language-flags" class="md-col-12 fixed-bar-link-box">
					<?php
						echo $this->Html->link(
							'
							<p class="language-flag-icon">
							'.$this->Html->image('brazil-black.png').'
							</p>
							',
							array(
								'controller' => 'hotels',
								'action' => 'totemHome',
							),
							array(
								'class' => 'fixed-bar-link',
								'escape' => false,
							)
						);
						echo $this->Html->link(
							'
							<p class="language-flag-icon">
							'.$this->Html->image('us-black.png').'
							</p>
							',
							array(
								'controller' => 'hotels',
								'action' => 'totemHome',
							),
							array(
								'class' => 'fixed-bar-link',
								'escape' => false,
							)
						);
						echo $this->Html->link(
							'
							<p class="language-flag-icon">
							'.$this->Html->image('spain-black.png').'
							</p>
							',
							array(
								'controller' => 'hotels',
								'action' => 'totemHome',
							),
							array(
								'class' => 'fixed-bar-link',
								'escape' => false,
							)
						);
					?>
				</div>
			</div>
		</div>
		<div id="container" class="col-md-10">
			<div id="header" class="col-md-12">
				<?php
					echo '<div class="col-md-12 menu-row">';

					echo '<div class="menu-item-link-box hotel-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Conheça') . '<br>' . __('seu hotel') . '</p>
						<p>
						'.$this->Html->image('menu-icons/hotel.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'hotels',
							'action' => 'hotelInfo',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '<div class="menu-item-link-box attractions-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Atrações') . '<br>' . __('turísticas') . '</p>
						<p>
						'.$this->Html->image('menu-icons/atracoes.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'attractions',
							'action' => 'attractionsList',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '<div class="menu-item-link-box packages-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Pacotes') . '<br>' . __('turísticos') . '</p>
						<p>
						'.$this->Html->image('menu-icons/pacotes.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'hotels',
							'action' => 'hotelInfo',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '<div class="menu-item-link-box food-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Onde') . '<br>' . __('comer') . '</p>
						<p>
						'.$this->Html->image('menu-icons/onde-comer.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'hotels',
							'action' => 'hotelInfo',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '<div class="menu-item-link-box shopping-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Onde') . '<br>' . __('comprar') . '</p>
						<p>
						'.$this->Html->image('menu-icons/compras.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'hotels',
							'action' => 'hotelInfo',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '<div class="menu-item-link-box car-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Alugue um') . '<br>' . __('automóvel') . '</p>
						<p>
						'.$this->Html->image('menu-icons/alugue-carro.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'hotels',
							'action' => 'hotelInfo',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '<div class="menu-item-link-box virtual-store-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Loja') . '<br>' . __('virtual') . '</p>
						<p>
						'.$this->Html->image('menu-icons/loja-virtual.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'hotels',
							'action' => 'hotelInfo',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '<div class="menu-item-link-box olympics-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Olimpíadas') . '<br>' . __('2016') . '</p>
						<p>
						'.$this->Html->image('menu-icons/rio-2016.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'hotels',
							'action' => 'hotelInfo',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '<div class="menu-item-link-box about-city-item">';
					echo $this->Html->link(
						'
						<div class="menu-content-box">
						<div class="menu-content">
						<p>' . __('Agenda') . '<br>' . __('cultural') . '</p>
						<p>
						'.$this->Html->image('menu-icons/agenda-cultural.png').'
						</p>
						</div>
						</div>
						',
						array(
							'controller' => 'hotels',
							'action' => 'hotelInfo',
						),
						array(
							'class' => 'menu-item-link',
							'escape' => false,
						)
					);
					echo '</div>';

					echo '</div>';
				?>
			</div>
			<div id="content" class="col-md-12">
				<?php
					echo $this->Session->flash('auth');
					echo $this->Session->flash();

					echo $this->fetch('content');
				?>
			</div>
			<div id="footer">

			</div>
		</div>
		<div id="right-bar-placeholder" class="col-md-1"></div>
		<div class="col-md-1 fixed-bar fixed-bar-right">
			<div id="sponsors" class="col-md-12 bar-container">
				<div class="col-md-12 sponsor-area">
					<div class="sponsor-box">
						<p>Endereço 1</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 1</p>
						<p>Saiba mais</p>
					</div>
					<div class="sponsor-box">
						<p>Endereço 2</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 2</p>
						<p>Saiba mais</p>
					</div>
					<div class="sponsor-box">
						<p>Endereço 3</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 3</p>
						<p>Saiba mais</p>
					</div>
				</div>
				<div class="col-md-12 sponsor-area">
					<div class="sponsor-box">
						<p>Endereço 4</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 4</p>
						<p>Saiba mais</p>
					</div>
					<div class="sponsor-box">
						<p>Endereço 5</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 5</p>
						<p>Saiba mais</p>
					</div>
					<div class="sponsor-box">
						<p>Endereço 6</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 6</p>
						<p>Saiba mais</p>
					</div>
				</div>
				<div class="col-md-12 sponsor-area">
					<div class="sponsor-box">
						<p>Endereço 7</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 7</p>
						<p>Saiba mais</p>
					</div>
					<div class="sponsor-box">
						<p>Endereço 8</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 8</p>
						<p>Saiba mais</p>
					</div>
					<div class="sponsor-box">
						<p>Endereço 9</p>
						<?php
							echo $this->Html->link(
								'
								<p>
								'.$this->Html->image('patrocinador-parceiro.png').'
								</p>
								',
								array(
									'controller' => 'hotels',
									'action' => 'totemHome',
								),
								array(
									'class' => 'fixed-bar-link',
									'escape' => false,
								)
							);
						?>
						<p>Descrição 9</p>
						<p>Saiba mais</p>
					</div>
				</div>
			</div>
		</div>
	<?php elseif ($signedUser && $signedUser['role'] == 'Administrador'): ?>
		<!-- ADMIN LAYOUT -->

		<div id="container" class="col-md-12">
			<div id="header" class="col-md-12">
				<?php
					echo $this->Html->link(
						__('Cadastrar usuário'),
						array('controller' => 'users', 'action' => 'create')
					);
					echo $this->Html->link(
						__('Lista de usuários'),
						array('controller' => 'users', 'action' => 'index')
					);
					echo $this->Html->link(
						__('Cadastrar vídeo'),
						array('controller' => 'videos', 'action' => 'save')
					);
					echo $this->Html->link(
						__('Cadastrar atração'),
						array('controller' => 'attractions', 'action' => 'create')
					);
					echo $this->Html->link(
						__('Lista de atrações'),
						array('controller' => 'attractions', 'action' => 'index')
					);
					echo $this->Html->link(
						__('Cadastrar tag'),
						array('controller' => 'tags', 'action' => 'create')
					);
					echo $this->Html->link(
						__('Lista de tags'),
						array('controller' => 'tags', 'action' => 'index')
					);
					echo $this->Html->link(
						__('Trocar senha'),
						array('controller' => 'users', 'action' => 'changePassword')
					);
					echo $this->Html->link(
						__('Logout'),
						array('controller' => 'users', 'action' => 'logout')
					);
				?>
			</div>
			<div id="content" class="col-md-12">
				<?php
					// TODO: Replace Session->setFlash with Flash->set everywhere 
					echo $this->Flash->render('auth');
					echo $this->Session->flash();

					echo $this->fetch('content');
				?>
			</div>
			<div id="footer">

			</div>
		</div>
	<?php else: ?>
		<!-- NOT LOGGED IN LAYOUT -->

		<div id="container" class="col-md-12">
			<div id="header" class="col-md-12">

			</div>
			<div id="content" class="col-md-12">
				<?php
					echo $this->Flash->render('auth');
					echo $this->Session->flash();

					echo $this->fetch('content');
				?>
			</div>
			<div id="footer">

			</div>
		</div>
	<?php endif; ?>
</body>
</html>
