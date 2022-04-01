<?php

namespace App\Libraries;

use App\Libraries\Token;
//use App\Models\AppointmentsModel;

class Authentication
{
    private $user;

    public function login($email, $password, $remember_me)
    {
        $model = new \App\Models\UsersModel;

        $user = $model->findByEmail($email);

        if ($user === null) {

            return false;
        }

        if (!$user->verifyPassword($password)) {

            return false;
        }

        $this->logInUser($user);

        if ($remember_me) {

            $this->rememberLogin($user->id);
        }

        return true;
    }

    private function logInUser($user)
    {
        $session = session();
        $session->regenerate();
        $session->set('user_id', $user->id);
        $session->set('user_level', $user->level);
    }

    private function rememberLogin($user_id)
    {
        $model = new \App\Models\RememberedLoginModel;

        list($token, $expiry) = $model->rememberUserLogin($user_id);

        $response = service('response');

        $response->setCookie('remember_me', $token, $expiry);
    }

    public function logout()
    {
        $token = service('request')->getCookie('remember_me');

        if ($token !== null) {

            $model = new \App\Models\RememberedLoginModel;

            $model->deleteByToken($token);
        }

        service('response')->deleteCookie('remember_me');

        session()->destroy();
    }

    private function getUserFromSession()
    {
        if (!session()->has('user_id')) {

            return null;
        }

        $model = new \App\Models\UsersModel;

        $user = $model->find(session()->get('user_id'));

        if ($user && $user->is_active) {

            return $user;
        }
    }

    private function getUserFromRememberCookie()
    {
        $request = service('request');

        $token = $request->getCookie('remember_me');

        if ($token === null) {

            return null;
        }

        $remembered_login_model = new \App\Models\RememberedLoginModel;

        $remembered_login = $remembered_login_model->findByToken($token);

        if ($remembered_login === null) {

            return null;
        }

        $user_model = new \App\Models\UsersModel;

        $user = $user_model->find($remembered_login['user_id']);

        if ($user) {

            $this->logInUser($user);

            return $user;
        }
    }

    public function getCurrentUser()
    {
        if ($this->user === null) {

            $this->user = $this->getUserFromSession();
        }

        if ($this->user === null) {

            $this->user = $this->getUserFromRememberCookie();
        }

        return $this->user;
    }

    public function isLoggedIn()
    {
        return $this->getCurrentUser() !== null;
    }

    public function validateToken($token)
    {

        $newToken = new Token($token);
        $hash = $newToken->getHash();

        $model = new \App\Models\AppointmentsModel;

        $appointment = $model->where('activation_hash', $hash)->first();

        if ($appointment === null) {

            $response = service('response');
            $response->setStatusCode(403);
            $response->setBody('You do not have permission to access that resource');

            $response->send();

            exit();
        }

        return $appointment;
    }
}
