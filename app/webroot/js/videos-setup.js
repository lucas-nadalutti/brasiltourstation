

$(document).ready(function() {
	var $video;
	var popcornVideo;

	$.each($('.video-js'), function() {
		popcornVideo = Popcorn('#' + $(this).attr('id'));
		// Once the video has loaded into memory, we can capture the poster
		popcornVideo.on('canplayall', function() {
			this.capture({
				at: Math.floor(1 + Math.random() * 10),
				media: true
			});
		});
	});
});