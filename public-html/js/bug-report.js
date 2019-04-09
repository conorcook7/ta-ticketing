$(document).ready(function() {
  // Set the max character count for the description
  let description = $("#description");
  $("#max-char-count").html(description.attr("maxlength"));
  description.on("change keyup mousedown paste", function() {
    $("#char-count").html(description.val().length);
  });

  // Fade out the success alert.
  setTimeout(function() {
    $(".alert-success").fadeOut("slow");
  }, 5 * 1000);
});
