<?
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    function __construct(AuthService $service) {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $result = $this->service->getUser($data);
        
        if ($result) {
            return $result;
        } else {
            return response(['message' => 'Неправильный логин или пароль'], 401);
        }
    }

    public function me(Request $request)
    {
       return Auth::user();
    }

    public function register(RegisterRequest $request)
    {   
        $data = $request->validated();
        
        $result = $this->service->create($data);
        $jwt = $this->service->getToken($result);

        return array('data' => $result, 'token' => $jwt);
    }
}
