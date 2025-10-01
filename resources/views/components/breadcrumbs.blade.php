@props(['breadcrumbs' => []])

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item{{ isset($breadcrumb['url']) ? '' : ' active' }}"
                @if (!isset($breadcrumb['url'])) aria-current="page" @endif>
                @if (isset($breadcrumb['url']))
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['text'] }}</a>
                @else
                    {{ $breadcrumb['text'] }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>