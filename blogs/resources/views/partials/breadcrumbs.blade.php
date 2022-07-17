{{-- resources/views/partials/breadcrumbs.blade.php --}}

@unless ($breadcrumbs->isEmpty())
<ul class="breadcrumb">
    @foreach ($breadcrumbs as $breadcrumb)

    @if (!is_null($breadcrumb->url) && !$loop->last)
    <li class="breadcrumb-item">
        <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
    </li>
    @else
    <li class="breadcrumb-item active">
        <a href="#">{{ $breadcrumb->title }}</a>
    </li>
    @endif

    @endforeach
</ul>
@endunless