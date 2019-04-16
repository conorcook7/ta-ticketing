$(document).ready(function() {
  // Figure out relative pathing
  let numPaths = window.location.pathname.split("/").length - 1;
  let ajaxPath = "";
  for (let i = 0; i < numPaths; i++) {
    ajaxPath += "../";
  }
  ajaxPath += "handlers/ajax/";

  /**
   * Define all of the table AJAX calls
   */
  let allTicketsTable = $("#all-tickets-table").DataTable({
    ajax: ajaxPath + "all-tickets-table-handler.php",
    preDrawCallback: canRedrawTable,
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
    preDrawCallback: canRedrawTable,
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
    preDrawCallback: canRedrawTable,
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
    preDrawCallback: canRedrawTable,
    columns: [
      { data: "queue" },
      { data: "studentName" },
      { data: "nodeInfo" },
      { data: "course" },
      { data: "ticketDescription" },
      { data: "status" }
    ]
  });

  // Student Dashboard
  let userOpenTicketsTable = $("#user-open-tickets-table").DataTable({
    ajax: ajaxPath + "users-open-tickets-table-handler.php",
    preDrawCallback: canRedrawTable,
    columns: [
      { data: "queue" },
      { data: "node" },
      { data: "courseName" },
      { data: "queueTime" },
      { data: "ticketDescription" },
      { data: "action" }
    ]
  });

  let userClosedTicketsTable = $("#user-closed-tickets-table").DataTable({
    ajax: ajaxPath + "users-closed-tickets-table-handler.php",
    preDrawCallback: canRedrawTable,
    columns: [
      { data: "ticketNumber" },
      { data: "ticketCreator" },
      { data: "ticketCloser" },
      { data: "courseName" },
      { data: "dateSolved" },
      { data: "ticketDescription" },
      { data: "closingDescription" },
      { data: "action" }
    ]
  });

  // Initialize the generic data tables
  $("#dataTable").DataTable();
  $(".generic-data-table").DataTable();

  /**
   * Closing description form for TA/Admin tables
   */
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

  /**
   * Reload the data for all tables
   */
  allTicketsTable.ajax.reload();
  closedTicketsTable.ajax.reload();
  openTicketsTable.ajax.reload(showClosingForm);
  taOpenTicketsTable.ajax.reload(showClosingForm);
  userOpenTicketsTable.ajax.reload();
  userOpenTicketsTable.ajax.reload();
  userClosedTicketsTable.ajax.reload();

  /**
   * Reload the tables after every interval
   */
  setInterval(function() {
    allTicketsTable.ajax.reload();
    closedTicketsTable.ajax.reload();
    openTicketsTable.ajax.reload(showClosingForm);
    taOpenTicketsTable.ajax.reload(showClosingForm);
    userOpenTicketsTable.ajax.reload();
    userOpenTicketsTable.ajax.reload();
    userClosedTicketsTable.ajax.reload();
  }, 30 * 1000);

  /**
   * Function to toggle the form based on the buttons in the class
   */
  function showClosingForm() {
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

  /**
   * Do not allow the tables to be redrawn if a modal is open
   */
  function canRedrawTable() {
    let modals = document.getElementsByClassName("modal");
    for (let i = 0; i < modals.length; i++) {
      let modal = modals[i];
      if (modals[i].attributes.class.value.includes("show") === true) {
        return false;
      }
    }
    return true;
  }
});
