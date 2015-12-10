window.addEventListener('load', function() {
	var buttons = document.getElementsByTagName("button");
	for (var i = 0; i < buttons.length; i++) {
		buttons[i].addEventListener("click", function( event ) {
			var that = this;
			var id = this.getAttribute('data-id');
			var r = new XMLHttpRequest();
			r.open("POST", "mute.php", true);
			r.onreadystatechange = function () {
				if (r.readyState != 4 || r.status != 200) return;
				var status = JSON.parse(r.responseText);
				if (status.unmuted == id) {
					that.textContent = "Mute";
				} else {
					that.textContent = "Unmute";
				}
			};
			var formData = new FormData();
			formData.append('id', id);
			r.send(formData);
		});
	}

var timings = document.getElementsByTagName("time");
for (var i = 0; i < timings.length; i++) {
	  var arr = new Date(timings[i].getAttribute("datetime"));
	    timings[i].innerHTML = moment(arr).fromNow();
}

});
