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
    processing: true,
    columns: [
      { data: "id" },
      { data: "studentName" },
      { data: "nodeNumber" },
      { data: "course" },
      { data: "status" },
      { data: "ticketDescription"}
    ]
  });

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

  // All of the tables ajax calls here
  let openTicketsTable = $("#open-tickets-table").DataTable({
    ajax: ajaxPath + "open-tickets-table-handler.php",
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
  
  $("#dataTable").DataTable();
  // Add more tables here
  // TODO: Add more tables

  // Reload the data for all tables
  allTicketsTable.ajax.reload();
  closedTicketsTable.ajax.reload();
  openTicketsTable.ajax.reload();
  // TODO: Add more table reloads her
});
