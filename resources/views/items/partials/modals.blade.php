<!-- ADD Category -->
<div class="modal fade" id="modal-items-category" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">{{ __('Add new category') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('categories.store') }}">
                            @csrf
                            <input type="hidden" value="{{$restorant_id}}"  name="restaurant_id" />
                            <div class="form-group{{ $errors->has('category_name') ? ' has-danger' : '' }}">
                                <input class="form-control" name="category_name" id="category_name" placeholder="{{ __('Category name') }} ..." type="text" required>
                                @if ($errors->has('category_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- EDIT Category -->
<div class="modal fade" id="modal-edit-category" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">{{ __('Edit category') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" id="form-edit-category" method="post" action="">
                            @csrf
                            @method('put')
                            <input name="cat_id" id="cat_id" type="hidden" required>
                            <div class="form-group{{ $errors->has('category_name') ? ' has-danger' : '' }}">
                                <input class="form-control" name="category_name" id="cat_name" placeholder="{{ __('Category name') }} ..." type="text" required>
                                @if ($errors->has('category_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <select class="form-control noselecttwo" name="active" id="cat_active">
                                    <option value="0">Visível</option>
                                    <option value="1">Invisivel</option>
                                </select>
                                

                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- NEW Language -->
<div class="modal fade" id="modal-new-language" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-notification">{{ __('Add new language') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('admin.restaurant.storenewlanguage') }}">
                            @csrf
                            <input type="hidden" value="{{$restorant_id}}"  name="restaurant_id" />
                            @include('partials.select', ['class'=>"col-12", 'classselect'=>"noselecttwo",'name'=>"Language",'id'=>"locale",'placeholder'=>__("Select Language"),'data'=>config('config.env')[2]['fields'][0]['data'],'required'=>true])
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Add new language') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-new-item" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Add new item') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="post" action="{{ route('items.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group{{ $errors->has('item_name') ? ' has-danger' : '' }}">
                                <input class="form-control" name="item_name" id="item_name" placeholder="{{ __('Item name') }} ..." type="text" required>
                                @if ($errors->has('item_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('item_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('item_description') ? ' has-danger' : '' }}">
                                <textarea class="form-control" id="item_description" name="item_description" rows="3" placeholder="{{ __('Item description') }} ..." required></textarea>
                                @if ($errors->has('item_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('item_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('item_price') ? ' has-danger' : '' }}">
                                <input class="form-control" name="item_price" id="item_price" placeholder="{{ __('Item Price') }} ..." type="number" step="any" required>
                                @if ($errors->has('item_price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('item_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group text-center{{ $errors->has('item_image') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="item_image">{{ __('Item Image') }}</label>
                                <div class="text-center">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                            <img src="https://www.fastcat.com.ph/wp-content/uploads/2016/04/dummy-post-square-1-768x768.jpg" width="200px" height="150px" alt="..."/>
                                        </div>
                                    <div>
                                    <span class="btn btn-outline-secondary btn-file">
                                    <span class="fileinput-new">{{ __('Select image') }}</span>
                                    <span class="fileinput-exists">{{ __('Change') }}</span>
                                        <input type="file" name="item_image" accept="image/x-png,image/gif,image/jpeg">
                                    </span>
                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">{{ __('Remove') }}</a>
                                </div>
                                </div>
                                </div>
                            </div>
                            <input name="category_id" id="category_id" type="hidden" required>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-import-items" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Import items from CSV') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="col-md-10 offset-md-1">
                        <form role="form" method="post" action="{{ route('import.items') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group text-center{{ $errors->has('item_image') ? ' has-danger' : '' }}">

                            <a href="https://docs.google.com/spreadsheets/d/1DCLptm7wKo9a6a9rQQ1ddL8Y680h9cHtES0Mcs7c3ms/edit?usp=sharing" target="_blank" style="font-weight: bold;margin-bottom: 25px;color: white;display: block;border: 1px solid #4ee54e;margin-top: -15px;background: #4ee54e;border-radius: 3px; padding: 3px 0px;">Baixe seu arquivo exemplo aqui</a>

                                <label class="form-control-label" for="items_excel">{{ __('Import your file') }}</label>
                                <div class="text-center">
                                    <input type="file" class="form-control form-control-file" name="items_excel" accept=".csv, .ods, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                </div>
                            </div>
                            <input name="res_id" id="res_id" type="hidden" value="{{ $restorant_id }}" required>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- novos duplicar -->


<div class="modal fade" id="modal-duplicar-item" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <form role="form" method="post" action="https://app.zapentrega.com/item/duplicate" enctype="multipart/form-data">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Duplicar o Produto') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                   <div class="card-body px-lg-5 py-lg-5" style="text-align: left;padding-left: 0px !important;padding-top: 10px !important;">
                        <div class="col-md-10 offset-md-1">
                            <div class="form-group" style="text-align: left;">

                                <label class="form-control-label" for="items_excel">Salve para fazer uma <b style="color: black;">cópia</b> do seu produto.</label>

                            </div>
                            @csrf
                            <input name="res_id" id="res_id" type="hidden" value="{{ $restorant_id }}" required>
                            <input name="res_item_duplicar_id" id="res_item_duplicar_id" type="hidden" value="" required="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                <button type="button" class="btn btn-duplicar-save btn-primary" data-dismiss="modal2">{{ __('Save') }}</button>
                                       
            </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="modal-invisivel-category" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <form role="form" method="post" action="/categories/85" enctype="multipart/form-data">
            @method('put')
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title-new-item">{{ __('Deixar Categoria Invisivel') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card bg-secondary shadow border-0">
                   <div class="card-body px-lg-5 py-lg-5" style="text-align: left;padding-left: 0px !important;padding-top: 10px !important;">
                        <div class="col-md-10 offset-md-1">
                            <div class="form-group" style="text-align: left;">

                                <label class="form-control-label" for="items_excel">Salve para deixar essa categoria <b style="color: black;">invisivel</b> para os visitantes.</label>

                            </div>
                            @csrf
                            <input name="category_name" id="category_active_input_name" type="hidden" value="" required>
                            <input name="active" id="category_active_input_value" type="hidden" value="1" required="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                <button type="button" class="btn btn-invisivel-save btn-primary" data-dismiss="modal2">{{ __('Save') }}</button>
                                       
            </div>
            </form>
        </div>
    </div>
</div>
