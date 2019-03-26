$(document).ready(function(){
    $('.closeTickets').on('click', function(){
        bootbox.confirm({
            message: "Are you sure you would like to proceed?",
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm',
                    className: 'btn-success'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel',
                    className: 'btn-danger'
                }
            }
            // ,
            // callback: function (result) {
            //     console.log('This was logged in the callback: ' + result);
            // }
        });
    });
});

