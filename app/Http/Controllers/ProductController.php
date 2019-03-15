<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
 
use Illuminate\Support\Facades\Hash;
 
use Illuminate\Http\Request;
 
use App\User;
use App\Product;
use App\UploadFile;
use DB;
use Auth;




class ProductController extends Controller
{

    public function __construct(){
        //
    }

    public function sendError($error, $errorMessages = [], $code = 404){
    	$response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    public function addProduct(Request $req){
        // Api to Insert into  Product Table
        $addProduct = Product::create([
                'user_id' => Auth::user()->id,
                'route' => $req->input('route'),
                'qty' => $req->input('qty'),
                'unit_price' => $req->input('unit_price'),
                'amount' => $req->input('amount'),
                'total' => $req->input('total'),
                'username' => $req->input('username')
             ]);

           if($addProduct){
                return response()->json([
                    'success' =>true,
                    'message' => 'Product Record Added Successfully!',
                    'data' => $addProduct
                ], 200);
            } else {
                return response()->json([
                    'success' =>false,
                    'message' => 'Fails to Added Product!',
                    'data' => $addProduct
                ], 400);
            }
    }

    // Api to Fetch data from product Table by ID
   public function getProductId($id){
        $result = User::find($id);
        return response()->json($result);
    }

    public function al(Request $request, $id){
        $user = User::find($id);
        $product = Product::find($id);
        // $product = Product::where('user_id', '=', $id);        
        return response()->json(
            [
                'success'=> "true",
                'User_Record' => 
                    [ 'User_BioData'=> $user,
                        'Product_details' => ['amount' => $product->amount, 'route' => $product->route],
                    ],
            ], 201);
        //     // 'api-key' => $user->api_token,
        
    }

    public function uploadFile(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'picture' => 'required|max:2048|mimes:jpeg,png,jpg,gif,doc,docx'
        ]);
        // $response = $this->validate($request, [
        //     'username' => 'required',
        //     'picture' => 'required|max:2048|mimes:jpeg,png,jpg,gif,doc,docx'
        // ]);

        if($request->hasFile('picture')){
            $destinationPath = "public/uploads/images";
            $file = $request->picture;
            // $file = input::file('picture');
            $extension = $file->getClientOriginalExtension();
            // $fileName = $file.".".$extension;
            $fileName = rand(1111111, 9999999).".".$extension;
            $file->move($destinationPath,$fileName);
            $name = $fileName;
            }
            $uploadfile = new UploadFile();
            $uploadfile->username = $request->input('username');
            $uploadfile->picture = $name;
            $uploadfile->video = "testing.mp4";
            $uploadfile->save();
            if($uploadfile->save()){
                //$id = $uploadfile->id;
                // $user = User::where('id', $id)->first();

                return response()->json([
                    'success' =>true,
                    'message' => 'File Upload Successfully!',
                    'data' => $uploadfile
                ], 200);
            } else {
                return response()->json([
                    'success' =>false,
                    'message' => 'Fails to Upload File!',
                    //'data' => $uploadfile
                ], 400);
            }  
    }

    // Api to Fetch all product
    public function viewAllProduct(){
        $result = UploadFile::all();
        return response()->json($result);
    }

    // Api to Fetch users and all product belongs to User
    public function vv(Request $request, $id){
        $user = User::where('id', $id)->first(); 
        $product = User::find($id)->products()->get(); 
        if(!$user && !$product)  {
            return response()->json(
                [
                    'error'=> "false",
                    'Records' => [ 'Record not found'],
                    
                ], 404); 
        }  else {
            return response()->json(
            [
                'success'=> "true",
                'User_Detail' => [
                    'firstname' =>$user->firstname,
                    'email' =>$user->email,
                    'Product_Record' => $product
                ],
                
            ], 201);
        }  
        
    }

}
