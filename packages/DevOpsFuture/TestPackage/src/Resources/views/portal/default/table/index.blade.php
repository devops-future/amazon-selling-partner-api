@extends('portal::layouts.master')

@section('page_title')
    Package TestPackage
@stop

@section('content-wrapper')

    <div class="main">
        Feed List
        <table>
            <thead>
                <th>id</th>
                <th>request_id</th>
                <th>time</th>
                <th>result_id</th>
                <th>status</th>
            </thead>
            <tbody>
                @foreach ($feed_list as $feed)
                    <tr>
                        <td>{{$feed->id}}</td>
                        <td>{{$feed->document_id}}</td>
                        <td>{{$feed->created_at}}</td>
                        <td>
                            @if(!empty($feed->result_document_id))
                                <a href="{{route('portal.testpackage.table.feed', ['id'=>$feed->id])}}" target="_blank">
                                    {{$feed->result_document_id}}
                                </a>
                            @endif
                        </td>
                        <td>{{$feed->feed_status}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@stop
