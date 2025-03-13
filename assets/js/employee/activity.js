$(document).ready(function () {
    // Fetch current activity on page load
    fetchCurrentActivity();

    // Update activity title when dropdown option is selected
    $("#activitySelect").click(function () {
        var selectedActivity = $("#activityDropdown option:selected").text();
        $("#activityTitle").text(selectedActivity);
    });

    // Update time every second
    setInterval(updateTime, 1000);
    updateTime(); // Initial call to display time immediately
});

/**
 * Fetches the user's current activity from the server.
 */
function fetchCurrentActivity() {
    $.ajax({
        url: "../../actions/employee/get_current_activity.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            console.log("AJAX Success Response:", response); // Debugging log

            if (response.success) {
                $("#activityTitle").text(response.activity);
            } else {
                $("#activityTitle").text("No activity selected");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Server Response:", xhr.responseText); // Log raw response
        }
    });
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
