// On window close, reload, or back.
window.onunload = function(event) {
  console.log("window unloading");
  $.ajax({
    url: window.location.origin + "/handlers/user-update.php",
    type: "POST",
    data: {
      unload: true
    },
    dataType: "json",
    success: function(data) {
      console.log("Data: " + JSON.stringify(data));
    },
    error: function(request, error) {
      console.log("Request: " + JSON.stringify(request));
    }
  });
};

// Update the user status every interval
setInterval(function() {
  console.log("Sending update");
  $.ajax({
    url: window.location.origin + "/handlers/user-update.php",
    type: "POST",
    data: {
      unload: false
    },
    dataType: "json",
    success: function(data) {
      console.log("Data: " + JSON.stringify(data));
      if (data["reset"] === false) {
        //window.location.replace(data["redirect"]);
      }
    },
    error: function(request, error) {
      console.log("Request: " + JSON.stringify(request));
    }
  });
}, 5000);
