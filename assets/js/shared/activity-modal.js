$(document).ready(function () {
    $('#dashboardFilter').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
        url: '../../actions/user/filter-dashboard.php',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize(), // POST
        success: function (res) {
            $('#activity-table-body').html(res.rows);
            $('#hours-table-head').html(res.hours_head);
            $('#hours-table-body').html(res.hours_body);
        }
        //how to refresh the chart after filtering? I need to call drawChart() again but it's in another file
         // Call the chart function to refresh it
    });
    });

    $('#exportCsv').on('click', function () {
        const query = $('#dashboardFilter').serialize();

        window.location.href =
            '../../actions/user/export-dashboard-csv.php?' + query;
    });


    $(".view-remark-btn").click(function () {
        let entryId = $(this).data("entry-id");
        $("#entry_id").val(entryId); // Store entry_id in hidden input

        $.ajax({
            url: "../../actions/employee/get_specific_activity.php",
            method: "GET",
            data: { entry_id: entryId },
            dataType: "json",
            success: function (response) {
                console.log("AJAX Success:", response); // Debugging log
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

    $("#remarkForm").submit(function (event) {
        console.log("Form Submitted!"); // Debugging log
        event.preventDefault(); // Prevent full-page reload/

        let formData = new FormData(this);

        $.ajax({
            url: "../../actions/employee/update-activity-remark.php",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                console.log("AJAX Response:", response); // Debugging log
                if (response.status === "success") {
                    alert("Remark saved successfully!");
                    $("#view-remark").modal("hide"); // Close modal
                    location.reload(); // Refresh page to reflect changes
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Server Response:", xhr.responseText);
            }
        });
    });




});
