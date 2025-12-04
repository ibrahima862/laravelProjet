<option value="{{ $category->id }}">{{ $prefix }}{{ $category->name }}</option>

@if ($category->children)
    @foreach ($category->children as $child)
        @include('partials.category_option', [
            'category' => $child, 
            'prefix' => $prefix . '-- '
        ])
    @endforeach
@endif
