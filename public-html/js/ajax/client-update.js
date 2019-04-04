// On window close, reload, or back.
window.addEventListener("beforeunload", function(event) {
  $.ajax({
    url: window.location.origin + "/handlers/ajax/client-update.php",
    type: "POST",
    data: {
      unload: true
    },
    dataType: "json",
    success: function(data) {
      if (data["reset"] === false) {
        window.location.replace(data["redirect"]);
      }
    },
    error: function(request, error) {}
  });
});

// Update the user status every interval
setInterval(function() {
  $.ajax({
    url: window.location.origin + "/handlers/ajax/client-update.php",
    type: "POST",
    data: {
      unload: false
    },
    dataType: "json",
    success: function(data) {
      if (data["reset"] === false) {
        window.location.replace(data["redirect"]);
      }
    },
    error: function(request, error) {}
  });
}, 1 * 60 * 1000);
