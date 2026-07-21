@extends('admin.layouts.app')

@section('content')

<div class="content-wrapper">

```
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ویرایش محصول</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="#">خانه</a></li>
                    <li class="breadcrumb-item active">ویرایش محصول</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card card-primary">

                    <div class="card-header">
                        <h3 class="card-title">ویرایش لوازم ورزشی</h3>
                    </div>

                    <form action="{{ route('products.update',$product->id) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>نام محصول</label>
                                <input type="text"
                                       class="form-control"
                                       name="name"
                                       value="{{ old('name',$product->name) }}">
                            </div>
                            
                            <div class="form-group">
                                <label>قیمت</label>
                                <input type="number"
                                class="form-control"
                                name="price"
                                value="{{ old('price',$product->price) }}">
                            </div>
                            
                            <div class="form-group">
                                <label>تعداد موجودی</label>
                                <input type="number"
                                class="form-control"
                                name="stock"
                                value="{{ old('stock', $product->stock) }}">
                            </div>

                            <div class="form-group">
                                <label>تخفیف</label>
                                <input type="number"
                                class="form-control"
                                name="discount"
                                value="{{ old('discount',$product->discount) }}">
                            </div>
                            
                            <div class="form-group">
                                <label>دسته بندی</label>
                                
                                <select name="category_id" class="form-control">
                                    
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>تصاویر فعلی محصول</label>
                                
                                <div class="row">
                                    
                                    @foreach($product->images as $image)
                                    
                                    <div class="col-md-3 mb-3">
                                        
                                        <img
                                        src="{{ asset('storage/'.$image->image_path) }}"
                                        class="img-fluid img-thumbnail">
                                        
                                    </div>
                                    
                                    @endforeach
                                    
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>افزودن تصاویر جدید</label>
                                
                                <input type="file"
                                name="images[]"
                                multiple
                                class="form-control">
                            </div>

                            <div class="form-group">
                                <label>توضیحات محصول</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit"
                                    class="btn btn-primary">
                                بروزرسانی محصول
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</section>
```

</div>
@endsection
