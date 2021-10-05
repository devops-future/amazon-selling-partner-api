<?php

namespace DevOpsFuture\TestPackage\Http\Controllers\Portal;

use DevOpsFuture\TestPackage\Repositories\ProductFeedStatusRepository;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use SellingPartnerApi as SPA;

class TableController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $productFeedStatusRepository;
    protected $_sp_config;
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProductFeedStatusRepository $productFeedStatusRepository
    ) {
        $this->_config = request('_config');

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $feed_list = $this->productFeedStatusRepository->all();
        return view($this->_config['view'], compact('feed_list'));
    }

    public function feed_result($id) {
        $feed_record = $this->productFeedStatusRepository->findOrFail($id);

        $apiInstance = new SPA\Api\FeedsApi($this->_sp_config);

        try {
            $result = $apiInstance->getFeedDocument($feed_record->result_document_id);
            return redirect($result->getUrl());
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->getFeedDocument: ', $e->getMessage(), PHP_EOL;
        }
    }
}
