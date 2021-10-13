(function() {

	const youtubes = document.querySelectorAll('.youtube');

	if (youtubes !== null) {
		youtubes.forEach((youtube) => {
			let image = new Image();
			image.src = '//img.youtube.com/vi/' + youtube.dataset.embed + '/maxresdefault.jpg';
			if (!!youtube.dataset.image) {
				image.src = youtube.dataset.image;
			}
			image.alt = 'YouTube-video';
			image.addEventListener('load', function() {
				youtube.appendChild(image);
			});
			youtube.addEventListener('click', function() {
				let iframe = document.createElement('iframe');
				iframe.setAttribute('id', 'youtube-video');
				iframe.setAttribute('frameborder', '0');
				iframe.setAttribute('allowfullscreen', '');
				iframe.setAttribute('src', '//www.youtube.com/embed/' + this.dataset.embed + '?rel=0&showinfo=0&autoplay=1');
				this.appendChild(iframe);
			});
		});
	}

})();
