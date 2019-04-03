$(document).ready(function() {
  $.ajax({
    url:
      window.location.origin + "/handlers/ajax/help/help-available-courses.php",
    type: "GET",
    data: {},
    dataType: "json",
    success: function(courses) {
      let numLoadedCourses = $(".card").length;
      for (let i = numLoadedCourses; i < courses.length; i++) {
        $(".container-fluid").append(
          `<div class="card shadow mb-4 ac">
                  <div class="card-header py-3">
                    <h1 class="h5 m-0 font-weight-bold text-primary">` +
            courses[i]["course_name"].toUpperCase() +
            `   </h1>
                  </div>
                <div class="card-body">
                <p>` +
            courses[i]["course_description"] +
            `</p>
                 </div>
                </div>`
        );
      }
    },
    error: function(request, error) {}
  });

  // Search functionality
  $("#ac-search").on("change keyup paste", function() {
    let searchPhrase = $(this)
      .val()
      .toLowerCase();

    let availableCourses = $(".ac");
    for (let i = 0; i < availableCourses.length; i++) {
      let ac = availableCourses[i];
      let style = ac.innerText.toLowerCase().includes(searchPhrase)
        ? ""
        : "none";
      ac.style.display = style;
    }
  });
});
