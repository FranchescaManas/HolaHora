<?php
include "../../classes/User.php";
session_start();

$user = new User();

$user_id     = $_POST['name_filter'] ?? null;
$team     = $_POST['team_filter'] ?? null;
$activity = $_POST['activity'] ?? null;
$from     = $_POST['from'] ?? null;
$to       = $_POST['to'] ?? null;
$isBillable = $_POST['is_billable'] ?? null;

$result = $user->get_activity_dashboard([
    'user_id'  => $user_id,
    'activity' => $activity,
    'from'     => $from,
    'to'       => $to,
    'team'     => $team,
    'is_billable' => $isBillable
]);

$tableRows = '';
if ($result && $result->num_rows > 0) {
    while ($log = $result->fetch_assoc()) {

        $endTime  = $log['end_time'] ?? 'Ongoing';
        $duration = $log['duration'] ?? 'In Progress';

        $tableRows .= '
            <tr>
                <td>' . htmlspecialchars($log['name']) . '</td>
                <td>' . htmlspecialchars($log['team_name']) . '</td>
                <td>' . htmlspecialchars($log['activity_name']) . '</td>
                <td>' . htmlspecialchars($log['date']) . '</td>
                <td>' . htmlspecialchars($log['start_time']) . '</td>
                <td>' . htmlspecialchars($endTime) . '</td>
                <td>' . htmlspecialchars($duration) . '</td>
                <td>
                    <button type="button"
                            class="btn view-remark-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#view-remark"
                            data-entry-id="' . (int)$log['entry_id'] . '">
                        <i class="fa-regular fa-message"></i>
                    </button>
                </td>
            </tr>';
    }
} else {
    $tableRows = '
        <tr>
            <td colspan="6" class="text-center text-muted">
                No results found
            </td>
        </tr>';
}

$hoursData = $user->get_activity_hours([
    'user_id'  => $user_id,
    'activity' => $activity,
    'from'     => $from,
    'to'       => $to,
    'team'     => $team,
    'is_billable' => $isBillable
]);
$hoursHead = '<th>Activity</th>';
$hoursBody = '<tr><td>Hours</td>';

if (!empty($hoursData)) {
    foreach ($hoursData as $row) {
        $hoursHead .= '<th>' . htmlspecialchars($row[0]) . '</th>';
        $hoursBody .= '<td>' . htmlspecialchars($row[1]) . '</td>';
    }
} else {
    // Keep structure clean
    $hoursHead .= '<th class="text-muted">No Data</th>';
    $hoursBody .= '<td class="text-muted">0</td>';
}

$hoursHead .= '</tr>';
$hoursBody .= '</tr>';


header('Content-Type: application/json');
echo json_encode([
    'rows' => $tableRows,
    'hours_head' => $hoursHead,
    'hours_body' => $hoursBody
]);
exit;
