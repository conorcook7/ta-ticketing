$(document).ready(function(){
    $('.closeTickets').on('click', function(){
        bootbox.confirm({
            message: "This is a confirm with custom button text and color! Do you like it?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                console.log('This was logged in the callback: ' + result);
            }
        });
        // bootbox.confirm({
        //     message: "Are you sure you would like to proceed?",
        //     buttons: {
        //         confirm: {
        //             label: '<i class="fa fa-check"></i> Confirm',
        //             className: 'btn-success'
        //         },
        //         cancel: {
        //             label: '<i class="fa fa-times"></i> Cancel',
        //             className: 'btn-danger'
        //         }
        //     }
        //     // ,
        //     // callback: function (result) {
        //     //     console.log('This was logged in the callback: ' + result);
        //     // }
        // });
    });
});

