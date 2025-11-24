$(document).ready(function () {
    $("#correct_btn").click(function () {
        const selectedRadio = $('input[name="correction_row"]:checked')[0];
        if (selectedRadio) {
            const entryId = selectedRadio.id;
            console.log("Selected Entry ID:", entryId);
            // Show the modal manually
            const modal = new bootstrap.Modal(document.getElementById('correction-modal'));
            modal.show();
            // Set hidden input for form submission
            $("#entry_id").val(entryId);

            // Fetch activity details via AJAX
            $.ajax({
                url: "../../actions/employee/get_specific_activity.php",
                method: "GET",
                data: { entry_id: entryId },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        console.log(response);
                        $("#activity").text(response.activity_name);
                        $("#start-time").text(response.start_time);
                        // response.end_time = "14:30:45"
                        $("#end-time").val(response.end_time);

                        $("#duration").text(response.duration);
                        $("#remarks").val(response.remarks);
                        $("#manager").text(response.manager);
                    } else {
                        console.error("No data found for this activity.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    console.log("Server Response:", xhr.responseText);
                }
            });

        } else {
            alert("Please select an activity to correct.");
        }
    });



    // Optional: handle save button inside modal
    $("#save_correction").click(function () {
    const entryId = $('input[name="correction_row"]:checked').val();
    console.log("entryid", entryId);

    const remarks = $("#remarks").val();
    const end_time = $("#end-time").val(); // should be HH:MM:SS if seconds are needed
    const requested_date = new Date().toISOString().slice(0, 10); // YYYY-MM-DD

    $.ajax({
        url: "../../actions/employee/update_time_correction.php",
        method: "POST",
        dataType: "json",
        data: { 
            entry_id: entryId, 
            remarks: remarks,
            end_time: end_time,
            requested_date: requested_date
        },
        success: function(response) {
            if(response.status === "success"){
                $("#correction-modal").modal('hide');
                alert(response.message);
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Save Error:", status, error);
            console.log("Raw Response:", xhr.responseText);
        }
    });
});


});