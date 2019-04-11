function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}

$(document).ready(function() {
	// Set the max character count for the description
	let description = $(".description-form");
	$(".max-char-count").html(description.attr("maxlength"));
	description.on("change keyup mousedown paste", function() {
	  $(".char-count").html(description.val().length);
	});
  
	// Fade out the success alert.
	setTimeout(function() {
	  $(".alert-success").fadeOut("slow");
	}, 5 * 1000);
  });
  