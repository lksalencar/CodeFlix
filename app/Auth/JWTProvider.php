<?php

namespace CodeFlix\Auth;
use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;

/**
 * Class JWTProvider
 *
 * @package \CodeFlix\Auth
 */
class JWTProvider extends  Authorization
{
    private $jwt;

    /**
     * JWTProvider constructor.
     * @param JWT $JWT
     */
    public function __construct(JWT $JWT)
    {
        $this->jwt = $JWT;
    }


    /**
     * Get the providers authorization method.
     *
     * @return string
     */
    public function getAuthorizationMethod()
    {
        return 'bearer';
    }

    /**
     * Authenticate the request and return the authenticated user instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        try{
            return \Auth::guard('api')->authenticate();//token, não deu certo
        }catch (AuthenticationException $exception){
            $this->refreshToken();
            return \Auth::guard('api')->user();
        }
    }
    protected function refreshToken()
    {
        $token = $this->jwt->parseToken()->refresh();
        $this->jwt->setToken($token);
    }
}
