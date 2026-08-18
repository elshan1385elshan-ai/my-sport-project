@foreach($categories as $category)
    @php
        $isChecked = in_array($category->id, $selectedCategories);
        $prefix = str_repeat('- ', $depth);
    @endphp
    <label class="sport-tree-item" for="cat-{{ $category->id }}">
        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
               class="sport-tree-checkbox"
               id="cat-{{ $category->id }}"
               {{ $isChecked ? 'checked' : '' }}>
        <span class="sport-tree-text">
            <span class="d-inline-block" style="margin-left: {{ $depth * 12 }}px;">{{ $prefix }}</span>
            {{ $category->name }}
        </span>
    </label>
    @if($category->childrenRecursive->isNotEmpty())
        @include('admin.features.partials.category-tree', [
            'categories' => $category->childrenRecursive,
            'depth' => $depth + 1,
            'selectedCategories' => $selectedCategories
        ])
    @endif
@endforeach
