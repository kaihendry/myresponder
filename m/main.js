window.addEventListener('load', function() {
	var checkboxes = document.querySelectorAll('input[type="checkbox"]');
	for (var i = 0; i < checkboxes.length; i++) {
		checkboxes[i].addEventListener("click", function( event ) {
			var that = this;
			var id = this.getAttribute('id');
			var r = new XMLHttpRequest();
			r.open("POST", "arm.php", true);
			r.onreadystatechange = function () {
				if (r.readyState != 4 || r.status != 200) return;
				var status = JSON.parse(r.responseText);
				if (status.unarmed == id) {
					console.log("unarmed", id, that.checked);
					that.checked = false;
				} else {
					console.log("armed", id, that.checked);
					that.checked = true;
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
