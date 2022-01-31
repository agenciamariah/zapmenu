<div class="card card-profile bg-secondary shadow">
    <div class="card-header">

        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">ADS</h3>
            </div>

        </div>
    </div>
    <div class="card-body">

    <div class="pl-lg-4">
    <form id="restorant-apps-form" method="post" autocomplete="off" enctype="multipart/form-data" action="https://app.zapentrega.com/updateres/ads/34">
            @csrf
        @method('post')
        <div class="row">
        <div class="col-md-12">
        <input type="hidden" id="rid" value="{{ $restorant->id }}"/>
        @php
        var_dump($restorant);
        @endphp
        AD: {{ $restorant->ad1_link }}
        @include('partials.fields',['fields'=>[
            ['ftype'=>'input','name'=>"ad1_link",'id'=>"ad1_link",'placeholder'=>"Footer AD #1 - Link",'required'=>true,'value'=>$restorant->ad1_link],
        ]])
        <div class="row">
            <?php
                $images=[
                    ['name'=>'ad1_image','label'=>__('Footer AD #1 - Imagem'),'value'=>$restorant->logowide,'style'=>'width: 200px; height: 62px;','help'=>"PNG 1200x150"]
                ]
            ?>
            @foreach ($images as $image)
                <div class="col-md-6">
                    @include('partials.images',$image)
                </div>
            @endforeach
        </div>

        


        

        

       
       

    
        
        </div>


        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
        </div>
        
    </form>
</div>

</div>
</div>
