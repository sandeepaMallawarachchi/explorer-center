$(document).ready(function () {
    $('#blogModal').on('show.bs.modal', function (e) {
        const blogId = $(e.relatedTarget).data('id');
        if (blogId) {
            $.ajax({
                url: '//blogModal.php',
                type: 'GET',
                data: { id: blogId },
                success: function (response) {
                    $('#modalContent').html(response);
                },
                error: function () {
                    $('#modalContent').html('<p>Error loading blog details.</p>');
                },
            });
        } else {
            $('#modalContent').html('<p>Invalid blog ID.</p>');
        }
    });
});