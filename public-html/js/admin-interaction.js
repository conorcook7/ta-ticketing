$("a.admin-js").click(function()
{
    // Get the src of the image
    var id = $(this).attr("id");

    // Send Ajax request to backend.php, with src set as "img" in the POST data
    $.post("../handlers/admin-handler.php", {"admin-selection": id});
});