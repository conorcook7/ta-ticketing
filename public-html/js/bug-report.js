/*!
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */

$(document).ready(function() {
  // Set the max character count for the description
  let description = $("#description");
  $("#max-char-count").html(description.attr("maxlength"));
  description.on("change keyup mousedown paste", function() {
    $("#char-count").html(description.val().length);
  });
});
