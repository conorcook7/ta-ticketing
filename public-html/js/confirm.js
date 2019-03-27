    function doConfirm(){
    // $('.closeTickets').on('click', function(){
        $('.myOpenTicketsTable').submit(function(e) {
            e.preventDefault();
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
}

$(document).ready(function() {
    setTimeout(function(){ doConfirm() }, 100);    
  });