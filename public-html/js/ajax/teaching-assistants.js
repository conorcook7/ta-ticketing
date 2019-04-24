/*!
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */

$(document).ready(function() {
  $.ajax({
    url:
      window.location.origin + "/handlers/ajax/teaching-assistants-handler.php",
    type: "GET",
    data: {},
    dataType: "json",
    success: function(TAs) {
      let numLoadedTAs = $(".card").length;
      for (let i = numLoadedTAs; i < TAs.length; i++) {
        console.log(TAs[i]["image_URL"]);
        let imageDiv =
          TAs[i]["image_URL"] == ""
            ? ""
            : '<img src="' +
              TAs[i]["image_URL"] +
              '" class="rounded-circle ml-2 mr-4"/>';
        $(".container-fluid").append(
          `
            <div class="card shadow mb-4 ta">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between mr-4">
                        <span class="h4 m-0 font-weight-bold text-primary">` +
            TAs[i]["name"] +
            `</span>
                        <span class="h4 m-0 font-weight-bold text-primary">` +
            TAs[i]["course_number"] +
            `</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">` +
            imageDiv +
            `<div class="ml-2 mt-2 d-inline-block">
                            <div class="h5 text-gray-800">
                                <span class="text-gray-600">Contact: </span>` +
            TAs[i]["email"] +
            `</div>
                            <div class="h5 text-gray-800">
                                <span class="text-gray-600">Course: </span>` +
            TAs[i]["course_name"] +
            `</div>
                        </div>
                        <div class="h5 text-gray-800">
                            <p class="my-4 mx-2">` +
            TAs[i]["course_description"] +
            `</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-gray-800">
                        <p class="text-right text-gray-600">TA Since: ` +
            TAs[i]["create_date"] +
            `</p>
                    </div>
                </div>
            </div>
        `
        );
      }
    },
    error: function(request, error) {}
  });

  // Search functionality
  $("#ta-search").on("change keyup paste", function() {
    let searchPhrase = $(this)
      .val()
      .toLowerCase();

    let teachingAssistants = $(".ta");
    for (let i = 0; i < teachingAssistants.length; i++) {
      let ta = teachingAssistants[i];
      let style = ta.innerText.toLowerCase().includes(searchPhrase)
        ? ""
        : "none";
      ta.style.display = style;
    }
  });
});
