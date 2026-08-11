@foreach($categories as $category)
    @php
        $isChecked = in_array($category->id, $selectedCategories);
        $prefix = str_repeat('- ', $depth);
    @endphp
    <div class="form-check mb-1">
        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
               class="form-check-input sport-category-checkbox"
               id="cat-{{ $category->id }}"
               {{ $isChecked ? 'checked' : '' }}>
        <label class="form-check-label w-100" for="cat-{{ $category->id }}">
            <span class="d-inline-block" style="margin-left: {{ $depth * 12 }}px;">{{ $prefix }}</span>
            {{ $category->name }}
        </label>
    </div>
    @if($category->childrenRecursive->isNotEmpty())
        @include('admin.features.partials.category-tree', [
            'categories' => $category->childrenRecursive,
            'depth' => $depth + 1,
            'selectedCategories' => $selectedCategories
        ])
    @endif
@endforeach
