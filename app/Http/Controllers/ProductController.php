<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DetailsLkpp;
use App\Models\Product;
use App\Models\ProductTranslations;
use App\Models\Files;
use App\Models\EntityFiles;
use App\Models\Companies;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Gate;



class ProductController extends Controller
{

    public function postProduct(Request $request)
    {
        $xClientId = DetailsLkpp::where('x-client-id', $request->header('X-Client-ID'))->first();
        $xClientSecret = DetailsLkpp::where('x-client-secret', $request->header('X-Client-Secret'))->first();

    if($xClientId == null || $xClientSecret == null){
        return response()->json(array(
                'code' => 400,
                'data' => null,
                'message' => 'ClientID & ClientSecret Salah',
                'status' => false
            ), 400);
    }else{


       $data =  DB::table('Products')
               ->join('product_translations', 'Products.id', '=', 'product_translations.product_id')
               ->join('entity_files', 'Products.id', '=', 'entity_files.entity_id')
               ->join('files', 'Files.id', '=', 'entity_files.file_id')
               ->join('companies', 'Companies.id', '=', 'products.company_id')
               ->select('product_translations.name as product_name', 'companies.name as company_name', 'price','path','thumb','description','weight','keyword','tax_class_id','sku','products.company_id')
               ->where('products.is_active',1)
               ->paginate(100);

        // dd($data);


        foreach ($data as $index => $key) {
        
            $tax =  ($data[$index]->tax_class_id === null) ? false : true;

            $data[$index]->product_name = $data[$index]->product_name;
            $data[$index]->product_price = $data[$index]->price;
            $data[$index]->product_images = $data[$index]->path;
            $data[$index]->product_thumbnail = $data[$index]->thumb;
            $data[$index]->product_description = $data[$index]->description;
            $data[$index]->product_category = null;
            $data[$index]->product_weight = $data[$index]->weight;
            $data[$index]->tags = $data[$index]->keyword;
            $data[$index]->is_available = true;
            $data[$index]->is_taxable = $tax;
            $data[$index]->SKU = $data[$index]->sku;
            $data[$index]->merchant_id = $data[$index]->company_id;
            $data[$index]->merchant_name = $data[$index]->company_name;
           

        // unset($data[$index]->name, 
        //       $data[$index]->id,
        //       $data[$index]->slug,
        //       $data[$index]->weight,
        //       $data[$index]->lkpp_id,
        //       $data[$index]->price,
        //       $data[$index]->special_price,
        //       $data[$index]->special_price_start,
        //       $data[$index]->special_price_end,
        //       $data[$index]->sku,
        //       $data[$index]->qty,
        //       $data[$index]->in_stock,
        //       $data[$index]->viewed,
        //       $data[$index]->is_lkpp,
        //       $data[$index]->is_lkpp_posted,
        //       $data[$index]->new_from,
        //       $data[$index]->new_to,
        //       $data[$index]->deleted_at,
        //       $data[$index]->created_at,
        //       $data[$index]->product_id,
        //       $data[$index]->locale,
        //       $data[$index]->description,
        //       $data[$index]->specification,
        //       $data[$index]->tax_class_id,
        //       $data[$index]->selling_price,
        //       $data[$index]->manage_stock,
        //       $data[$index]->is_active,
        //       $data[$index]->updated_at,
        //       $data[$index]->short_description,
        //       $data[$index]->keyword,
        //       $data[$index]->company_id,
        //       $data[$index]->vendor_price,
        //       $data[$index]->minimum_order,
        //       $data[$index]->created_by,
        //       $data[$index]->vendor_product_status_id,
        //       $data[$index]->stock_product_status_id,
        //       $data[$index]->price_formula,
        //       $data[$index]->vendor_price_rate,
        //       $data[$index]->vendro_currency,
        //       $data[$index]->length,
        //       $data[$index]->height,
        //       $data[$index]->width,
        //       $data[$index]->rating,
        //       $data[$index]->unit,
        //       $data[$index]->vendor_currency,
        //       $data[$index]->file_id,
        //       $data[$index]->entity_type,
        //       $data[$index]->entity_id,
        //       $data[$index]->zone,
        //       $data[$index]->user_id,
        //       $data[$index]->filename,
        //       $data[$index]->disk,
        //       $data[$index]->path,
        //       $data[$index]->thumb,
        //       $data[$index]->extension,
        //       $data[$index]->mime,
        //       $data[$index]->size
        // );

        }

       
        if($data){
        return response()->json(array(
            'status' => true,
            'code' => 200,
            'data' => $data
        ));
    }else{
        return response()->json(array(
            'code' => 400,
            'data' => null,
            'message' => 'The requested object was not found.',
            'status' => false
        ));
    }

    }
  }
}
?>