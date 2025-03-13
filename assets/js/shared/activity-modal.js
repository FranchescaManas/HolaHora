$(document).ready(function () {
    $(".view-remark-btn").click(function () {
        let entryId = $(this).data("entry-id");
        // Send AJAX request
        $.ajax({
            url: "../../actions/employee/get_specific_activity.php",
            method: "GET",
            data: { entry_id: entryId },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#start-time").text(response.start_time);
                    $("#end-time").text(response.end_time || "Ongoing");
                    $("#duration").text(response.duration || "In Progress");
                    $("#remarks").val(response.remarks);
                } else {
                    console.error("No data found for this activity.");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Server Response:", xhr.responseText);
            }
        });
    });
});
