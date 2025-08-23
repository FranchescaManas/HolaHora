$(document).ready(function () {
    // Fetch current activity on page load
    fetchCurrentActivity();

    // Update activity title when dropdown option is selected
    $("#activitySelect").click(function () {
        var selectedActivity = $("#activityDropdown option:selected").text();
        $("#activityTitle").text(selectedActivity);
        
    });
    
     $("#shift-ok").click(function () {

        location.reload();
    });

    // Update time every second
    setInterval(updateTime, 1000);
    updateTime(); // Initial call to display time immediately

});

function submitShift(value) {
    // 1. Get the current time from the <p> element
    let time = document.getElementById("currentTime").textContent;
    console.log("time", time); // should now print actual time

    // 2. Set modal message immediately
    let msg = (value == 1)
        ? "Your shift has started. Please select an activity to begin."
        : "Your shift has ended. Thank you for your hard work today!";
    document.getElementById("shiftMessage").textContent = msg;

    // 3. Show modal immediately
    var myModal = new bootstrap.Modal(document.getElementById('shiftReminderModal'));
    myModal.show();

    // 4. Send AJAX request in background
    $.ajax({
        url: "../../actions/employee/shift-activity.php",
        type: "POST",
        data: { 
            btn_shift: value, 
            time: time, 
            ajax: 1 // flag so PHP knows it's AJAX
        },
        success: function(response) {
            // location.reload();
            // console.log("Backend response:", response);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}









/**
 * Fetches the user's current activity from the server.
 */
function fetchCurrentActivity() {
    let shift = $("#activityTitle").data("shift"); // get the data-shift attribute (0 or 1)

    if (shift == 1) {  
        // Only fetch if shift is active
        $.ajax({
            url: "../../actions/employee/get_current_activity.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                console.log("AJAX Success Response:", response);

                if (response.success) {
                    $("#activityTitle").text(response.activity);
                } else {
                    $("#activityTitle").text("No activity selected");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Server Response:", xhr.responseText);
            }
        });
    } else {
        console.log("Shift is not active, skipping fetch.");
    }
}




/**
 * Captures the current time and sets it in a hidden input field.
 */
function set_time_activity() {
    let currentTime = $("#currentTime").text();
    $("#timeInput").val(currentTime);
}

/**
 * Updates the displayed time every second.
 */
function updateTime() {
    var now = new Date();
    var formattedTime = now.toLocaleTimeString("en-US", { hour12: false });
    $("#currentTime").text(formattedTime);
}


