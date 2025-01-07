$(document).ready(function () {
    $('#districtModal').on('show.bs.modal', function (e) {
        const districtId = $(e.relatedTarget).data('id');
        if (districtId) {
            $.ajax({
                url: '/explorer-center/php/district_details.php',
                type: 'GET',
                data: { id: districtId },
                success: function (response) {
                    $('#modalContent').html(response);
                },
                error: function () {
                    $('#modalContent').html('<p>Error loading district details.</p>');
                },
            });
        } else {
            $('#modalContent').html('<p>Invalid district ID.</p>');
        }
    });
});