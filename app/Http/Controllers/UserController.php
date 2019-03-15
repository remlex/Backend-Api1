<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
 
use Illuminate\Support\Facades\Hash;
 
use Illuminate\Http\Request;
 
use App\User;
use App\School;
use App\Product;
use DB;
use Auth;



class UserController extends Controller
{

    public function __construct(){
        //
    }

    // public function sendResponse($result, $message){
    // 	$response = [
    //         'success' => true,
    //         'data'    => $result,
    //         'message' => $message,
    //     ];
    //     return response()->json($response, 200);
    // }

    // public function sendError($error, $errorMessages = [], $code = 404){
    // 	$response = [
    //         'success' => false,
    //         'message' => $error,
    //     ];
    //     if(!empty($errorMessages)){
    //         $response['data'] = $errorMessages;
    //     }
    //     return response()->json($response, $code);
    // }

    public function addUser(Request $req){

        // Api to Insert into  User Table
        $api_token = base64_encode(str_random(40));
        $addUser = User::create([
                'firstname' => strip_tags($req->input('firstname')),
                'lastname' => strip_tags($req->input('lastname')),
                'email' => strip_tags($req->input('email')),
                'phone' => strip_tags($req->input('phone')),
                'address' => strip_tags($req->input('address')),
                'username' => strip_tags($req->input('username')),
                'roles' => $req->input('roles'),
                'type' => $req->input('type'),
                'status' => $req->input('status'),
                'password' => app('hash')->make($req['password']), //bcrypt($req['password']),
                'api_token' => $api_token,
             ]);

           if($addUser){
                return response()->json([
                    'success' =>true,
                    'message' => 'User Record Added Successfully!',
                    'data' => $addUser
                ], 200);
            } else {
                return response()->json([
                    'success' =>false,
                    'message' => 'Fails to Added User!',
                    'data' => $addUser
                ], 400);
            }
    }

   
    // Api for Login Authentication
    public function authenticate(Request $request){
       $this->validate($request, [
       'email' => 'required',
       'password' => 'required'
        ]);
      $user = User::where('email', $request->input('email'))->first();
        if(Hash::check($request->input('password'), $user->password)){
            $apikey = base64_encode(str_random(40));
            User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);;
            return response()->json(['status' => 'success','Username' => $user->username, 'api_token' => $apikey, 'Date Created' => $user->created_at]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }
    }

    // Api to Fetch all data school
    public function viewAllSchool(){
        $result = User::all();
        return response()->json($result);
    }

    // Api to Fetch data from school Table by ID
   public function viewRegister($id){
        $result = User::find($id);
        return response()->json($result);
    }

     // Api to Update Record
    public function updateUser(Request $req, $id){
        try{
                $updUser = User::find($id);
                $updUser->firstname = $req->firstname;
                $updUser->lastname = $req->lastname;
                $updUser->email = $req->email;
                $updUser->phone = $req->phone;
                $updUser->address = $req->address;
                $updUser->username = $req->username;
                $updUser->roles = $req->roles;
                $updUser->type = $req->type;
                $updUser->status = $req->status;
                // $updUser->password = app('hash')->make($req['password']);
                if($updUser->save()){
                   return response()->json(['data' => 'Updated Successfully'], 200);
                }
            }catch(Exception $e){
                return response()->json([
                    'success' =>false,
                    'message' => 'Record not Exist',
                ], 400);
            }
    }

    public function deleteUser($id){
        //$deleteUser = User::find($id);
        $deleteUser = User::where('id', $id)->delete();
        if($deleteUser){                    
            return response()->json(['data' => 'Deleted Successfully'], 200);
        }else{
            return response()->json(['data' => 'Could Deleted Successfully'], 401);               
        }
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

    public function al($id){
        // $result = User::where('id', '=', $id)
        //             ->whereHas('products', function($query){
        //                 $query->where('user_id', '=', $id);
        //             })->get();
        // return response()->json(
        //     [
        //         'success'=> "true",
        //         'User_Record' => [ 
        //             'User_BioData'=> $result,
        //             'Product_details' => [
        //                 'amount' => $result->amount, 
        //                 'route' => $result->route
        //             ],
        //         ],
        //     ], 201);        
    }

    // public function update(Request $request, $id){
    //     $input = $request->all();
    //     $validator = Validator::make($input, [
    //         'name' => 'required',
    //         'description' => 'required'
    //     ]);
    //     if($validator->fails()){
    //         return $this->sendError('Validation Error.', $validator->errors());       
    //     }
    //     $post = Post::find($id);
    //     if (is_null($post)) {
    //         return $this->sendError('Post not found.');
    //     }
    //     $post->name = $input['name'];
    //     $post->description = $input['description'];
    //     $post->save();
    //     return $this->sendResponse($post->toArray(), 'Post updated successfully.');
    // }

}
