$(document).ready(function() {
  // Get the description textarea
  let description = $("#closing-description");

  // Set the max character for the character counter
  $("#max-char-count").html(description.attr("maxlength"));

  // Set the character counter to update when the description is changed
  description.on("change keyup paste mousedown", function() {
    $("#char-count").html($(this).val().length);
  });

  // Setup the form toggle display
  let form = $("#ta-close"); // Get the closing form with jQuery
  form.css({ display: "none" }); // Hide the form initially

  // Hide the form on window click
  $(window).on("click", function() {
    form.css({ display: "none" });
    $("#my-open-ticket-id").val(null);
    $("#my-closer-user-id").val(null);
  });

  // Stop the form from hiding if the form is being clicked
  form.on("click", function(event) {
    event.stopPropagation();
  });
});
