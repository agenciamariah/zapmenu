<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Extras;
use App\Imports\ItemsImport;
use App\Items;
use App\Plans;
use App\Restorant;
use Illuminate\Http\Request;
use Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ConfChanger;
use Akaunting\Module\Facade as Module;

class ItemsController extends Controller
{
    private $imagePath = 'uploads/restorants/';

    public function reorderCategories(Categories $up){
        $up->moveOrderUp();
        return redirect()->route('items.index')->withStatus(__('Sort order updated'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole('owner')) {

            
            $canAdd = auth()->user()->restorant->getPlanAttribute()['canAddNewItems'];
            

            //Change language
            ConfChanger::switchLanguage(auth()->user()->restorant);

            if (isset($_GET['remove_lang']) && auth()->user()->restorant->localmenus()->count() > 1) {
                $localMenuToDelete=auth()->user()->restorant->localmenus()->where('language', $_GET['remove_lang'])->first();
                $isMenuToDeleteIsDefault=$localMenuToDelete->default.""=="1";
                $localMenuToDelete->delete();
                
                $nextLanguageModel = auth()->user()->restorant->localmenus()->first();
                $nextLanguage = $nextLanguageModel->language;
                app()->setLocale($nextLanguage);
                session(['applocale_change' => $nextLanguage]);

                if($isMenuToDeleteIsDefault){
                    $nextLanguageModel->default=1;
                    $nextLanguageModel->update();
                }
            }

            if(isset($_GET['make_default_lang'])){
                $newDefault=auth()->user()->restorant->localmenus()->where('language', $_GET['make_default_lang'])->first();
                $oldDefault=auth()->user()->restorant->localmenus()->where('default', "1")->first();
                
                if($oldDefault&&$oldDefault->language!=$_GET['make_default_lang']){
                    $oldDefault->default=0;
                    $oldDefault->update();
                }
                $newDefault->default=1;
                $newDefault->update();
                
                
                
            }

            $currentEnvLanguage = isset(config('config.env')[2]['fields'][0]['data'][config('app.locale')]) ? config('config.env')[2]['fields'][0]['data'][config('app.locale')] : 'UNKNOWN';


            //Change currency
            ConfChanger::switchCurrency(auth()->user()->restorant);
            $defaultLng=auth()->user()->restorant->localmenus->where('default','1')->first();

            

            //Since 2.1.7 - there is sorting. 
            $categories=auth()->user()->restorant->categories;

            
            //If first item order starts with 0
            if($categories->first()&&$categories->first()->order_index==0){
                Categories::setNewOrder($categories->pluck('id')->toArray());



                //Re-get categories
                $categories=auth()->user()->restorant->categories;
            }

            return view('items.index', [
                'hasMenuPDf'=>Module::has('menupdf'),
                'canAdd'=>$canAdd,
                'categories' => $categories,
                'restorant_id' => auth()->user()->restorant->id,
                'currentLanguage'=> $currentEnvLanguage,
                'availableLanguages'=>auth()->user()->restorant->localmenus,
                'defaultLanguage'=>$defaultLng?$defaultLng->language:""
                ]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    public function indexAdmin(Restorant $restorant)
    {
        if (auth()->user()->hasRole('admin')) {
            return view('items.index', ['categories' => Restorant::findOrFail($restorant->id)->categories->reverse(), 'restorant_id' => $restorant->id]);
        } else {
            return redirect()->route('orders.index')->withStatus(__('No Access'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Items;
        $item->name = strip_tags($request->item_name);
        $item->description = strip_tags($request->item_description);
        $item->price = strip_tags($request->item_price);
        $item->category_id = strip_tags($request->category_id);
        if ($request->hasFile('item_image')) {
            $item->image = $this->saveImageVersions(
                $this->imagePath,
                $request->item_image,
                [
                    ['name'=>'large', 'w'=>590, 'h'=>400],
                    //['name'=>'thumbnail','w'=>300,'h'=>300],
                    ['name'=>'medium', 'w'=>295, 'h'=>200],
                    ['name'=>'thumbnail', 'w'=>200, 'h'=>200],
                ]
            );
        }
        $item->save();

        return redirect()->route('items.index')->withStatus(__('Item successfully updated.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Items $item)
    {
        //if item belongs to owner restorant menu return view
        if (auth()->user()->hasRole('owner') && $item->category->restorant->id == auth()->user()->restorant->id || auth()->user()->hasRole('admin')) {
            return view('items.edit',
            [
                'item' => $item,
                'setup'=>['items'=>$item->variants()->paginate(100)],
                'restorant' => $item->category->restorant,
                'restorant_id' => $item->category->restorant->id, ]);
        } else {
            return redirect()->route('items.index')->withStatus(__('No Access'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $item)
    {
        $item->name = strip_tags($request->item_name);
        $item->description = strip_tags($request->item_description);
        $item->price = strip_tags($request->item_price);
        if (isset($request->vat)) {
            $item->vat = $request->vat;
        }

        $item->available = $request->exists('itemAvailable');
        $item->has_variants = $request->exists('has_variants');
        $item->item_orcamento = $request->item_orcamento;
        $item->item_somavel = $request->item_somavel;

        if ($request->hasFile('item_image')) {
            if ($request->hasFile('item_image')) {
                $item->image = $this->saveImageVersions(
                    $this->imagePath,
                    $request->item_image,
                    [
                        ['name'=>'large', 'w'=>590, 'h'=>400],
                        //['name'=>'thumbnail','w'=>300,'h'=>300],
                        ['name'=>'medium', 'w'=>295, 'h'=>200],
                        ['name'=>'thumbnail', 'w'=>200, 'h'=>200],
                    ]
                );
            }
        }

        $item->update();

        return redirect()->route('items.edit', $item)->withStatus(__('Item successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Items $item)
    {
        $item->delete();

        return redirect()->route('items.index')->withStatus(__('Item successfully deleted.'));
    }

    public function import(Request $request)
    {

        $restorant = Restorant::findOrFail($request->res_id);

        $categorys = Categories::where(['restorant_id' => $request->res_id])->get();

        /*
        object(Illuminate\Database\Eloquent\Collection)#2030 (1) { ["items":protected]=> array(1) {
         [0]=> object(App\Categories)#2029 (30) {
         [
         "table":protected]=> string(10) "categories" [
         "translatable"]=> array(1) {
         [
         0]=> string(4) "name" } [
         "sortable"]=> array(2) {
         [
         "order_column_name"]=> string(11) "order_index" [
         "sort_when_creating"]=> bool(true) } [
         "connection":protected]=> string(5) "mysql" [
         "primaryKey":protected]=> string(2) "id" [
         "keyType":protected]=> string(3) "int" [
         "incrementing"]=> bool(true) [
         "with":protected]=> array(0) {
         } [
         "withCount":protected]=> array(0) {
         } [
         "perPage":protected]=> int(15) [
         "exists"]=> bool(true) [
         "wasRecentlyCreated"]=> bool(false) [
         "attributes":protected]=> array(7) {
         [
         "id"]=> int(74) [
         "name"]=> string(15) "{
        "pt":"Pizzas"}" [
        "restorant_id"]=> int(34) [
        "created_at"]=> string(19) "2021-11-29 15:36:53" [
        "updated_at"]=> string(19) "2022-01-28 12:56:17" [
        "order_index"]=> int(3) [
        "active"]=> int(1) } [
        "original":protected]=> array(7) {
         [
         "id"]=> int(74) [
         "name"]=> string(15) "{
        "pt":"Pizzas"}" [
        "restorant_id"]=> int(34) [
        "created_at"]=> string(19) "2021-11-29 15:36:53" [
        "updated_at"]=> string(19) "2022-01-28 12:56:17" [
        "order_index"]=> int(3) [
        "active"]=> int(1) } [
        "changes":protected]=> array(0) {
         } [
         "casts":protected]=> array(0) {
         } [
         "classCastCache":protected]=> array(0) {
         } [
         "dates":protected]=> arr'ay(0) {
         } [
         "dateFormat":protected]=> NULL [
         "appends":protected]=> array(0) {
         } [
         "dispatchesEvents":protected]=> array(0) {
         } [
         "observables":protected]=> array(0) {
         } [
         "relations":protected]=> array(0) {
         } [
         "touches":protected]=> array(0) {
         } [
         "timestamps"]=> bool(true) [
         "hidden":protected]=> array(0) {
         } [
         "visible":protected]=> array(0) {
         } [
         "fillable":protected]=> array(0) { } [
         "guarded":protected]=> array(1) { [
         0]=> string(1) "*" } [
         "translationLocale":protected]=> NULL } } }

        */

        foreach($categorys as $category){
            $parent = Categories::find($category->id);

            foreach($parent->items as $item){
                $item->delete();
            }
            $parent->restorant_id = 1;
            $parent->save();

        }


        Excel::import(new ItemsImport($restorant), request()->file('items_excel'));

        //return redirect()->route('admin.restaurants.index')->withStatus(__('Items successfully imported'));
        return back()->withStatus(__('Items successfully imported'));
    }

    public function change(Items $item, Request $request)
    {
        $item->available = $request->value;
        $item->update();

        return response()->json([
            'data' => [
                'itemAvailable' => $item->available,
            ],
            'status' => true,
            'errMsg' => '',
        ]);
    }



    public function replicate(Request $request)
    {
        // $this->adminOnly();
        $thePOST = $request->all();
        //$itemToDuplicate = strip_tags($request->id);
        // Retrieve the first task
        //$ItemDuplicated = Items::first();
        $ItemDuplicated = Items::findOrFail($thePOST['res_item_duplicar_id']); // pizza teste
        //$ItemDuplicated = Items::findOrFail(370); // pizza teste

        $newItemDuplicated = $ItemDuplicated->replicate();
        $newItemDuplicated->name = "Item Duplicado"; // the new project_id
        $newItemDuplicated->save();


        return response()->json([
            'data' => [
                'newItemDuplicated' => $newItemDuplicated->id,
            ],
            'status' => true,
            'errMsg' => '',
        ]);

    }

    public function storeExtras(Request $request, Items $item)
    {
        //dd($request->all());
        if ($request->extras_id.'' == '') {
            //New
            $extras = new Extras;
            $extras->name = strip_tags($request->extras_name);
            $extras->price = strip_tags($request->extras_price);
            $extras->item_id = $item->id;

            $extras->save();
        } else {
            //Update
            $extras = Extras::where(['id'=>$request->extras_id])->get()->first();

            $extras->name = strip_tags($request->extras_name);
            $extras->price = strip_tags($request->extras_price);

            $extras->update();
        }

        //For variants
        //Does the item of this extra have item?
        if ($item->has_variants.'' == 1) {
            //In cas we have variants, we  need to check if this variant is for all variants, or only for selected one
            if ($request->exists('variantsSelector')) {
                $extras->extra_for_all_variants = 0;
                //Now sync the connection
                $extras->variants()->sync($request->variantsSelector);
            } else {
                $extras->extra_for_all_variants = 1;
            }
        } else {
            $extras->extra_for_all_variants = 1;
        }
        $extras->update();

        return redirect()->route('items.edit', ['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id])->withStatus(__('Extras successfully added/modified.'));
    }

    public function editExtras(Request $request, Items $item)
    {
        $extras = Extras::where(['id'=>$request->extras_id])->get()->first();

        $extras->name = strip_tags($request->extras_name_edit);
        $extras->price = strip_tags($request->extras_price_edit);

        $extras->update();

        return redirect()->route('items.edit', ['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id])->withStatus(__('Extras successfully updated.'));
    }

    public function deleteExtras(Items $item, Extras $extras)
    {
        $extras->delete();

        return redirect()->route('items.edit', ['item' => $item, 'restorant' => $item->category->restorant, 'restorant_id' => $item->category->restorant->id])->withStatus(__('Extras successfully deleted.'));
    }
}
