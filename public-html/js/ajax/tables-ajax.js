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

  $("#dataTable").DataTable();
  $(".generic-data-table").DataTable();
  // Add more tables here
  // TODO: Add more tables

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
    setFormToggle();
    // Reload 30 seconds after it has finished loading
    setTimeout(function() {
      taOpenTicketsTable.ajax.reload(callbackTaOpenTicketsTable);
    }, 30 * 1000);
  }

  // Reload the My Open Tickets table for TAs
  taOpenTicketsTable.ajax.reload(callbackTaOpenTicketsTable);

  /**
   * Callback function for recursively updating the "My Open Tickets" table for TAs
   */
  function callbackTaOpenTicketsTable() {
    // Toggle the closing form
    setFormToggle();
    // Reload 30 seconds after it has finished loading
    setTimeout(function() {
      taOpenTicketsTable.ajax.reload(callbackTaOpenTicketsTable);
    }, 30 * 1000);
  }

  /**
   * Function to toggle the form based on the buttons in the class
   */
  function setFormToggle() {
    $(".toggle-close-form").on("click", function(event) {
      event.stopPropagation();
      $("#ta-close").css({ display: "" });
      let inputs = event.target.children;
      let openTicketId = inputs[0].value;
      let closerUserId = inputs[1].value;
      $("#my-open-ticket-id").val(openTicketId);
      $("#my-closer-user-id").val(closerUserId);
    });
  }
});
