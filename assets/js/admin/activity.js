$(document).ready(function(){
    console.log("jquery loaded");
    // Edit Mode
    $(document).on('click', '.edit-activity-btn', function(){
        console.log("clciked");

        var row = $(this).closest('tr');
        var nameCell = row.find('.activity-name');
        var checkbox = row.find('.form-check-input');

        var currentName = nameCell.text().trim();

        // Replace text with input
        nameCell.html('<input type="text" class="form-control form-control-sm activity-input" value="'+currentName+'">');
        checkbox.prop('disabled', false);

        // Toggle buttons
        row.find('.edit-activity-btn').addClass('d-none');
        row.find('.save-activity-btn').removeClass('d-none');
    });

    // Save Mode
    $(document).on('click', '.save-activity-btn', function(){
        var row = $(this).closest('tr');
        var activity_id = row.data('id');
        var input = row.find('.activity-input');
        var newName = input.val().trim();
        var isBillable = row.find('.form-check-input').is(':checked') ? 1 : 0;

        if(newName === ''){
            alert('Activity name cannot be empty!');
            return;
        }

        // AJAX Request
        $.ajax({
            url: '../../actions/admin/update-activity.php',
            type: 'POST',
            data: {
                activity_id: activity_id,
                activity_name: newName,
                isBillable: isBillable
            },
            success: function(response){
                if(response.trim() === "success"){
                    // Revert to normal view
                    row.find('.activity-name').text(newName);
                    row.find('.form-check-input').prop('disabled', true);

                    row.find('.edit-activity-btn').removeClass('d-none');
                    row.find('.save-activity-btn').addClass('d-none');
                } else {
                    alert('Failed to update activity.');
                }
            },
            error: function(){
                alert('Request failed. Please try again.');
            }
        });
    });

});
