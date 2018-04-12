require('bootstrap');



$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
})