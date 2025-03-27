let selectedEmployees = {};

// Search employee inside modal
$('#search_employee_modal').keyup(function(){
  let query = $(this).val();
  if (query !== '') {
    $.ajax({
      url: '../../actions/manager/search-employees.php',
      method: 'POST',
      data: { query: query },
      success: function(data){
        $('#employee_list_modal').html(data).show();
      }
    });
  } else {
    $('#employee_list_modal').hide();
  }
});

$(document).on("click", ".employee-item", function (e) {
  e.preventDefault();
  let userId = $(this).data("id");
  let name = $(this).data("name");
  let position = $(this).data("position");
  let status = $(this).data("status");

  if (selectedEmployees[userId]) {
    alert("Employee already added!");
    return;
  }

  selectedEmployees[userId] = { name, position, status };

  let newRow = `
    <tr data-id="${userId}">
      <td>${name}</td>
      <td>${position}</td>
      <td>${status}</td>
      <td><button class="btn btn-danger btn-sm remove-employee">Remove</button></td>
    </tr>`;
  $("#selected_employees_table").append(newRow);
  $('#employee_list_modal').hide();
  $('#search_employee_modal').val('');
});

// Remove employee
$(document).on("click", ".remove-employee", function () {
  let userId = $(this).closest("tr").data("id");
  delete selectedEmployees[userId];
  $(this).closest("tr").remove();
});

// Save button
$("#save_team_employees").on("click", function () {
  let teamId = $("#team_select").val();
  if (!teamId) {
    alert("Please select a team!");
    return;
  }
  if (Object.keys(selectedEmployees).length === 0) {
    alert("Please add at least one employee!");
    return;
  }

  $.ajax({
    url: '../../actions/manager/add-employee.php',
    method: 'POST',
    data: {
      team_id: teamId,
      employees: selectedEmployees
    },
    success: function (response) {
      alert(response);
      location.reload();
    }
  });
});
