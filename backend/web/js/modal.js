$(function () {
    // When the "Create Project" button is clicked
    $('#create-project-button').on('click', function () {
        // Fetch the content via AJAX
        $.ajax({
            url: $(this).attr('value'),
            type: 'GET',
            beforeSend: function () {
                // Show a loading spinner before making the request
                $('#create-project-content').html('<div class="text-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            },
            success: function (data) {
                // Inject the form into the modal content
                $('#create-project-content').html(data);
                // Show the modal after the content is loaded
                $('#create-project-modal').modal('show');
            },
            error: function () {
                // Show an error message if the request fails
                $('#create-project-content').html('<div class="text-danger text-center p-3">Failed to load content. Please try again.</div>');
            }
        });
    });
});
