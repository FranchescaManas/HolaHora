<?php
include "../../classes/User.php";
session_start();

$user = new User();

// Read filters (GET because we download)
$user_id     = $_GET['name_filter'] ?? null;
$team     = $_GET['team_filter'] ?? null;
$activity = $_GET['activity'] ?? null;
$from     = $_GET['from'] ?? null;
$to       = $_GET['to'] ?? null;
$isBillable = $_GET['is_billable'] ?? null;

$result = $user->get_activity_dashboard([
    'user_id' => $user_id,
    'activity' => $activity,
    'from'     => $from,
    'to'       => $to,
    'team'     => $team,
    'is_billable' => $isBillable
]);

// CSV headers
$filename = 'activity_' . date('Y-m-d') . '.csv';
header('Content-Type: text/csv; charset=utf-8');

header("Content-Disposition: attachment; filename=\"$filename\"");

// Open output stream
$output = fopen('php://output', 'w');

// CSV column headers
fputcsv($output, [
    'Name',
    'Team',
    'Activity',
    'Billable',
    'Date',
    'Start Time',
    'End Time',
    'Duration'
]);

// Rows
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['name'],
            $row['team_name'],
            $row['activity_name'],
            $row['isBillable'] ? 'Yes' : 'No',
            $row['date'],
            $row['start_time'],
            $row['end_time'] ?? 'Ongoing',
            $row['duration'] ?? 'In Progress'
        ]);
    }
}

fclose($output);
exit;
