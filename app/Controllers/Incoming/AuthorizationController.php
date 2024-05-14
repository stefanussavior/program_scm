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
        $nik = $this->request->getPost('nik');
        $password = $this->request->getPost('password');
        $data = $userModel->where('nik', $nik)->first();

        if (!$nik || !$password) {
            return redirect()->to(base_url('/'));
        } else {
            if ($data) {
                $ses_data = [
                    'nik' => $data['nik'],
                    'password' => $data['password'],
                    'nama' => $data['nama'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to(base_url('/dashboard'));
            } else {
                return redirect()->to(base_url('/'));
            }
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
