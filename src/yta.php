<?php
$client->setAccessToken($_SESSION['access_token']);
$yt_analytics = new Google_Service_YouTubeAnalytics($client);

$queryParams = [
    'endDate' => date('Y-m-d'),
    'ids' => 'channel==MINE',
    'metrics' => 'views',
    'dimensions' => 'video',
    'startDate' => '2019-03-01',
    'maxResults' => '200',
    'sort' => '-views',
];

$rows = $yt_analytics->reports->query($queryParams)->rows;

try {
    foreach (array_chunk(array_column($rows, 0), 50) as $video_id) {
        $items = (new Google_Service_YouTube($client))->videos->listVideos(
            'snippet',
            [
                'id' => implode(',', $video_id),
            ]
        )->items;
        foreach ($items as $item) {
            array_unshift(
                $rows[array_search($item->id, array_column($rows, 0))],
                $item->snippet->title
            );
        }
    }
} catch (Exception $e) {
    print_r($e->getMessage());
}
var_dump($rows);

// $sheets = new Google_Service_Sheets($client);
// $spreadsheetId = '1IX8Szhj3yHoXf9iEdFrsub36tzfcW3F0J1tJReT1haA';
// $range = 'Test!A2';
// $body = new Google_Service_Sheets_ValueRange([
// 	'values' => $rows
// ]);

// $params = [
// 	'valueInputOption' => 'RAW'
// ];

// $response = $sheets->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
// printf($response->getUpdatedCells());
