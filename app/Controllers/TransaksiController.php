<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
	protected $table = 'product'; 
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'nama','harga','jumlah','foto','created_at','updated_at'
	];  
}
<div class="row">
    <?php foreach ($product as $key => $item) : ?>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <img src="<?php echo base_url() . "img/" . $item['foto'] ?>" alt="..." width="300px">
                    <h5 class="card-title"><?php echo $item['nama'] ?><br><?php echo $item['harga'] ?></h5>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password', 'role', 'created_at', 'updated_at'
    ];
}
public function login()
{
    if ($this->request->getPost()) {
        $rules = [
            'username' => 'required|min_length[6]',
            'password' => 'required|min_length[7]|numeric',
        ];

        if ($this->validate($rules)) {
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $dataUser = $this->user->where(['username' => $username])->first(); //pasw 1234567

            if ($dataUser) {
                if (password_verify($password, $dataUser['password'])) {
                    session()->set([
                        'username' => $dataUser['username'],
                        'role' => $dataUser['role'],
                        'isLoggedIn' => TRUE
                    ]);

                    return redirect()->to(base_url('/'));
                } else {
                    session()->setFlashdata('failed', 'Kombinasi Username & Password Salah');
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('failed', 'Username Tidak Ditemukan');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('failed', $this->validator->listErrors());
            return redirect()->back();
        }
    }

    return view('v_login');
}