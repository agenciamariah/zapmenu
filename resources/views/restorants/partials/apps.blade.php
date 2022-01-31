<div class="card card-profile bg-secondary shadow">
    <div class="card-header">

        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{ __("Apps")}}</h3>
            </div>

        </div>
    </div>
    <div class="card-body">
        <form id="restorant-apps-form" method="post" autocomplete="off" enctype="multipart/form-data" action="{{ route('admin.restaurant.updateApps',$restorant) }}">
            @csrf
            @method('put')

        @php
        var_dump($restorant);
        @endphp
        AD: {{ $restorant->ad1_link }}
        @include('partials.fields',['fields'=>[
            ['ftype'=>'input','name'=>"ad1_link",'id'=>"ad1_link",'placeholder'=>"Footer AD #1 - Link",'required'=>true,'value'=>$restorant->ad1_link],
        ]])
        
            @include('partials.fields',['fields'=>$appFields])
            <div class="text-center">
                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
            </div>
        </form>
    </div>
</div>