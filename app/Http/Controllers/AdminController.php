<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\CatImg;
use App\Models\Designation;
use App\Models\Hobbies;
use App\Models\Image;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Technologies;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        if(session()->get('type')=='Admin'){
        return view('Dashboard.index');
    }
    return redirect()->back();
    }
    public function products(){
        if(session()->get('type')=='Admin'){
$products=Product::all();
        return view('Dashboard.products',compact('products'));
 }
 return redirect()->back();

}

public function viewdesignation(){
  if(session()->get('type')=='Admin'){
$designation=Designation::all();
  return view('Dashboard.designation',compact('designation'));
}
return redirect()->back();

}
public function viewabout(){
  if(session()->get('type')=='Admin'){
$about=About::all();
  return view('Dashboard.about',compact('about'));
}
return redirect()->back();

}
public function hobbiesview(){
  if(session()->get('type')=='Admin'){
$hobbies=Hobbies::all();
  return view('Dashboard.hobbies',compact('hobbies'));
}
return redirect()->back();

}
// public function viewtechnologies(){
//   if(session()->get('type')=='Admin'){
// $hobbies=Technologies::all();
//   return view('Dashboard.technologies',compact('hobbies'));
// }
// return redirect()->back();

// }
public function viewtechnologiesimg(){
  if(session()->get('type')=='Admin'){
$hobbies=Technologies::all();
  return view('Dashboard.technologies',compact('hobbies'));
}
return redirect()->back();

}

