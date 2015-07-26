<h1>Passeios Turísticos</h1>

<?php

foreach ($videos as $video) {
	$id = $video['Video']['id'];
	$name = $video['Video']['name'];
	$type = $video['Video']['type'];
	$url = $videosPath . $video['Video']['url'];
	echo '<h3>' . $name . '</h3>';
	echo '<video id="video-'.$id.'" class="video-js vjs-default-skin" controls preload="auto" width="640" height="264">';
	echo '<source src="'.$url.'" type='.$type.' />';
	echo '<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>';
	echo '</video>';
}

echo $this->Html->script('videos-setup');

?>