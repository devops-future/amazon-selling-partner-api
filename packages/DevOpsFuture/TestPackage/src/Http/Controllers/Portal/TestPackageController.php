<?php

namespace DevOpsFuture\TestPackage\Http\Controllers\Portal;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use SellingPartnerApi;

class TestPackageController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

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
    public function __construct()
    {
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        print_r(env('LWA_CLIENT_SECRET'));
        $config = new SellingPartnerApi\Configuration(
            [
                "lwaClientId" => env('LWA_CLIENT_SECRET'),
                "lwaClientSecret" => env('LWA_CLIENT_ID'),
                "lwaRefreshToken" => env('LWA_REFRESH_TOKEN'),
                "awsAccessKeyId" => env('AWS_ACCESS_KEY_ID'),
                "awsSecretAccessKey" => env('AWS_SECRET_ACCESS_KEY'),
                "endpoint" => env('AWS_ENDPOINT'),
                'roleArn' => env('AWS_ROLE_ARN')
            ]
        );
        return view($this->_config['view']);
    }
}
