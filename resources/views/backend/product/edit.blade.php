@include('backend.dashboard.components.heading', [
    'title' => config('apps.product.edit.title'),
])
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    {{-- xuất lỗi  --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1"> Thông tin cơ bản</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2"> Dữ liệu sản phẩm</a></li>
                        {{-- <li class=""><a data-toggle="tab" href="#tab-3"> Discount</a></li> --}}
                        <li class=""><a data-toggle="tab" href="#tab-4"> Hình ảnh</a></li>
                    </ul>
                    @if (isset($product))
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <fieldset class="form-horizontal">
                                        <div class="form-group"><label class="col-sm-2 control-label">Tên sản
                                                phẩm:</label>
                                            <div class="col-sm-10"><input value="{{ old('name', $product->name) }}"
                                                    name="name" type="text" class="form-control"
                                                    placeholder="Tên sản phẩm">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Mô tả:</label>
                                            <div class="col-sm-10">

                                                <textarea id="summernoteProduct" name="description">
                                                    {{ old('description', $product->description) }}
                                                </textarea>
                                                {{-- <textarea id="my-editor" name="content" class="form-control">{!! old('content', 'test editor content') !!}</textarea> --}}
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Khuyến
                                                mãi (%) :</label>
                                            <div class="col-sm-10">
                                                <div style="position: relative;">
                                                    <input
                                                        value="{{ number_format(old('price_sale', $product->price_sale), 0, ',', '.') }}"
                                                        name="price_sale" id="" type="number"
                                                        class="form-control" placeholder="50%"
                                                        style="padding-right: 20px;">
                                                    <span
                                                        style="position: absolute; top: 50%; left: 40px; transform: translateY(-50%);">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Hình ảnh đại diện:</label>
                                            <div class="col-sm-10">
                                                @if (isset($product->image))
                                                    <img width="100px" height="100px"
                                                        src="{{ asset('uploads/product/' . $product->image) }}"
                                                        alt="">
                                                @endif
                                                <input type="file" class="form-control" id="file" name="image"
                                                    accept="image/*">
                                                <span id="error_gallery"></span>
                                            </div>

                                        </div>
                                        {{-- <div class="form-group"><label class="col-sm-2 control-label">Mã hàng hóa:</label>
                                        <div class="col-sm-10">
                                            <input value="{{ old('sku') }}" name="sku" type="text"
                                                class="form-control" placeholder="SKU123..">
                                        </div>
                                    </div> --}}

                                    </fieldset>

                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <fieldset class="form-horizontal">
                                        <div class="form-group"><label class="col-sm-2 control-label">Trọng
                                                lượng:</label>
                                            <div class="col-sm-10">
                                                <input
                                                    value="{{ number_format(old('weight', $product->weight), 0, ',', '.') }}"
                                                    name="weight" type="number" class="form-control"
                                                    placeholder="560gram">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Trạng thái:</label>
                                            <div class="col-sm-10">
                                                {{-- {{$product->status}} --}}
                                                <select value="{{ old('status', $product->status) }}" name="status"
                                                    id="" class="form-control">
                                                    <option value="0"
                                                        {{ $product->status == 0 ? 'selected' : false }}>Chưa kích hoạt
                                                    </option>
                                                    <option value="1"
                                                        {{ $product->status == 1 ? 'selected' : false }}>Kích hoạt
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Danh mục:</label>
                                            <div class="col-sm-10">
                                                <select value="{{ old('category_id') }}" name="category_id"
                                                    id="" class="setupSelect2 form-control">
                                                    <option value="">[ Chọn danh mục ]</option>

                                                    @if (isset($categories))
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ $product->category_id == $category->id ? 'selected' : false }}>
                                                                {{ $category->name }}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Thương hiệu:</label>
                                            <div class="col-sm-10">
                                                <select value="{{ old('brand_id') }}" name="brand_id" id=""
                                                    class="setupSelect2 form-control">
                                                    <option value="">[ Chọn thương hiệu ]</option>
                                                    @if (isset($brands))
                                                        @foreach ($brands as $brand)
                                                            <option style="width: 100%" value="{{ $brand->id }}"
                                                                {{ $product->brand_id == $brand->id ? 'selected' : false }}>
                                                                {{ $brand->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Xuất xứ:</label>
                                            <div class="col-sm-10">
                                                <select name="origin" id=""
                                                    class="setupSelect2 form-control">

                                                    @if (isset($provinces))
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->code }}"
                                                                {{ $product->province_id == $province->id ? 'selected' : false }}>
                                                                {{ $province->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-10">
                                                @if ($product->product_attribute)
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="ibox float-e-margins">
                                                                <div class="ibox-title">
                                                                    <h5>Các thuộc tính của sản phẩm : </h5>
                                                                </div>
                                                                <div class="ibox-content">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Thuộc tính</th>
                                                                                <th>Giá</th>
                                                                                <th>Số lượng stock</th>
                                                                                <th>SKU</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @if ($product->product_attribute)
                                                                                {{-- @foreach ($colors as $color)
                                                                                    @foreach ($sizes as $size)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <input
                                                                                                    value="{{ $color->id }}"
                                                                                                    name="attribute_type[]"
                                                                                                    type="hidden">
                                                                                                <input
                                                                                                    value="{{ $color->value }}"
                                                                                                    name="attribute_value[]"
                                                                                                    type="hidden">

                                                                                                <input
                                                                                                    value="{{ $size->id }}"
                                                                                                    name="attribute_type[]"
                                                                                                    type="hidden">
                                                                                                <input
                                                                                                    value="{{ $size->value }}"
                                                                                                    name="attribute_value[]"
                                                                                                    type="hidden">

                                                                                                <strong>{{ $size->value }}</strong>
                                                                                                |
                                                                                                <strong><i
                                                                                                        class="fa fa-circle"
                                                                                                        style="color: {{ $color->value }}">
                                                                                                    </i></strong>
                                                                                            </td>
                                                                                            <td> <input
                                                                                                    value="{{ old('pricePro[]') }}"
                                                                                                    name="pricePro[]"
                                                                                                    id="priceInput"
                                                                                                    type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="$160.00">
                                                                                            </td>
                                                                                            <td> <input name="stock[]"
                                                                                                    type="text"
                                                                                                    class="form-control">
                                                                                            </td>
                                                                                            <td><input
                                                                                                    value="{{ old('sku[]') }}"
                                                                                                    name="sku[]"
                                                                                                    type="text"
                                                                                                    class="form-control"
                                                                                                    placeholder="SKU123..">
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                @endforeach --}}

                                                                            @endif

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            {{-- <div id="tab-4" class="tab-pane">
                            <div class="panel-body">
                                <div class="table-responsive" id="gallery_load">
                                </div>
                            </div>
                        </div> --}}
                        </div>
                    @endif
                </div>
                <div class="text-right">
                    <div class="form-group col-sm-12 m-t-xl"> <button type="submit" class="btn btn-primary">Lưu
                            lại</button> </div>
                </div>
            </div>

        </form>
    </div>

</div>
