$(document).ready(
    window.onbeforeunload = function() {
        return "Do you really want to leave?";
    }
);