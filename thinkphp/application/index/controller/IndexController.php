<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Student;
use app\index\model\Admin;
use app\index\model\Officer;
use app\index\model\Test_style;
use think\Request;

class IndexController extends Controller
{
    public function login()
    {
    	$param = Request::instance()->post();

        if(!empty($param['officer'])) {
            $map = array('account' => $param['idcard']);
            $Officer = Officer::get($map);
            if (!is_null($Officer) && $Officer->getData('password') === $param['password']) {
                session('officerId', $Officer->getData('officer_id'));
                return $this->success('Officer login success', url('officer/index', ['officer_id' => $Officer->getData('officer_id')]));
            } else {
                return $this->error('username not exist', url('index'));
            }
        } else if(!empty($param['admin'])){
            $map = array('account' => $param['idcard']);
            $Admin = Admin::get($map);
            if (!is_null($Admin) && $Admin->getData('password') === $param['password']) {
                session('adminId', $Admin->getData('admin_id'));
                return $this->success('Admin login success', url('admin/index', ['admin_id' => $Admin->getData('admin_id')]));
            } else {
                return $this->error('username not exist', url('index'));
            }
        } else {
        	$map = array('idcard' => $param['idcard']);
        	$Student = Student::get($map);

        	if (!is_null($Student) && $Student->getData('password') === $param['password']) {
        		session('studentId', $Student->getData('stu_id'));
                return $this->success('login success', url('Candidates/index', ['stu_Id' => $Student->getData('stu_id')]));
        	} else {
        		return $this->error('username not exist', url('index'));
        	}
        }
    }

    public function index() {
    	 return $this->fetch();
    }

    public function registered() {
        
    	return $this->fetch();
    }

    public function judgeregist() {
        $param = Request::instance()->post();
        // 判断两次输入密码是否相同
        if($param['password'] !== $param['password']) {
            var_dump('1');
            return $this->error('确认密码与原密码不同', url('registered'));
        } else {
            $Student = new Student();
            $Student->name = $param['name'];
            $Student->idcard = $param['idcard'];
            $Student->stu_style = $param['xueke'];
            $Student->password = $param['password'];

            if($Student->save()) {
                return $this->success('注册成功，请登录', url('index'));
            }
        }
    }

    public function logout() {
        if($this->sessout()) {
            return $this->success('退出成功！', url('index'));
        } else {
            return $this->error('退出失败！');
        }
    }

    public function sessout() {
        session('studentId', null);
        session('officerId', null);
        session('adminId', null);
        return true;
    }
}
