$(document).ready(function () {
    let selectedEmployees = {}; // Store selected employees to prevent duplicates

    $('#search_employee').keyup(function () {
        let query = $(this).val();
        if (query !== '') {
            $.ajax({
                url: '../../actions/admin/search-employees.php',
                method: 'POST',
                data: { query: query },
                success: function (data) {
                    $('#employee_list').html(data).show();
                }
            });
        } else {
            $('#employee_list').hide();
        }
    });

    $(document).on("click", ".employee-item", function (e) {
        e.preventDefault();
        let userId = $(this).data("id");
        let name = $(this).data("name");
        let position = $(this).data("position");
        let status = $(this).data("status");

        $("#search_employee").val(name);
        $("#search_employee").attr("data-id", userId);
        $("#search_employee").attr("data-position", position);
        $("#search_employee").attr("data-status", status);
        $("#employee_list").hide();
    });

    // Add employee to the team table
    $("#add_employee").on("click", function (e) {
        e.preventDefault();
        let userId = $("#search_employee").attr("data-id");
        let name = $("#search_employee").val();
        let position = $("#search_employee").attr("data-position") || "Unknown";
        let status = $("#search_employee").attr("data-status") || "Active";

        if (!userId || !name) {
            alert("Please select an employee first!");
            return;
        }

        if (selectedEmployees[userId]) {
            alert("Employee is already in the team!");
            return;
        }

        selectedEmployees[userId] = true;

        let newRow = `
            <tr data-id="${userId}">
                <td class="align-middle">${name}</td>
                <td class="align-middle">${position}</td>
                <td class="align-middle">${status}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-employee">Remove</button>
                </td>
            </tr>
        `;

        $("#team_employee_list tbody").append(newRow);
        $("#search_employee").val("").removeAttr("data-id");
    });

    // Remove employee from team
    document.querySelectorAll('.remove-employee').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation(); // Prevent bubbling
            const row = this.closest('tr');
            const userId = row.dataset.userId;
            console.log("Removing user ID:", userId);
            row.remove(); // Or trigger a backend call
        });
    });

    // Hide dropdown when clicking outside
    $(document).on("click", function (e) {
        if (!$(e.target).closest("#search_employee, #employee_list").length) {
            $("#employee_list").hide();
        }
    });

    $("form").on("submit", function () {
        let employeeIds = [];

        // Get all userIds from the table rows directly
        $("#team_employee_list tbody tr").each(function () {
            let userId = $(this).data("id");
            if (userId) {
                employeeIds.push(userId);
            }
        });

        $("#employees").val(employeeIds.join(",")); // Store them in the hidden input
    });

});
