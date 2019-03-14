$(".dropdown-item").on("click", function() {
    $("#dropdownMenuButton").val($(this).text());
    $("#dropdownMenuButton").html($(this).text());
});