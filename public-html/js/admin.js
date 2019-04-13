$(document).ready(function() {
  // Blacklist Form Toggle
  let blacklist = $("#blacklist-div");
  let blacklistId = $("#blacklist-id");
  let blacklistLabel = $("#blacklist-label");
  let blacklistEmail = $("#blacklist-email");
  let blacklistSubmit = $("#blacklist-submit");

  // Hide the form on window click
  $(window).on("click", function() {
    blacklist.css({ display: "none" });
  });

  // Show form on form click
  blacklist.on("click", function(event) {
    event.stopPropagation();
  });

  // Catch the add button
  $("#blacklist-add-btn").on("click", function(event) {
    // Show the blacklist form
    event.stopPropagation();
    blacklist.css({ display: "" });

    // Update the blacklist id input
    blacklistId.attr({
      required: "false",
      value: ""
    });

    // Update the blacklist label
    blacklistLabel.attr({ for: "blacklistEmail" });
    blacklistLabel.html("Email to blacklist");

    // Update the email input
    blacklistEmail.val("");
    blacklistEmail.attr({
      name: "blacklistEmail",
      placeholder: "Type email here..."
    });

    // Update the submit button
    blacklistSubmit.html("Add");
  });

  // Catch the update button
  $(".blacklist-update-btn").on("click", function(event) {
    let row = event.target.parentElement.parentElement;
    let id = row.children[0].innerHTML;
    let email = row.children[1].innerHTML;

    // Show the blacklist form
    event.stopPropagation();
    blacklist.css({ display: "" });

    // Update the blacklist id input
    blacklistId.attr({
      required: "true",
      value: id
    });

    // Update the blacklist label
    blacklistLabel.attr({ for: "blacklistEmailUpdate" });
    blacklistLabel.html("Email to update");

    // Update the email input
    blacklistEmail.val(email);
    blacklistEmail.attr({
      name: "blacklistEmailUpdate",
      placeholder: "Previous Email: " + email
    });

    // Update the submit button
    blacklistSubmit.html("Update");
  });
});
