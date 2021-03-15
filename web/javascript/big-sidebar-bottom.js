/* This is Script for Mouse click to Social Share Icon Display/Hide */
//JavaScript code should be executed in "strict mode"
"use strict";
$(document).ready(function () {
	$("#share_icon", "#ss_bar").on("click", function () {
		// This is Function for Share Icon Button Click
		if ($("#social_icon", "#ss_bar").css("display") === "none") {

			$("#social_icon", "#ss_bar").css("display", "block");
			$("#social_icon", "#ss_bar").addClass("slideBottom");
			$("#share_icon i", "#ss_bar").addClass("fa-times").removeClass("fa-share-alt");

		} else {
			$("#social_icon", "#ss_bar").css("display", "none");
			$("#share_icon i", "#ss_bar").addClass("fa-share-alt").removeClass("fa-times");
		}
		/* This is script javascript load */
		var script = document.createElement("script");
		script.type = "text/javascript";
		script.src = "js/watch-time.js";
		document.getElementsByTagName("head")[0].appendChild(script);
		return false;

	});
	return false;
});
// Function End