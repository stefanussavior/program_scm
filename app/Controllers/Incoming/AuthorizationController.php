<?php

namespace App\Controllers\Incoming;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthorizeModel;

class AuthorizationController extends BaseController
{
    public function Login() {
        $session = session();
        $userModel = new AuthorizeModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $data = $userModel->where('email', $email)->first();
        if ($data) {
            $ses_data = [
                'email' => $data['email'],
                'password' => $data['password'],
                'logged_in' => TRUE
            ];
            $session->set($ses_data);
            return redirect()->to(base_url('/dashboard'));
        } else {
            return redirect()->to(base_url('/'));
        }
    }

    public function Logout() {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }

    public function Dashboard() {
        return view('dashboard/dashboard');
    }
}
