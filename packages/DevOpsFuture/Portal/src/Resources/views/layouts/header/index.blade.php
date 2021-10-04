<?php
    $term = request()->input('term');
    $image_search = request()->input('image-search');

    if (! is_null($term)) {
        $serachQuery = 'term='.request()->input('term');
    }
?>

<div class="header" id="header">

</div>

@push('scripts')

@endpush
