$(document).ready(function() {
  $.ajax({
    url: window.location.origin + "/handlers/ajax/help/help-faq.php",
    type: "GET",
    data: {},
    dataType: "json",
    success: function(faqs) {
      let numFAQs = $(".card").length;
      for (let i = numFAQs; i < faqs.length; i++) {
        $(".container-fluid").append(
          `
      <div class="mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2 mb-4">
                  <div class="h5 font-weight-bold text-primary text-uppercase mb-1">
                    FAQ #` +
            (i + 1) +
            `
                  </div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800">
                    ` +
            faqs[i]["question"] +
            `
                  </div>
                </div>
              </div>
              <p>
              ` +
            faqs[i]["answer"] +
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
});