<?php

namespace DevOpsFuture\TestPackage\Console\Commands;

use DevOpsFuture\TestPackage\Repositories\ProductFeedStatusRepository;
use Illuminate\Console\Command;

use SellingPartnerApi as SPA;

class FeedChecher extends Command
{
    protected $_sp_config;
    protected $productFeedStatusRepository;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devops-future:feed:checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ProductFeedStatusRepository $productFeedStatusRepository
    )
    {
        parent::__construct();

        $this->productFeedStatusRepository = $productFeedStatusRepository;

        $this->_sp_config = new SPA\Configuration(
            [
                "lwaClientId" => env('LWA_CLIENT_ID'),
                "lwaClientSecret" => env('LWA_CLIENT_SECRET'),
                "lwaRefreshToken" => env('LWA_REFRESH_TOKEN'),
                "awsAccessKeyId" => env('AWS_ACCESS_KEY_ID'),
                "awsSecretAccessKey" => env('AWS_SECRET_ACCESS_KEY'),
                "endpoint" => SPA\Endpoint::EU,
                'roleArn' => env('AWS_ROLE_ARN')
            ]
        );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $in_progress_list = $this->productFeedStatusRepository->getUncompletedFeedList();

        $apiInstance = new SPA\Api\FeedsApi($this->_sp_config);

        try {
            foreach($in_progress_list as $feed_status_record) {
                $result = $apiInstance->getFeed($feed_status_record->feed_id);
                $this->productFeedStatusRepository->updateRecordByFeed($result);
            }
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->getFeed: ', $e->getMessage(), PHP_EOL;
        }
    }
}