public function viewportfolio(){
  if(session()->get('type')=='Admin'){
// $portfolio=Portfolio::all();
$portfolio  = DB::table('Portfolios')
// ->join('images','images.fid','portfolios.id')
// ->select('products.title','products.price','products.picture','carts.*')
// ->where('images.customerId',session()->get('id'))
->get();
// print_r($cartItems);die;
  return view('Dashboard.portfolio',compact('portfolio'));
}
return redirect()->back();

}


 public function itemDelete($id){
    if(session()->get('type')=='Admin'){
    $product=Designation::find($id);
    $product->delete();
    return redirect()->back()->with('success','Congratulation Your Product delete');
     }
     return redirect()->back();
    }

    public function aboutdelete($id){
      if(session()->get('type')=='Admin'){
      $about=About::find($id);
      $about->delete();
      return redirect()->back()->with('success','Congratulation Your Product delete');
       }
       return redirect()->back();
      }
      public function hobbiesdelete($id){
        if(session()->get('type')=='Admin'){
        $hobbies=Hobbies::find($id);
        $hobbies->delete();
        return redirect()->back()->with('success','Congratulation Your Product delete');
         }
         return redirect()->back();
        }
 public function AddNewProduct(Request $data){
    if(session()->get('type')=='Admin'){
    //dd($data);
  $product = new Product();
  $product->title=$data->input('title');
  $product->price=$data->input('price');
  $product->type=$data->input('type');
  $product->qunatity=$data->input('quantity');

  $product->category=$data->input('category');
  $product->description=$data->input('description');
  $product->picture=$data->file('file')->getClientOriginalName();
$data->file('file')->move('uploads/products/',$product->picture);
$product->save();
return redirect()->back()->with('success','Congratulation Your Product will be added');




     }
     return redirect()->back();

    }
    public function adddesignation(Request $data){
      if(session()->get('type')=='Admin'){
      //dd($data);
    $product = new Designation();
    $product->name=$data->input('name');
    $product->designation=$data->input('designation');
    //   $product->type=$data->input('type');
  //   $product->qunatity=$data->input('quantity');
  
  //   $product->category=$data->input('category');
  //   $product->description=$data->input('description');
  //   $product->picture=$data->file('file')->getClientOriginalName();
  // $data->file('file')->move('uploads/products/',$product->picture);
  $product->save();
  return redirect()->back()->with('success','Congratulation Your Product will be added');
  
  
  
  
       }
       return redirect()->back();
  
      }
      public function inserttechnology(Request $data){
        if(session()->get('type')=='Admin'){
        //dd($data);
      $product = new Technologies();
      $product->name=$data->input('name');
      // $product->designation=$data->input('designation');
      //   $product->type=$data->input('type');
    //   $product->qunatity=$data->input('quantity');
    
    //   $product->category=$data->input('category');
    //   $product->description=$data->input('description');
    //   $product->picture=$data->file('file')->getClientOriginalName();
    // $data->file('file')->move('uploads/products/',$product->picture);
    $product->save();
    return redirect()->back()->with('success','Congratulation Your Product will be added');
    
    
    
    
         }
         return redirect()->back();
    
        }
      public function addhobbies(Request $data){
        if(session()->get('type')=='Admin'){
        dd($data);
      // $hobbies = new Hobbies();
      // $hobbies->picture=$data->input('picture');
      // $hobbies->name=$data->input('name');
      // print_r($hobbies);
      //   $product->type=$data->input('type');
    //   $product->qunatity=$data->input('quantity');
    
    //   $product->category=$data->input('category');
    //   $product->description=$data->input('description');
    //   $hobbies->picture=$data->file('file')->getClientOriginalName();
    // $data->file('file')->move('uploads/products/',$hobbies->picture);
    // $hobbies->save();
    // return redirect()->back()->with('success','Congratulation Your Product will be added');
    
    
    
    
         }
        //  return redirect()->back();
    
        }
     
   

      public function insertportfolio(Request $data){
        if(session()->get('type')=='Admin'){
        //dd($data);
      $product = new Portfolio();
      

      $product->name=$data->input('name');
      $product->description=$data->input('description');
      //   $product->type=$data->input('type');
    //   $product->qunatity=$data->input('quantity');
    
    //   $product->category=$data->input('category');
    //   $product->description=$data->input('description');
      // $product->picture=$data->file('file')->getClientOriginalName();
      // $data->file('file')->move('uploads/products/',$product->picture);
      $product->save();
      $id=$product->id;

      if ($sliders = $data->file('file')) {
// print_r($sliders);die;
        foreach ($sliders as $slider) {
          $image = new Image();
            $filename = $slider->getClientOriginalName();
            $slider->move(public_path('uploads/products/'), $filename);
            // $product->sliders = $data->file('file')->getClientOriginalName();
            $image->fid=$id;
            $image->picture=$filename;
            $image->save();
        }
    }
   
    
    return redirect()->back()->with('success','Congratulation Your Product will be added');
    
    
    
    
         }
         return redirect()->back();
    
        }
  //       public function addtechnologiesimg(Request $data){
  //         if(session()->get('type')=='Admin'){
  //         //dd($data);
  //       $product = new CatImg();
        
  
  //       $product->name=$data->input('name');
  //       // $product->description=$data->input('description');
  //       //   $product->type=$data->input('type');
  //     //   $product->qunatity=$data->input('quantity');
      
  //     //   $product->category=$data->input('category');
  //     //   $product->description=$data->input('description');
  //       // $product->picture=$data->file('file')->getClientOriginalName();
  //       // $data->file('file')->move('uploads/products/',$product->picture);
  //       $product->save();
  //       $id=$product->id;
  
  //       if ($sliders = $data->file('file')) {
  // // print_r($sliders);die;
  //         foreach ($sliders as $slider) {
  //           $image = new Image();
  //             $filename = $slider->getClientOriginalName();
  //             $slider->move(public_path('uploads/products/'), $filename);
  //             // $product->sliders = $data->file('file')->getClientOriginalName();
  //             $image->cid=$id;
  //             $image->picture=$filename;
  //             $image->save();
  //         }
  //     }
     
      
  //     return redirect()->back()->with('success','Congratulation Your Product will be added');
      
      
      
      
  //          }
  //          return redirect()->back();
      
  //         }
     

    public function updatedesignation(Request $data){
      if(session()->get('type')=='Admin'){

        $product =Designation::find($data->input('id'));
        $product->name=$data->input('name');
        $product->designation=$data->input('designation');
        
  }
      $product->save();
      return redirect()->back()->with('success','Congratulation Your Product Update');
      
      
      
      return redirect()->back();
           }
          //  public function deletedesignation($id){
          //   if(session()->get('type')=='Admin'){
          //   $product=Designation::find($id);
          //   $product->delete();
          //   return redirect()->back()->with('success','Congratulation Your Product delete');
          //    }
          //    return redirect()->back();
          //   }
         
  
      
 
     public function updateProduct(Request $data){
        //dd($data);
        if(session()->get('type')=='Admin'){

      $product =Product::find($data->input('id'));
      $product->title=$data->input('title');
      $product->price=$data->input('price');
      $product->type=$data->input('type');
      $product->qunatity=$data->input('quantity');
    
      $product->category=$data->input('category');
      $product->description=$data->input('description');
      if($data->file('file')!=null){
      $product->picture=$data->file('file')->getClientOriginalName();
    $data->file('file')->move('uploads/products/',$product->picture);
}
    $product->save();
    return redirect()->back()->with('success','Congratulation Your Product Update');
    
    
    
    
         }
         return redirect()->back();

    
}
}