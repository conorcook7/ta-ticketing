$(document).ready(function() {
  console.log(window.origin);
  // All of the tables ajax calls here
  let closedTicketsTable = $("#closed-tickets-table").DataTable({
    ajax: window.origin + "/handlers/ajax/closed-tickets-table-handler.php",
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

  // Reload the data
  closedTicketsTable.ajax.reload();
});
