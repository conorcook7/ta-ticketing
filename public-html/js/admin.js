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

  /**
   * This section will handle the user update div
   */
  let updateUserDiv = $("#update-user-div");
  let firstNameInput = $("#update-first-name");
  let lastNameInput = $("#update-last-name");
  let emailInput = $("#update-email");
  let permissionIDInput = $("#update-permission-id");
  let userIDInput = $("#update-user-id");
  let row = null;

  updateUserDiv.on("click", function(event) {
    event.stopPropagation();
  });

  // Hide/Unhide the TA div
  permissionIDInput.on("change", function(event) {
    let permissionId = event.target.value;
    let permissionOptions = permissionIDInput.children();
    for (let i = 0; i < permissionOptions.length; i++) {
      let upperCaseHTML = permissionOptions[i].innerHTML.toUpperCase();
      if (permissionOptions[i].value === permissionId) {
        permissionOptions[i].setAttribute("selected", "selected");
        if (upperCaseHTML === "TA") {
          $("#ta-creation").css({ display: "" });
        } else {
          $("#ta-creation").css({ display: "none" });
        }

        // Update data if create user
        if (upperCaseHTML === "CREATE USER") {
          userIDInput.val("-1");
        } else {
          userIDInput.val(row.children[0].innerHTML);
        }

        // Update the text and color of the submit button
        styleUpdateButton();
      } else {
        permissionOptions[i].removeAttribute("selected");
      }
    }
  });

  $(".update-user-btn").on("click", function(event) {
    event.stopPropagation(); // Stop the div from hiding
    updateUserDiv.css({ display: "" }); // Display the div

    // Get the row contents
    row = event.target.parentElement.parentElement;
    let userId = row.children[0].innerHTML;
    let firstName = row.children[1].innerHTML;
    let lastName = row.children[2].innerHTML;
    let email = row.children[3].innerHTML;
    let permission = row.children[4].innerHTML;

    // Decide the permission to display
    let permissionOptions = permissionIDInput.children();
    for (let i = 0; i < permissionOptions.length; i++) {
      if (permissionOptions[i].innerHTML == permission) {
        permissionOptions[i].setAttribute("selected", "selected");
        if (permissionOptions[i].innerHTML.toUpperCase() === "TA") {
          $("#ta-creation").css({ display: "" });
          $.ajax({
            url: window.location.origin + "/handlers/ajax/get-ta-info.php",
            type: "GET",
            data: {
              taID: userId
            },
            success: function(json) {
              $("#startTime").val(json["startTime"]);
              $("#startTime").attr({ value: json["startTime"] });
              $("#endTime").val(json["endTime"]);
              $("#endTime").attr({ value: json["endTime"] });
              let courses = $("#courseId").children();
              for (let i = 0; i < courses.length; i++) {
                if (courses[i].value === json["courseId"]) {
                  courses[i].setAttribute("selected", "selected");
                } else {
                  courses[i].removeAttribute("selected");
                }
              }
            }
          });
        } else {
          $("#ta-creation").css({ display: "none" });
        }
      } else {
        permissionOptions[i].removeAttribute("selected");
      }
    }

    // Update the field values
    firstNameInput.val(firstName);
    firstNameInput.attr({ value: firstName });
    firstNameInput.attr({ placeholder: "Previously: " + firstName });

    lastNameInput.val(lastName);
    lastNameInput.attr({ value: lastName });
    lastNameInput.attr({ placeholder: "Previously: " + lastName });

    emailInput.val(email);
    emailInput.attr({ value: email });
    emailInput.attr({ placeholder: "Previously: " + email });

    userIDInput.val(userId);
    userIDInput.attr({ value: userId });

    // Update the button style
    styleUpdateButton();

    // Scroll to top
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $("#user-add-btn").on("click", function(event) {
    event.stopPropagation(); // Stop the div from hiding
    updateUserDiv.css({ display: "" }); // Display the div

    // Decide the permission to display
    let permissionOptions = permissionIDInput.children();
    for (let i = 0; i < permissionOptions.length; i++) {
      if (permissionOptions[i].innerHTML.toUpperCase() === "CREATE USER") {
        permissionOptions[i].setAttribute("selected", "selected");
        if (permissionOptions[i].innerHTML.toUpperCase() === "TA") {
          $("#ta-creation").css({ display: "" });
        } else {
          $("#ta-creation").css({ display: "none" });
        }
      } else {
        permissionOptions[i].removeAttribute("selected");
      }
    }

    // Update the field values
    firstNameInput.val("");
    firstNameInput.attr({ value: "" });
    lastNameInput.val("");
    lastNameInput.attr({ value: "" });
    emailInput.val("");
    emailInput.attr({ value: "" });
    userIDInput.val("-1");
    userIDInput.attr({ value: "-1" });

    // Update the text and color of the submit button
    let submitButton = $("#update-submit");
    submitButton.removeClass("btn-primary");
    submitButton.removeClass("btn-danger");
    submitButton.addClass("btn-success");
    submitButton.html("Add User");

    // Scroll to top
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $("#update-cancel").on("click", function(event) {
    updateUserDiv.css({ display: "none" });
  });

  function styleUpdateButton() {
    // Update the text and color of the submit button
    let submitButton = $("#update-submit");

    if (upperCaseHTML === "DELETE USER") {
      // update the button
      submitButton.removeClass("btn-primary");
      submitButton.removeClass("btn-success");
      submitButton.addClass("btn-danger");
      submitButton.html("Delete User");
    } else if (upperCaseHTML === "CREATE USER") {
      submitButton.removeClass("btn-primary");
      submitButton.removeClass("btn-danger");
      submitButton.addClass("btn-success");
      submitButton.html("Add User");
    } else {
      submitButton.removeClass("btn-success");
      submitButton.removeClass("btn-danger");
      submitButton.addClass("btn-primary");
      submitButton.html("Finish Editing");
    }
  }

  // KEEP AT THE BOTTOM
  // Hide all forms on window click
  $("#content, #content-wrapper").on("click", function() {
    blacklist.css({ display: "none" });
  });
});
