$(document).ready(function () {
    $(".view-btn").on("click", function () {
        const entryId = $(this).data("entry");
        const status = $(this).data("status");
        console.log(entryId);
        // Fetch activity details via AJAX
        $.ajax({
            url: "../../actions/manager/get_specific_activity.php",
            method: "GET",
            data: { entry_id: entryId },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log(response);
                    

                    $("#employee-name").text(response.name);
                    $("#activity").text(response.activity_name);
                    $("#requested-end-time").val(response.requested_end_time);
                    $("#end-time").text(response.end_time);
                    $("#duration").text(response.duration);
                    $("#remarks").val(response.remarks);
                    $("#request_id").val(response.request_id);
                   
                    if (response.requested_start_time) {

                        // Show editable input
                        $("#requested-start-time")
                            .val(response.requested_start_time)
                            .prop("disabled", false)
                            .show();

                        $("#start-time-label").show();
                        $("#start-time")
                            .text(response.start_time)
                            .show();

                    } else {
                        console.log(response)
                         $("#requested-start-time")
                            .val(response.start_time)
                            .prop("disabled", true)
                            .show();
                        $("#start-time-label").hide();
                        $("#start-time").hide();
                        

                    }
                    if (status === "" || status === null || typeof status === "undefined") {
                        // pending → show buttons
                        $("#approval-buttons").show();
                        $("#status-label").hide();
                    } else {
                        console.log("Hide buttons");
                        $("#approval-footer").hide();
                    }
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


    function update_request(status) {

        const start_time = $("#requested-start-time").val() || null; // Get the value of the requested start time, or null if it doesn't exist
        const end_time = $("#requested-end-time").val();
        const request_id = $("#request_id").val();

        console.log("start_time:", start_time);
        console.log("end_time:", end_time);
        console.log("request_id:", request_id);
        console.log("status:", status);
        $.ajax({
            url: "../../actions/manager/update_time_correction.php",
            method: "POST",
            dataType: "json",
            data: {
                start_time: start_time,
                end_time: end_time,
                request_id: request_id,
                status: status
            },
            success: function (response) {
                if (response.status === "success") {
                    $("#view-manager-correction").modal('hide');

                    console.log("data:", response.data);
                    // alert(response.status);
                    // console(response);
                    // location.reload(); // optional refresh
                } else {
                    alert("Error: " + response);
                }
                location.reload(); 
            },
            error: function (xhr, status, error) {
                console.error("Save Error:", status, error);
                console.log("Raw Response:", xhr.responseText);
            }
        });
    }


    $("#accept_correction").click(function () {
        update_request(1);
    });

    $("#reject_correction").click(function () {
        update_request(0);
    });



});

