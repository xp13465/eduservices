
	/*
		smooth scroll
	*/
	
	window.addEvent("domready", function() {
		if (!window.attachEvent) {
			var location = window.location;
			var winHash = location.hash.replace("#", "");
			if (winHash != "") {
				var fx = new Fx.Scroll($$('body')[0], { wheelStops: false, duration: 2500 });
				fx.set(0, 0);	
				var winAnchor = $$('a[name=' + winHash + ']');
				if (winAnchor.length > 0) {
					winAnchor = winAnchor[0];
					window.setTimeout(function() {
						fx.start(0, winAnchor.getPosition().y);
					}, 200);
				}
			}
		}
		var links = $$('a');
		for (var i = 0; i < links.length; i++) {
			if (links[i].hash != "") {
				links[i].addEvent("click", function() {
					var link = this;
					var hash = this.hash.replace("#", "");
					var anchor = $$('a[name=' + hash + ']');
					if (anchor.length > 0) {
						var y = anchor[0].getPosition().y;
						var scroll = new Fx.Scroll($$('body')[0], { wheelStops: false, duration: 2500 });
						scroll.start(0, y).chain(function() {
							window.location = link.href;
						});
					} else
						window.location = link.href;
					return false;
				});
			}
		}
	});


	/*
		delay downloads for analytics
	*/
	
	window.addEvent("domready", function() {
		var downloads = $$('body .download');
		for (var i = 0; i < downloads.length; i++) {
			var download = downloads[i];
			var link = download.getElements("a")[0];
			link.onclick = function() {
				var link = this;
				if (!window.attachEvent)
					link.style.display = "none";
				var loading = new Image();
				loading.src = 'images/downloading.gif';
				loading.className = 'downloading';
				var box = link.parentNode;
				loading.inject(box, 'top');
				pageTracker._trackPageview(link.href);
				window.setTimeout(function() {
					link.style.display = "block";
					link.blur();
					box.removeChild(loading);
					window.location = link.href;
				}, 1600);
				return false;
			}
		}
	});
	
	