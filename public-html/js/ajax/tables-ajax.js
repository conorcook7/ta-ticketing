$(document).ready(function() {
  // Figure out relative pathing
  let numPaths = window.location.pathname.split("/").length - 1;
  let ajaxPath = "";
  for (let i = 0; i < numPaths; i++) {
    ajaxPath += "../";
  }
  ajaxPath += "handlers/ajax/";

  // All of the tables ajax calls here
  let allTicketsTable = $("#all-tickets-table").DataTable({
    ajax: ajaxPath + "all-tickets-table-handler.php",
    columns: [
      { data: "id" },
      { data: "studentName" },
      { data: "nodeNumber" },
      { data: "course" },
      { data: "status" },
      { data: "ticketDescription" }
    ]
  });

  // All of the tables ajax calls here
  let closedTicketsTable = $("#closed-tickets-table").DataTable({
    ajax: ajaxPath + "closed-tickets-table-handler.php",
    columns: [
      { data: "studentName" },
      { data: "teachingAssistant" },
      { data: "course" },
      { data: "ticketDescription" },
      { data: "closingRemarks" },
      { data: "status" }
    ]
  });

  // All of the tables ajax calls here
  let openTicketsTable = $("#open-tickets-table").DataTable({
    ajax: ajaxPath + "open-tickets-table-handler.php",
    columns: [
      { data: "queue" },
      { data: "studentName" },
      { data: "nodeInfo" },
      { data: "course" },
      { data: "ticketDescription" },
      { data: "status" }
    ]
  });

  let taOpenTicketsTable = $("#ta-open-tickets-table").DataTable({
    ajax: ajaxPath + "ta-open-tickets-table-handler.php",
    columns: [
      { data: "queue" },
      { data: "studentName" },
      { data: "nodeInfo" },
      { data: "course" },
      { data: "ticketDescription" },
      { data: "status" }
    ]
  });

  // Initialize the generic data tables
  $("#dataTable").DataTable();
  $(".generic-data-table").DataTable();

  // Get the description textarea
  let description = $("#closing-description");

  // Set the max character for the character counter
  $("#max-char-count").html(description.attr("maxlength"));

  // Set the character counter to update when the description is changed
  description.on("change keyup paste mousedown", function() {
    $("#char-count").html($(this).val().length);
  });

  // Setup the form toggle display
  let formDiv = $("#toggle-close-ticket"); // Get the closing form with jQuery
  formDiv.css({ display: "none" }); // Hide the form initially

  // Hide the form on window click
  $(window).on("click", function() {
    formDiv.css({ display: "none" });
    $("#my-open-ticket-id").val(null);
    $("#my-closer-user-id").val(null);
  });

  // Stop the form from hiding if the form is being clicked
  formDiv.on("click", function(event) {
    event.stopPropagation();
  });

  // Reload the data for all tables
  allTicketsTable.ajax.reload();
  closedTicketsTable.ajax.reload();

  // Reload all open tickets table
  openTicketsTable.ajax.reload(callbackOpenTicketsTable);
  /**
   * Callback function for recursively updating the "All Open Tickets" table.
   */
  function callbackOpenTicketsTable() {
    // Toggle the closing form
    toggleForm();
    // Reload 30 seconds after it has finished loading
    setTimeout(function() {
      openTicketsTable.ajax.reload(callbackOpenTicketsTable);
    }, 30 * 1000);
  }

  // Reload the My Open Tickets table for TAs
  taOpenTicketsTable.ajax.reload(callbackTaOpenTicketsTable);
  /**
   * Callback function for recursively updating the "My Open Tickets" table for TAs
   */
  function callbackTaOpenTicketsTable() {
    // Toggle the closing form
    toggleForm();
    // Reload 30 seconds after it has finished loading
    setTimeout(function() {
      taOpenTicketsTable.ajax.reload(callbackTaOpenTicketsTable);
    }, 30 * 1000);
  }

  /**
   * Function to toggle the form based on the buttons in the class
   */
  function toggleForm() {
    $(".toggle-close-form").on("click", function(event) {
      event.stopPropagation();
      $("#toggle-close-ticket").css({ display: "" });
      let inputs = event.target.children;
      let openTicketId = inputs[0].value;
      let closerUserId = inputs[1].value;
      $("#open-ticket-id").val(openTicketId);
      $("#closer-user-id").val(closerUserId);
      $("html, body").animate({ scrollTop: 0 }, "slow");
    });
  }
});
