bootbox.confirm({
    message: "This is a confirm with custom button text and color! Do you like it?",
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