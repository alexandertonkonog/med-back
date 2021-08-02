<? 

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use App\Models\User;

class AuthService {
    public function create($data) {
        $body = [
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'name' => $data['name'],
            'type' => $data['type']
        ];
        $user = User::create($body);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }

    public function getToken($data) {
        $issuedAt   = new \DateTimeImmutable();
        $expire     = $issuedAt->modify('+90 days')->getTimestamp();
        $serverName = env('APP_URL', false);

        $serviceInfo = [
            'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
            'iss'  => $serverName,                       // Issuer
            'nbf'  => $issuedAt->getTimestamp(),         // Not before
            'exp'  => $expire,                           // Expire
        ];
        $key = env('JWT_SECRET', false);
        $jwt = JWT::encode(array_merge($data->toArray(), $serviceInfo), $key, 'HS256');
        return $jwt;
    }

    public function getData($token) {
        $key = env('JWT_SECRET', false);
        $decoded = JWT::decode($token, $key, 'HS256');
        return $decoded;
    }

    public function getUser($data) {
        $user = User::where('email', $data['email'])->first();
        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                return array('token' => $this->getToken($user), 'data' => $user);
            } else {
                return false;
            }
        }
    }
}