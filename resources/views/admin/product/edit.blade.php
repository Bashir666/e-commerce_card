<x-app-layout>
    <section class="wsus__product mt_145 pb_100">
        <div class="container">
            @if ($errors->any())
               @foreach ($errors->all() as $error)
                   <div class="alert alert-danger">{{ $error }}</div>
               @endforeach
            @endif
            <h4 class="pt-3 pb-3 text-primary">Dashboard</h4>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Update Product</h5>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Go Back</a>
                </div>
                <div class="card-body">
                  <form action="{{ route('products.update', $product->id) }}) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Image</label>
                        <x-text-input type="file" class="form-control" name="image" />
                        <div>
                            <img style="width: 100px !important;" class="ms-2 mt-2 mb-2" src="{{ asset($product->image) }}" alt="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Images</label>
                        <x-text-input type="file" class="form-control" name="images[]" multiple />
                        <div>
                            @foreach ($product->images as $image)
                                <img style="width: 100px !important;" class="ms-2 me-2 mt-2 mb-2" src="{{ asset($image->path) }}" alt="">
                            @endforeach
                    </div>

                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Name</label>
                        <x-text-input type="text" class="form-control" name="name" value="{{ $product->name }}" />
                    </div>

                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Price</label>
                        <x-text-input type="text" class="form-control" name="price" value="{{ $product->price }}" />
                    </div>

                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Colors</label>
                        <x-select-input name="colors[]" multiple>
                            <option value="">Select</option>
                            <option @selected(in_array('black', $colors)) value="black">Black</option>
                            <option @selected(in_array('green', $colors)) value="green">Green</option>
                            <option @selected(in_array('red', $colors)) value="red">Red</option>
                            <option @selected(in_array('cyan', $colors)) value="cyan">Cyan</option>
                        </x-select-input>
                    </div>

                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Short Description</label>
                        <x-text-input type="text" class="form-control" name="short_description" value="{{ $product->short_description }}" />
                    </div>

                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Qty</label>
                        <x-text-input type="text" class="form-control" name="qty" value="{{ $product->qty }}" />
                    </div>

                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Sku</label>
                        <x-text-input type="text" class="form-control" name="sku" value="{{ $product->sku }}" />
                    </div>

                    <div class="form-group">
                        <label for="" class="mt-2 mb-2">Description</label>
                        <textarea name="description" id="editor" cols="30" rows="10">{!! $product->description !!}</textarea>
                    </div>

                    <x-primary-button>Submit</x-primary-button>
                </form>

                </div>
            </div>

        </div>
    </section>

    <x-slot name="scripts">
        <script>
            tinymce.init({
                selector: 'textarea#editor',
                height: 500,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            });
        </script>
    </x-slot>

</x-app-layout>
