$(document).ready(function () {
  $('.view-employee').on('click', function () {
    var userId = $(this).data('user-id');
    var targetModal = $(this).data('bs-target'); // Detect which modal to open

    $.ajax({
      url: '../../actions/user/view-employee.php',
      type: 'GET',
      data: { user_id: userId },
      success: function (response) {
        var employee = JSON.parse(response);
        console.log(employee);
        // // Populate both modals depending on which one was triggered
        if (targetModal === '#view-employee-modal') {
          $('#view-firstname').val(employee.firstname);
          $('#view-lastname').val(employee.lastname);
          $('#view-contact').val(employee.contact_no);
          $('#view-email').val(employee.email);
          $('#view-position').val(employee.position);
          $('#view-team').val(employee.team);
          $('#view-username').val(employee.username);
        }

        if (targetModal === '#edit-employee-modal') {
          $('#edit-firstname').val(employee.firstname);
          $('#edit-lastname').val(employee.lastname);
          $('#edit-contact').val(employee.contact_no);
          $('#edit-email').val(employee.email);
          $('#edit-position').val(employee.position); // Use ID for select
          $('#edit-team').val(employee.team);         // Use ID for select
          $('#edit-username').val(employee.username);
          $('#edit-user-id').val(employee.user_id);      // hidden field for updating
        }
      },
      error: function () {
        alert('Error fetching employee details');
      }
    });
  });
});
