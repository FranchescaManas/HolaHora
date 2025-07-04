$(document).ready(function () {
    let selectedEmployees = {}; // To prevent duplicates

    // Search employee
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

    // Select from suggestion
    $(document).on("click", ".employee-item", function (e) {
        e.preventDefault();
        let userId = $(this).data("id");
        let name = $(this).data("name");
        let position = $(this).data("position");
        let status = $(this).data("status");

        $("#search_employee").val(name)
            .attr("data-user-id", userId)
            .attr("data-position", position)
            .attr("data-status", status);
        $("#employee_list").hide();
    });

    // Add employee to table
    $("#add_employee").on("click", function (e) {
        e.preventDefault();

        let userId = $("#search_employee").attr("data-user-id");
        let name = $("#search_employee").val();
        let position = $("#search_employee").attr("data-position") || "Unknown";
        let status = $("#search_employee").attr("data-status") || "Active";

        if (!userId || !name) {
            alert("Please select an employee first!");
            return;
        }

        if (selectedEmployees[userId]) {
            alert("Employee already added!");
            return;
        }

        selectedEmployees[userId] = true;

        let newRow = `
            <tr data-user-id="${userId}">
                <td class="align-middle">${name}</td>
                <td class="align-middle">${position}</td>
                <td class="align-middle">${status}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-employee">Remove</button>
                </td>
            </tr>
        `;
        $("#team_employee_list tbody").append(newRow);
        $("#search_employee").val("").removeAttr("data-user-id data-position data-status");
    });

    // Remove employee (delegated event)
    $(document).on('click', '.remove-employee', function (e) {
        e.stopPropagation();
        const row = $(this).closest('tr');
        const userId = row.data('user-id');
        console.log("Removing user ID:", userId);
        delete selectedEmployees[userId];
        row.remove();
    });

    // Hide search dropdown when clicking outside
    $(document).on("click", function (e) {
        if (!$(e.target).closest("#search_employee, #employee_list").length) {
            $("#employee_list").hide();
        }
    });

    // Submit form: convert selected IDs to comma string
    $("form").on("submit", function (e) {
        // e.preventDefault()
        let employeeIds = [];
        $("#team_employee_list tbody tr").each(function () {
            let userId = $(this).data("user-id");
            if (userId) {
                employeeIds.push(userId);
            }
        });
        console.log("Submitted IDs:", employeeIds);
        $("#employees").val(employeeIds.join(","));
    });
});
