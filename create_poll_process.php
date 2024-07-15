<?php
header('Content-Type: application/json');
$dataFile = 'data/polls.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pollTitle = $_POST['poll_title'] ?? '';
    $pollType = $_POST['poll_type'] ?? '';
    $pollDeadline = $_POST['poll_deadline'] ?? '';
    $pollDescription = $_POST['poll_description'] ?? '';
    $participants = $_POST['participants'] ?? '';

    if (file_exists($dataFile)) {
        $polls = json_decode(file_get_contents($dataFile), true);
    } else {
        $polls = [];
    }

    $pollId = uniqid();
    $polls[] = [
        'poll_id' => $pollId,
        'title' => $pollTitle,
        'type' => $pollType,
        'deadline' => $pollDeadline,
        'description' => $pollDescription,
        'participants' => $participants,
        'created_at' => date('Y-m-d H:i:s')
    ];

    file_put_contents($dataFile, json_encode($polls));
    echo json_encode(['success' => true, 'message' => 'Poll created successfully', 'poll_id' => $pollId]);
}
?>
