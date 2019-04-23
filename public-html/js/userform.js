/*!
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */

$(document).ready(function() {
  let problemDescription = $("#problem_description");
  $("#charNum").html(problemDescription.val().length);
  $("#maxLength").html(problemDescription.attr("maxlength"));
  problemDescription.on("change keyup paste", function() {
    $("#charNum").html(problemDescription.val().length);
  });
});
