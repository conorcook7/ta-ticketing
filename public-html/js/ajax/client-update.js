/*!
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */

$(document).ready(function() {
  // Update function
  function sendClientUpdate(unload) {
    $.ajax({
      url: window.location.origin + "/handlers/ajax/client-update.php",
      type: "POST",
      data: {
        unload: unload
      },
      dataType: "json",
      success: function(data) {
        if (data["reset"] === false) {
          window.location.replace(data["redirect"]);
        }
      },
      error: function(request, error) {}
    });
  }

  // On window close, reload, or back.
  window.addEventListener("beforeunload unload", function(event) {
    sendClientUpdate(true);
  });

  // Update the user status every interval
  setInterval(function() {
    sendClientUpdate(false);
  }, 5 * 60 * 1000);

  // Update the page on load
  sendClientUpdate(false);

  // Fade out the success alert.
  setTimeout(function() {
    $(".alert-success").fadeOut("slow");
  }, 5 * 1000);
});
