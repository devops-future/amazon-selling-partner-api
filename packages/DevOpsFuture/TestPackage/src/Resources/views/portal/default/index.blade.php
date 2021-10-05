@extends('portal::layouts.master')

@section('page_title')
    Package TestPackage
@stop

@section('content-wrapper')

    <div class="main">
        Test AWS API
        <ul>
            <li>
                <a href="{{ route('portal.testpackage.apaapi') }}">Amazon Product Advertising Api</a>
            </li>
        </ul>
        Test Amazon Selling Partner API
        <ul>
            <li>
                <a href="{{ route('portal.testpackage.create-feed') }}">createFeed</a>
            </li>
            <li>
                <a href="{{ route('portal.testpackage.list-catalog-items') }}">listCatalogItems</a>
            </li>
            <li>
                <a href="{{ route('portal.testpackage.get-definition-product-type') }}">getDefinitionProductType</a>
            </li>
            <li>
                <a href="{{ route('portal.testpackage.search-definitions-product-types') }}">searchDefinitionProductType</a>
            </li>
            <li>
                <a href="{{ route('portal.testpackage.get-reports') }}">getReports</a>
            </li>
            <li>
                <a href="{{ route('portal.testpackage.get-report-document') }}">getReportDocument</a>
            </li>
            <li>
                <a href="{{ route('portal.testpackage.put-litings-item') }}">putListingsItem</a>
            </li>
        </ul>
        Package TestPackage
    </div>

@stop
