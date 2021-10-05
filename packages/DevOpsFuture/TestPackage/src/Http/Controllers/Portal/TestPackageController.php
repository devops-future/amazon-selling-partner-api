<?php

namespace DevOpsFuture\TestPackage\Http\Controllers\Portal;

use DevOpsFuture\TestPackage\Repositories\ProductFeedStatusRepository;
use DevOpsFuture\TestPackage\Repositories\ProductFeedXmlRepository;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use SellingPartnerApi as SPA;

use Apaapi\operations\SearchItems as ApaapiSearchItems;
use Apaapi\operations\GetItems as ApaapiGetItems;
use Apaapi\lib\Request as ApaapiRequest;
use Apaapi\lib\Response as ApaapiResponse;

class TestPackageController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $productFeedStatusRepository;
    protected $productFeedXmlRepository;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    protected $_sp_config;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProductFeedStatusRepository $productFeedStatusRepository,
        ProductFeedXmlRepository $productFeedXmlRepository
    ) {
        $this->_config = request('_config');

        $this->productFeedStatusRepository = $productFeedStatusRepository;
        $this->productFeedXmlRepository = $productFeedXmlRepository;

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
        return view($this->_config['view']);
    }

    public function test_apaapi() {
        // Set Operation
        $operation = new ApaapiSearchItems();
        $operation->setPartnerTag('associate-tag-20')->setKeywords('4902505346217');

// Prapere Request
        $request = new ApaapiRequest(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
        $request->setLocale('se')->setPayload($operation);

// Get Response
        $response = new ApaapiResponse($request);
        echo $response->get(); // JSON ready to be parsed
        exit;

        $request = new ApaapiRequest(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
        $request->setLocale('SE')->setPayload($operation);

        $response = new ApaapiResponse($request);
        echo $response->get();
    }

    public function test_create_feed() {
        $feedType = SPA\FeedType::POST_PRODUCT_DATA;

        // Request feed document id
        $apiInstance = new SPA\Api\FeedsApi($this->_sp_config);
        $createFeedDocSpec = new SPA\Model\Feeds\CreateFeedDocumentSpecification(['content_type' => $feedType['contentType']]); // \SellingPartnerApi\Model\Feeds\CreateFeedSpecification
        $feedDocInfo = $apiInstance->createFeedDocument($createFeedDocSpec);
        $feedDocId = $feedDocInfo->getFeedDocumentId();

        // Upload feed document
        $productParams = [
            "seller_id" => env('AMZ_SELLER_ID'),
            "sku" => "Tonerweb-395823",
            "external_item_type" => "EAN",
            "external_item_id" => "4902505346217",
            "title" => "Weightless Lip Color",
            "brand" => "Pilot Pen",
            "description" => "A richly hydrating all-natural lipstick in shades that complement every skin tone.",
            "bullet_point_1" => "Free of parabens, phthalates, and sulfates.",
            "bullet_point_2" => "Free of parabens, phthalates, and sulfates.",
        ];
        $feedContents = $this->productFeedXmlRepository->generateXmlBy('OFFICE_PRODUCTS', $productParams);

        $docToUpload = new SPA\Document($feedDocInfo, $feedType);
        $docToUpload->upload($feedContents);

        // Create feed with doc id
        $createFeedSpec = new SPA\Model\Feeds\CreateFeedSpecification();
        $createFeedSpec->setFeedType('POST_PRODUCT_DATA');
        $createFeedSpec->setMarketplaceIds([env('AMZ_TARGET_MARKETPLACE_ID')]);
        $createFeedSpec->setInputFeedDocumentId($feedDocId);
        $createFeedSpec->setFeedOptions([]);

        try {
            $result = $apiInstance->createFeed($createFeedSpec);
            $this->productFeedStatusRepository->addProductFeedRecord($result->getFeedId(), $feedDocId,
                'OFFICE_PRODUCTS', $productParams['sku'], 'EAN', '4902505346217', 'POST_PRODUCT_DATA' );
        } catch (Exception $e) {
            echo 'Exception when calling FeedsApi->createFeed: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function test_list_catalog_items() {
        $apiInstance = new SPA\Api\OldCatalogApi($this->_sp_config);
        $marketplace_id = 'A2NODRKZP88ZB9'; // string | A marketplace identifier. Specifies the marketplace for which items are returned.
        $query = ''; // string | Keyword(s) to use to search for items in the catalog. Example: 'harry potter books'.
        $query_context_id = ''; // string | An identifier for the context within which the given search will be performed. A marketplace might provide mechanisms for constraining a search to a subset of potential items. For example, the retail marketplace allows queries to be constrained to a specific category. The QueryContextId parameter specifies such a subset. If it is omitted, the search will be performed using the default context for the marketplace, which will typically contain the largest set of items.
        $seller_sku = ''; // string | Used to identify an item in the given marketplace. SellerSKU is qualified by the seller's SellerId, which is included with every operation that you submit.
        $upc = ''; // string | A 12-digit bar code used for retail packaging.
        $ean = '4902505346217'; // string | A European article number that uniquely identifies the catalog item, manufacturer, and its attributes.
        $isbn = ''; // string | The unique commercial book identifier used to identify books internationally.
        $jan = ''; // string | A Japanese article number that uniquely identifies the product, manufacturer, and its attributes.

        try {
            $result = $apiInstance->listCatalogItems($marketplace_id, null, null, null, null, $ean);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling OldCatalogApi->listCatalogItems: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function test_get_definition_product_type() {
        $apiInstance = new SPA\Api\ProductTypeDefinitionsApi($this->_sp_config);
        $product_type = 'WRITING_INSTRUMENT'; // string | The Amazon product type name.
        $marketplace_ids = ['A2NODRKZP88ZB9']; // string[] | A comma-delimited list of Amazon marketplace identifiers for the request.
        $seller_id = 'A2NJERFTFSMOP6'; // string | A selling partner identifier. When provided, seller-specific requirements and values are populated within the product type definition schema, such as brand names associated with the selling partner.
        $product_type_version = 'LATEST'; // string | The version of the Amazon product type to retrieve. Defaults to \"LATEST\",. Prerelease versions of product type definitions may be retrieved with \"RELEASE_CANDIDATE\". If no prerelease version is currently available, the \"LATEST\" live version will be provided.
        $requirements = 'LISTING'; // string | The name of the requirements set to retrieve requirements for.
        $requirements_enforced = 'ENFORCED'; // string | Identifies if the required attributes for a requirements set are enforced by the product type definition schema. Non-enforced requirements enable structural validation of individual attributes without all the required attributes being present (such as for partial updates).
        $locale = 'sv_SE'; // string | Locale for retrieving display labels and other presentation details. Defaults to the default language of the first marketplace in the request.

        try {
            $result = $apiInstance->getDefinitionsProductType($product_type, $marketplace_ids, $seller_id, $product_type_version, $requirements, $requirements_enforced, $locale);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling ProductTypeDefinitionsApi->getDefinitionsProductType: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function test_search_definitions_product_types() {
        $apiInstance = new SPA\Api\ProductTypeDefinitionsApi($this->_sp_config);
        $marketplace_ids = ['A2NODRKZP88ZB9']; // string[] | A comma-delimited list of Amazon marketplace identifiers for the request.
        $keywords = ['PILOT'/*, 'OFFICE_PRODUCTS', 'WRITING_INSTRUMENT'*/]; // string[] | A comma-delimited list of keywords to search product types by.

        try {
            $result = $apiInstance->searchDefinitionsProductTypes($marketplace_ids, $keywords);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling ProductTypeDefinitionsApi->searchDefinitionsProductTypes: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function test_get_reposts() {
        $apiInstance = new SPA\Api\ReportsApi($this->_sp_config);
        $report_types = array('GET_XML_BROWSE_TREE_DATA'); // string[] | A list of report types used to filter reports. When reportTypes is provided, the other filter parameters (processingStatuses, marketplaceIds, createdSince, createdUntil) and pageSize may also be provided. Either reportTypes or nextToken is required.
        $processing_statuses = array('DONE'); // string[] | A list of processing statuses used to filter reports.
        $marketplace_ids = array('A2NODRKZP88ZB9'); // string[] | A list of marketplace identifiers used to filter reports. The reports returned will match at least one of the marketplaces that you specify.
        $page_size = 10; // int | The maximum number of reports to return in a single call.
        $created_since = "2021-10-03T00:00:00+01:00"; // \DateTime | The earliest report creation date and time for reports to include in the response, in ISO 8601 date time format. The default is 90 days ago. Reports are retained for a maximum of 90 days.
        $created_until = new \DateTime("2021-10-05T00:00:00+01:00"); // \DateTime | The latest report creation date and time for reports to include in the response, in ISO 8601 date time format. The default is now.
        $next_token = ''; // string | A string token returned in the response to your previous request. nextToken is returned when the number of results exceeds the specified pageSize value. To get the next page of results, call the getReports operation and include this token as the only parameter. Specifying nextToken with any other parameters will cause the request to fail.

        try {
            //$result = $apiInstance->getReports($report_types, $processing_statuses, $marketplace_ids, $page_size, $created_since, $created_until, $next_token);
            $result = $apiInstance->getReports($report_types, $processing_statuses, $marketplace_ids, $page_size, $created_since);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling ReportsApi->getReports: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function test_get_report_document() {
        $apiInstance = new SPA\Api\ReportsApi($this->_sp_config);
        $report_document_id = 'amzn1.spdoc.1.3.221e1a50-6d47-4323-942d-3e5358938743.T6N9Y0XTF762Z.316'; // string | The identifier for the report document.
        $report_type = 'GET_XML_BROWSE_TREE_DATA'; // string | The name of the document's report type.

        try {
            $result = $apiInstance->getReportDocument($report_document_id, $report_type);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling ReportsApi->getReportDocument: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function test_put_listings_item() {
        $apiInstance = new SPA\Api\ListingsApi($this->_sp_config);
        $seller_id = 'A2NJERFTFSMOP6'; // string | A selling partner identifier, such as a merchant account or vendor code.
        $sku = 'Tonerweb-3235958'; // string | A selling partner provided identifier for an Amazon listing.
        $marketplace_ids = ['A2NODRKZP88ZB9']; // string[] | A comma-delimited list of Amazon marketplace identifiers for the request.

        $product_listing_data = [
            "product_type" => "PRODUCT",
            "requirements"  => "LISTING",
            "attributes"    => [
                //"brand"  => [],
                "bullet_point"  => [
                    [
                        "value"         => "Foder i läder som andas",
                        "language_tag"  => "sv_SE",
                        "marketplace_id"    => "A2NODRKZP88ZB9",
                    ]
                ],
                "color"  => [
                    [
                        "value"         => "Tranbär",
                        "language_tag"  => "sv_SE",
                        "marketplace_id"    => "A2NODRKZP88ZB9",
                    ]
                ],
                "country_of_origin"  => [
                    [
                        "value"         => "SE",
                        "marketplace_id"    => "A2NODRKZP88ZB9",
                    ]
                ],
                "externally_assigned_product_identifier"    => [
                    [
                        "marketplace_id"    => 'A2NODRKZP88ZB9',
                        "type"              => 'ean',
                        "value"             => '4902505346217',
                    ],
                ],
//                "item_name"  => [
//                    [
//                        "value"         => "AmazonBasics 16\" Underseat Spinner Carry-On",
//                        "language_tag"  => "en_US",
//                        "marketplace_id"    => "A2NODRKZP88ZB9",
//                    ]
//                ],
                "product_description"  => [
                    [
                        "value"         => "A richly hydrating all-natural lipstick in shades that complement every skin tone.",
                        "language_tag"  => "sv_SE",
                        "marketplace_id"    => "A2NODRKZP88ZB9",
                    ],
                ],
                //"recommended_browse_nodes"  => [],
                "supplier_declared_dg_hz_regulation"  => [
                    [
                        "value" => "transportation",
                    ]
                ],
            ],
        ];

        $body = new \SellingPartnerApi\Model\Listings\ListingsItemPutRequest($product_listing_data); // \SellingPartnerApi\Model\Listings\ListingsItemPutRequest | The request body schema for the putListingsItem operation.
        print_r($body);

        $issue_locale = 'sv_SE'; // string | A locale for localization of issues. When not provided, the default language code of the first marketplace is used. Examples: \"en_US\", \"fr_CA\", \"fr_FR\". Localized messages default to \"en_US\" when a localization is not available in the specified locale.

        try {
            $result = $apiInstance->putListingsItem($seller_id, $sku, $marketplace_ids, $body, $issue_locale);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling ListingsApi->putListingsItem: ', $e->getMessage(), PHP_EOL;
        }
    }
}
