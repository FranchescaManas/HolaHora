
$(document).ready(function() {
 
  $('.view-employee').on('click', function() {
    // Get employee ID from the data attribute
    var userId = $(this).closest('tr').data('user-id');
    // Make AJAX request to get employee data (you can adapt this depending on your back-end setup)
    $.ajax({
      url: '"../../../../actions/user/view-employee.php', // The PHP script to get the details
      type: 'GET', 
      data: { user_id: userId }, // Pass the employee ID to the server
      success: function(employee) {
        // Assuming response is a JSON object with the employee's details
        console.log(employee); 
        var employee = JSON.parse(employee);
        // Populate the modal fields with the employee data
        $('#view-firstname').val(employee.firstname);  // Set value for read-only field
        $('#view-lastname').val(employee.lastname);
        $('#view-contact').val(employee.contact_no);
        $('#view-email').val(employee.email);
        $('#view-position').val(employee.position);
        $('#view-team').val(employee.team);
        $('#view-username').val(employee.username);
        
        // Show the modal
        $('#view-employee-modal').modal('show');
      },
      error: function() {
        alert('Error fetching employee details');
      }
    });
  });
});
