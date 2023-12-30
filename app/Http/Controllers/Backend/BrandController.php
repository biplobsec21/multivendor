<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use App\Models\Brand;
use Image;
class BrandController extends Controller
{

    public function AllBrand(){
        $brands = Brand::latest()->get();
        return view('backend.brand.brand_all',compact('brands'));
    } // End Method


    public function AddBrand(){
         return view('backend.brand.brand_add');
    } // End Method


    public function StoreBrand(Request $request): RedirectResponse{

        $request->validate([
            'brand_name' => 'required|unique:brands|max:255',
            'brand_image'=>'required|image|max:10240'//10MB
        ]);

        // default image url
        $save_image_url='upload/brand/no_image.jpg';
        if ($request->session()->has('_token') && $request->session()->get('_token') == $request->_token) {
            // Continue processing the form
            if($request->file('brand_image')){
                $image = $request->file('brand_image');
                $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
                $save_image_url = 'upload/brand/'.$name_gen;
            }

            Brand::insert([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-',$request->brand_name)),
                'brand_image' => $save_image_url,
            ]);
            // Remove the token to prevent resubmission
            $request->session()->forget('token');
        }

       $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );

        return to_route('all.brand')->with($notification);

    }// End Method


    public function EditBrand($id){
        $brand = Brand::findOrFail($id);
        return view('backend.brand.brand_edit',compact('brand'));
    }// End Method


    public function UpdateBrand(Request $request){
        //
        $notification = array();
        // validation //
        $request->validate([
            'brand_name' => ['required', 'max:255', Rule::unique('brands')->ignore($request->id)],
            'brand_image'=>'sometimes|required|image|max:10240'//10MB
        ]);
        // get id and old image value
        $brand_id = $request->id;
        $image_url = $request->old_image;

        // if image uploaded
        if ($request->file('brand_image')) {

            $image = $request->file('brand_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
            $save_url = 'upload/brand/'.$name_gen;

            if (file_exists($image_url)) {
                unlink($image_url);
            }
            $image_url=$save_url;
        }
        // update images
        $data = Brand::find($brand_id);
        $data->brand_name=$request->brand_name;
        $data->brand_slug=strtolower(str_replace(' ', '-',$request->brand_name));
        $data->brand_image= $image_url;
        if($data->isDirty()){
            $data->save();
            $notification = array(
                'message' => 'Brand Updated  Successfully',
                'alert-type' => 'success'
            );
        }
        return redirect()->route('all.brand')->with($notification);

    }// End Method


    public function DeleteBrand($id){

        $brand = Brand::findOrFail($id);
        $img = $brand->brand_image;
        unlink($img );

        Brand::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Brand Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method


}
