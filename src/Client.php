<?php

namespace MarcusGaius\YTData;

use Google\Client as Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTubeAnalytics;
use MarcusGaius\YTData\Traits\UsesHelper;

class Client extends Google_Client
{
    use UsesHelper;

    protected $analyticsReport;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->setAuthConfig($this->helper()->getConfig('cred_path'));
        $this->setScopes($this->helper()->getConfig('scopes'));
        $this->setAccessType($this->helper()->getConfig('access_type'));
        if (isset($_GET['auth'])) $this->setAuthUrl();
        if (isset($_GET['code'])) $this->setSessionToken();
        if (isset($_GET['report'])) $this->getAnalyticsReport();
    }

    protected function setAuthUrl()
    {
        $this->setRedirectUri($this->helper()->url());
        header('Location: ' . filter_var($this->createAuthUrl(), FILTER_SANITIZE_URL));
    }

    protected function setSessionToken()
    {
        session_start();
        $this->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $this->getAccessToken();
        header('Location: ' . filter_var($this->helper()->url('start.php'), FILTER_SANITIZE_URL));
    }

    protected function getAnalyticsReport()
    {
        session_start();
        $this->setAccessToken($_SESSION['access_token']);
        $yt_analytics = new Google_Service_YouTubeAnalytics($this);
        
        $queryParams = [
            'endDate' => date('Y-m-d'),
            'ids' => 'channel==MINE',
            'metrics' => 'views',
            'dimensions' => 'video',
            'startDate' => '2019-03-01',
            'maxResults' => '200',
            'sort' => '-views',
        ];
        
        $this->analyticsReport = $yt_analytics->reports->query($queryParams)->rows;

        try {
            foreach (array_chunk(array_column($this->analyticsReport, 0), 50) as $video_id) {
                $items = (new Google_Service_YouTube($this))->videos->listVideos(
                    'snippet',
                    [
                        'id' => implode(',', $video_id),
                    ]
                )->items;
                foreach ($items as $item) {
                    array_unshift(
                        $this->analyticsReport[array_search($item->id, array_column($this->analyticsReport, 0))],
                        $item->snippet->title
                    );
                }
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
        var_dump($this->analyticsReport);
    }
}
