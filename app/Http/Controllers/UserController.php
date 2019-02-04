<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Model\User as UserModel;

class UserController extends Controller
{
    //
    private $insertRules = [ 
            'name' => ['bail','required', 'string', 'max:255'],
            'email' => ['bail','required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['bail','required', 'min:6'],
            'role' => ['bail','required','in:1,2']
        ];

    private $insertMsg = [
        'name.required' => "Tên không được bỏ trống !",
        'name.string' => "Tên phải là chữ !",
        'name.max' => "Tên tối đa 255 kí tự !",
        'email.required' => "Email không được bỏ trống !",
        'email.email' => "Email phải đsung định dạng !",
        'email.unique' => "Email đã tồn tại !",
        'password.required' => "Mật khẩu là bắt buộc !",
        'password.min' => "Mật khẩu tối thiểu 6 kí tự !",
        'role.required' => 'Bắt buộc phải phân quyền !',
        'role.in' => 'Giá trị không hợp lệ !',
    ];

     private $updateRules = [ 
            'name' => ['bail','required', 'string', 'max:255'],
            'email' => ['bail','required', 'string', 'email', 'max:255'],
            'role' => ['bail','required','in:1,2']
        ];

    private $updateMsg = [
        'name.required' => "Tên không được bỏ trống !",
        'name.string' => "Tên phải là chữ !",
        'name.max' => "Tên tối đa 255 kí tự !",
        'email.required' => "Email không được bỏ trống !",
        'email.email' => "Email phải đsung định dạng !",
        'role.required' => 'Bắt buộc phải phân quyền !',
        'role.in' => 'Giá trị không hợp lệ !',
    ];


	public function _getDocData($filter = [])
	{
		$user = new UserModel();
        $data = [];

		 foreach ($filter as $key => $value) 
        {
            if (empty($value)) {
                unset( $filter[$key] );
            }
        }

		try {
			$data = $user::where($filter)->get();
		} catch (\Exception $e) {
			// throw $e;
		}

		return $data;
	}

	public function userGetOne(Request $request)
	{
		$userId = $request->input('id');

		$user = new UserModel();

		$data = $this->_getDocData(['id' => $userId]);

		if ( count($data) == 0 ) {

            return response()->json(['msg'=>'Không tìm thấy thông tin Quản trị viên !', 'success'=>false]);
        }

        return response()->json(['msg'=>'Thành công !', 'success'=>true, 'data' => $data[0]]);
	}


	public function deleteUser(Request $request)
	{
		$user   = new UserModel();
        $userId = $request->input('id');

        if ($userId == Auth::id()) {
            Session::flash('error', 'Không thể xóa chính mình !'); 
            return redirect()->route('UserIndex');
        }

        $userUpdated = $user::where('id',$userId)->get(['role'])->toArray();
        
        if (count($userUpdated) > 0 && $userUpdated[0]['role'] == 1) {
            Session::flash('error', 'Không thể xóa Quản trị viên !'); 
            return redirect()->route('UserIndex');
        }

        try{

            $user::where('id',$userId)->delete();

            Session::flash('success', 'Xóa Quản trị viên thành công !'); 
            return redirect()->route('UserIndex');

        } catch(\Exception $e) {

            Session::flash('error', 'Xóa Quản trị viên không thành công !'); 
            return redirect()->route('UserIndex');
        }	
	}

    public function index()
    {
    	$data = [];
    	$data['title'] = "Danh sách Quản trị viên";
    	$data['users'] = $this->_getDocData();

    	return view('user/index')->with($data);
    }

    public function store(Request $request)
    {
    	$user = new UserModel();
    	$userId = $request->input('id');

    	$data = [
    		"name" => $request->input('name'),
			"email" => $request->input('email'),
            "role" => $request->input('role'),
			"password" => Hash::make($request->input('password')) ];

    	if (isset($userId)) 
    	{  
            
            $validator = Validator::make($request->all(), $this->updateRules, $this->updateMsg);

            $updateError = $validator->errors()->getMessages();

            $userUpdated = $user::where('id',$userId)->get(['role'])->toArray();

            if(count($userUpdated) != 0 && $userUpdated[0]['role'] == 1 &&  $request->input('role') == 2 && Auth::id() != $userId)
            {
                $updateError['role'][] = 'Không thể cập nhật quyền người kiểm duyệt của QTV này';
            }            

            if ( count($updateError) > 0 ) {
                  return response()->json(['msg'=>'Lỗi !', 'validate'=>false, 'data' => $updateError ]);
            }
    		try{
    			$user::where('id',$userId)->update([
    				"name" => $request->input('name'),
                    "email" => $request->input('email'),
					"role" => $request->input('role'),
    			]);
          
                Session::flash('success', 'Cập nhật Quản trị viên thành công !'); 
                return response()->json(['msg'=>'Thành công !', 'success'=>true]);
    		} catch(\Exception $e) {
                 return response()->json(['msg'=>'Cập nhật Quản trị viên thấtt bại !', 'success'=>false]);
    		}	
    	} else 
    	{

            $validator = Validator::make($request->all(), $this->insertRules, $this->insertMsg);

            if ( $validator->fails() ) {
                  return redirect()->route('UserIndex')->withErrors($validator)->withInput();
                  // return response()->json(['msg'=>'Lỗi !', 'validate'=>false, 'data' => $validator->errors()->getMessages() ]);
            }

    		try{
    			$user::insert($data);

    		    Session::flash('success', 'Thêm Quản trị viên thành công !'); 
                return redirect()->route('UserIndex');
            } catch(\Exception $e) {
                Session::flash('error', 'Thêm Quản trị viên thất bại !'); 
                return redirect()->route('UserIndex');
            }   
    	}
    }
}
