<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{


  public function UploadProduct(Request $request)
  {
    $file = $request->file('image');
    $extension = $file->getClientOriginalExtension();
    // $path = public_path('upload/images');
    $name_img = time() . '.' . $extension;
    // $name_path = $path . '/' . $name_img;
    $file->move('upload/images/', $name_img);

    //store image file into directory and db
    $save = new Product;
    $save->title = $request->input('title');
    $save->description = $request->input('description');
    $save->price = $request->input('price');
    $save->category = $request->input('category');

    $save->status = $request->input('status');
    $save->image = $name_img;
    $save->save();
    return response()->json([
      'message' => 'file_uploaded'
    ], 200);
  }


  public function updateProduct(Request $request, $id)
  {
    $update = Product::find($id);
    $update->title = $request->input('title');
    $update->description = $request->input('description');
    $update->price = $request->input('price');
    $update->category = $request->input('category');

    $update->status = $request->input('status');
    // $update->image = $name_path;
    if ($request->hasFile("image")) {
      $description = 'upload/images/' . $update->image;

      if (File::exists($description)) {
        File::delete($description);
      }
      $file = $request->file('image');
      $extension = $file->getClientOriginalExtension();
      // $path = public_path('upload/images');
      $name_img = time() . '.' . $extension;
      // $name_path = $path . '/' . $name_img;
      $file->move('upload/images/', $name_img);
      $update->image = $name_img;
      //update image file into directory and db


      $update->update();
      return response()->json([
        'message' => 'file_update'
      ], 200);
    }
  }
  public function getProduct()
  {
    $product = Product::all();
    return response()->json([
      'data' => $product
    ]);
  }
  public function deleteProduct($id)
  {
    $destroy = Product::find($id);
    $description = 'upload/images/' . $destroy->image;

    if (File::exists($description)) {
      File::delete($description);
    }
    $destroy->delete();
    return response()->json([
      'message' => 'Delete Product Success',
    ]);
  }
}
