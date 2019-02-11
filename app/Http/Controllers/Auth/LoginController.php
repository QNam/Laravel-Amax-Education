<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Model\HistoryUpdate as HistoryUpdateModel;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
      
    }

    public $rules = ['email' => 'bail|required|email',
                    'password' => 'required'];
    public $msg = ['email.required' => 'Email không được bỏ trống !',
                   'email.email' => 'Email phải đúng định dạng !',
                   'password.required' => "Mật khẩu không được bỏ trống !" ];

    public function index()
    {
        $data = [];

        $data['title'] = "Amax Education";

        return view('login')->with($data);
    }

   public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($request->all(), $this->rules, $this->msg);

        if ( $validator->fails() ) {
          return redirect()->route('login')->withErrors($validator)->withInput();
        }

        $updater = new HistoryUpdateModel();

        if (Auth::attempt($credentials)) {
            
            if($updater->ckeckConditionUpdate() ) {

              Session::flash('swu_mess', "Hệ thống tự động tăng khối của học sinh sẽ tự động chạy sau ".$updater::DELAY_TO_UPDATE."s. Không chuyển hướng trang !");
              Session::flash('student_will_update', '1');  
            }

            return redirect()->route($this->redirectTo);
        } else {
          return redirect()->route('login')->withErrors(['login'=> "Sai Mật khẩu hoặc Email đăng nhập !"])->withInput();
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();            
        }

        // Tại sao lại chuyển hướng về trang chủ
        // Vấn đề ở đây là gì ? khi logout người dùng có thể ấn back trên trình duyệt để quay trở lại trang trc 
        // Có thể giải quyết vấn đề này bằng cách xóa cache hoặc dùng trick như dưới chuyển huwongs về trang chủ
        // lúc này nó sẽ tự động logout và trang trc (khi ấn back) đó là trang login 
        return redirect()->route('index');  
    }
}
