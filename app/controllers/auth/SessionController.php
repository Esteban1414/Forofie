<?php

namespace app\controllers\auth;

use app\controllers\Controller;
use app\classes\View;
use app\models\user;
use app\classes\Redirect;
class SessionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function iniSession($params = null)
    {
        $response = [
            'ua' => self::sessionValidate() ?? ['sv' => false],
            'title' => "Iniciar Sessión",
            'code' => 200
        ];
        View::render('auth/inisession', $response);
    }

    public function userAuth()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $user = new user;
        $stmt = $user->where([["name", $data['name']], ["passwd", $data['passwd']]])
            ->get();
        if (count(json_decode($stmt)) > 0) {
            echo $this->sessionRegister($stmt);
        } else {
            self::sessionDestroy();
            echo json_encode(["r" => false]);
        }
    }

    private function sessionRegister($r)
    {
        $data = json_decode($r);
        session_start();
        $_SESSION['sv'] = true;
        $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['id'] = $data[0]->id;
        $_SESSION['name'] = $data[0]->name;
        $_SESSION['passwd'] = $data[0]->passwd;
        $_SESSION['tipo'] = $data[0]->tipo;
        $_SESSION['activo'] = $data[0]->activo;
        session_write_close();
        return json_encode(["r" => true]);
    }

    public static function sessionValidate()
    {

        $user = new user;
        session_start();
        if (isset($_SESSION['sv']) && $_SESSION['sv'] == true) {
            $data = $_SESSION;
            $stmt = $user->where([["name", $data['name']], ["passwd", $data['passwd']]])
                ->get();
            if (count(json_decode($stmt)) > 0 && $data['IP'] == $_SERVER['REMOTE_ADDR']) {
                session_write_close();
                return ['name' => $data['name'], 'sv' => $data['sv'], 'id' => $data['id'], 'tipo' => $data['tipo']];
            } else {
                session_write_close();
                self::sessionDestroy();
                return null;
            }
        }
        session_write_close();
        self::sessionDestroy();
        return null;
    }

    private static function sessionDestroy()
    {
        session_start();
        $_SESSION = [];
        $_SESSION['sv'] = false;
        session_destroy();
        session_write_close();
        return;
    }

    public function logout(){
        $this->sessionDestroy();
        Redirect::to('Home');
        exit();
    }
}
