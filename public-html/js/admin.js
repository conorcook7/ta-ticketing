/*!
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */

$(document).ready(function() {
  // Blacklist Form Toggle
  let blacklist = $("#blacklist-div");
  let blacklistId = $("#blacklist-id");
  let blacklistLabel = $("#blacklist-label");
  let blacklistEmail = $("#blacklist-email");
  let blacklistSubmit = $("#blacklist-submit");

  // Keep form from hiding
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

    // Scroll to top
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  // Catch the update button
  $(".blacklist-update-btn").on("click", function(event) {
    let row = event.target.parentElement.parentElement;
    let id = row.children[0].innerHTML;
    let email = row.children[1].children[0].innerHTML;

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

    // Scroll to top
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  /**
   * Hide/Show permissions on Admin Users Update page
   */
  let taDiv = $("#ta-creation");
  let permission = $("#permissionID");
  permission.on("change", function(event) {
    let value = permission.children("option:selected").html();
    if (value.includes("TA")) {
      taDiv.css({ display: "" });
    } else {
      taDiv.css({ display: "none" });
    }
  });
  // Set the initial state of the ta form div
  if (permission.length > 0) {
    if (
      permission
        .children("option:selected")
        .html()
        .includes("TA")
    ) {
      taDiv.css({ display: "" });
    } else {
      taDiv.css({ display: "none" });
    }
  }

  /**
   * This section will handle the bug report resolve div
   */
  let bugReportsDiv = $("#bug-reports-div");
  let bugReportIdInput = $("#bug-report-id");
  let bugReportTitleInput = $("#bug-report-title");

  // If the resolve button is clicked
  $(".bug-report-resolve-btn").on("click", function(event) {
    event.stopPropagation();
    bugReportsDiv.css({ display: "" });
    let row = event.target.parentElement.parentElement;
    let id = row.children[0].innerHTML;
    let user = row.children[1].innerHTML;
    let title = row.children[2].innerHTML;
    bugReportIdInput.val(id);
    bugReportTitleInput.val(title);
    $("#resolve-id").html(id);
    $("#resolve-user").html(user);
    $("#resolve-title").html(title);
  });

  // If the cancel button is clicked
  $("#resolve-cancel").on("click", function(event) {
    bugReportsDiv.css({ display: "none" });
    $("#resolve-description").val("");
  });

  // Keep the div open if clicked
  bugReportsDiv.on("click", function(event) {
    event.stopPropagation();
  });

  // Hide all forms on window click
  $("#content, #content-wrapper").on("click", function() {
    blacklist.css({ display: "none" });
  });
});
