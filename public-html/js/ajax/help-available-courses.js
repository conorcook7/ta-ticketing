$(document).ready(function() {
  $.ajax({
    url: window.location.origin + "/handlers/ajax/help-available-courses.php",
    type: "GET",
    data: {},
    dataType: "json",
    success: function(courses) {
      let numLoadedCourses = $(".card").length;
      for (let i = numLoadedCourses; i < courses.length; i++) {
        console.log("working on " + (i + 1));
        $(".container-fluid").append(
          `<div class="card shadow mb-4">
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
});
