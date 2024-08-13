<?php

namespace App\Http\Controllers;
use App\Models\Login;
//use App\Models\Order;
//use App\Models\OrderItem;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Testing;



use App\Models\Product;

//use App/Models/Cart;
// use App\Http\Controllers\quantity;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\DbCommand;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB as FacadesDB;

use function PHPSTORM_META\type;

class MainController extends Controller
{
public function index(){
    $allProduct=Product::all();
    $newArrival=Product::where('type','new-arrivals')->get();
    $hotSale=Product::where('type','sale')->get();
    // $allProduct=Product::where('type','Best Sellers')->get();
    return view('index',compact('allProduct','hotSale','newArrival'));


   
    return view('index');
} 
public function cart(){
    $cartItems = DB::table('products')
    ->join('carts','carts.productId','products.id')
    ->select('products.title','products.price','products.picture','carts.*')
    ->where('carts.customerId',session()->get('id'))
    ->get();
    return view('cart',compact('cartItems'));
    
} 

public function shop(){
    return view('shop');
} 
public function singleProduct($id){
    $product=Product::find($id);
    return view('singleProduct', compact('product'));
} 
public function testmail(){
    $details=[
        'title'=>'This is a testing mail',
        "message"=>'hello this is msg',
    ];
    Mail::to("sattarmusadiq@gmail.com")->send(new Testing($details));
    return redirect('/');
}
public function deleteCartItem($id){
    $item=Cart::find($id);
    $item->delete();
    return redirect()->back()->with('success','1 item has been delete from the cart');
} 

public function register(){
    return view('register');
} 




public function login(){
    return view('login');
}



public function logout(){
    session()->forget('id');
    session()->forget('type');
    return redirect('/login');
} 

public function loginUser(Request $data){

$user=Login::where('email', $data->input('email'))->where('password',$data->input('password'))->first();
if($user){
    session()->put('id',$user->id);
    session()->put('type',$user->type);
    if($user->type=='Customer'){
        return redirect('/');
    }
    else if($user->type=='Admin'){
        return redirect('admin');
    }
}
else{
    return redirect('login')->with('error','Login again');       

}
}

public function registerUser(Request $data){
    $newUser=new Login();
    $newUser->fullname=$data->input('fullname');
    $newUser->email=$data->input('email');
    $newUser->password=$data->input('password');
    $newUser->picture=$data->file('file')->getClientOriginalName();
    $data->file('file')->move('uploads/profiles/',$newUser->picture);
    $newUser->type="Customer";
    if($newUser->save()){
 return redirect('login')->with('success','Your Account Successfully Login');       
    }
}

public function addToCart(Request $data){
   if(session()->has('id')){
    $item= new Cart();
    $item->quantity=$data->input('quantity');
    $item->productId=$data->input('id');
    $item->customerId=session()->get('id');
    $item->save();
    return redirect()->back()->with('success','Congratulation Item Will Be Added Into The Cart');


   }
   else{
    return redirect('login')->with('error','Please Log to Syaytem');
   }

    
}
public function updateCart(Request $data){
    if(session()->has('id')){
     $item=Cart::find($data->input('id'));
     $item->quantity=$data->input('quantity');
     //$item->productId=$data->input('id');
     //$item->customerId=session()->get('id');
     $item->save();
     return redirect()->back()->with('success','Sucesss update item qty');
 
 
    }
    else{
     return redirect('login')->with('error','Please Log to Syaytem');
    }
 
     
 }
 public function checkout(Request $data){
    if(session()->has('id')){
     $order = new Order();
     $order->status="pending";
     $order->customerId=session()->get('id');
     $order->bill=$data->input('bill');
     $order->address=$data->input('address','');
     $order->phone=$data->input('phone');

     $order->fullname=$data->input('fullname');
     if($order->save()){
        $carts=Cart::where('customerId',session()->get('id'))->get();
        foreach($carts as $item){
            $product=Product::find($item->productId);
            $orderItem = new OrderItem();
            $orderItem->productId=$item->productId;
            $orderItem->quantity=$item->quantity;
            $orderItem->price=$product->price;
            $orderItem->orderId=$order->id;
            $orderItem->save();
            $orderItem->delete();

        }
     }

     
     return redirect()->back()->with('success','success order place');
 
 
    }
    else{
     return redirect('login')->with('error','Please Log to Syaytem');
    }
 
     
 }
}



