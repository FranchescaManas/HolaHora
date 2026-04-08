$(document).ready(function () {
    $("#correct_btn").click(function () {
        const isShiftActive = !!Number($("#shift").text());

        console.log(isShiftActive);
        const selectedRadio = $('input[name="correction_row"]:checked')[0];
        if (selectedRadio) {
            const entryId = selectedRadio.dataset.entry;
            console.log("entryid: ", entryId);
            const $radio = $("input[name='correction_row']:checked");

            const $row = $radio.closest("tr");
            const $rows = $("#activity-tbody").children("tr");

            const rowIndex = $rows.index($row);
            const totalRows = $rows.length;

            const isFirstRow = rowIndex === 0;
            const isLastRow  = rowIndex === totalRows - 1;

            // console.log("rowIndex:", rowIndex);
            // console.log("isFirst:", isFirstRow);
            // console.log("isLast:", isLastRow);

            // 3. TOGGLE START TIME EDITABILITY
            if ((isFirstRow || isLastRow) && !isShiftActive) {
                // editable
                $("#start-time-text").addClass("d-none");
                $("#start-time-input").removeClass("d-none");
                $("#start-time-input").prop("disabled", false);


            } else {
                // read-only
                $("#start-time-text").removeClass("d-none");
                $("#start-time-input").addClass("d-none");
                $("#start-time-input").prop("disabled", true);
            }



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
                        console.log("is row editable: ", isFirstRow);
                        $(".activity").text(response.activity_name);
                        $("#activity_id").attr("id", response.activity_id);
                        if (isLastRow && !isShiftActive) {

                            // FIRST ROW → editable start + end
                            $("#start-time-text").addClass("d-none");
                            $("#start-time-input")
                                .removeClass("d-none")
                                .prop("disabled", false)
                                .val(response.start_time);

                        } else if (isFirstRow && !isShiftActive) {

                            // LAST ROW → disabled start + editable end
                            $("#start-time-text").addClass("d-none");
                            $("#start-time-input")
                                .removeClass("d-none")
                                .prop("disabled", true)
                                .val(response.start_time);

                        } else {

                            // MIDDLE → text start
                            $("#start-time-input").addClass("d-none");
                            $("#start-time-text")
                                .removeClass("d-none")
                                .text(response.start_time);
                        }
                        // if ((isFirstRow || isLastRow) && !isShiftActive) {
                        //     $("#start-time-input").val(response.start_time);
                        // }else{
                        //     $("#start-time-text").text(response.start_time);

                        // }
                        // response.end_time = "14:30:45"
                        $("#end-time").val(response.end_time);
                        $("#duration").text(response.duration);
                        $("#remarks").val(response.remarks);
                        $(".manager").text(response.manager);
                        $("#manager_id").attr("id", response.manager_id);
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
    const selectedRadio = $('input[name="correction_row"]:checked')[0];
    const entryId = selectedRadio.dataset.entry;
    console.log("entryId: " , entryId);
    const remarks = $("#remarks").val();
    const end_time = $("#end-time").val(); // should be HH:MM:SS if seconds are needed
    const start_time = $("#start-time-input").is(":visible")
    ? $("#start-time-input").val() || null
    : null;

    const requested_date = new Date().toISOString().slice(0, 10); // YYYY-MM-DD
    const manager_id = $(".manager").attr("id");
    const activity_id = $(".activity").attr("id");
    console.log("start_time", start_time);

    $.ajax({
        url: "../../actions/employee/update_time_correction.php",
        method: "POST",
        dataType: "json",
        data: { 
            entry_id: entryId, 
            remarks: remarks,
            requested_date: requested_date,
            start_time: start_time,
            end_time: end_time,
            manager_id: manager_id,
            activity_id: activity_id
        },
        success: function(response) {
            console.log("AJAX Response:", response);
            if(response.status === "success"){
                $("#correction-modal").modal('hide');
                alert(response.message);
                location.reload();
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