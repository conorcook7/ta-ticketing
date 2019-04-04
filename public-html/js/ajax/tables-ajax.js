$(document).ready(function() {
  // Figure out relative pathing
  let numPaths = window.location.pathname.split("/").length - 1;
  let ajaxPath = "";
  for (let i = 0; i < numPaths; i++) {
    ajaxPath += "../";
  }
  ajaxPath += "handlers/ajax/";

  // All of the tables ajax calls here
  let closedTicketsTable = $("#closed-tickets-table").DataTable({
    ajax: ajaxPath + "closed-tickets-table-handler.php",
    processing: true,
    columns: [
      { data: "studentName" },
      { data: "teachingAssistant" },
      { data: "course" },
      { data: "ticketDescription" },
      { data: "closingRemarks" },
      { data: "status" }
    ]
  });

  // Add more tables here
  // TODO: Add more tables

  // Reload the data for all tables
  closedTicketsTable.ajax.reload();
  // TODO: Add more table reloads her
});
