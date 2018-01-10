<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Student;
use think\Request;
use app\index\model\Admin;
use app\index\model\Officer;

class AdminController extends Controller
{
	public function index() {
        $admin_id = Request::instance()->param('admin_id');
        $Admin = new Admin;
        $admin = $Admin->where('admin_id', $admin_id)->find();
		$pageSize = 5;

		$Officer = new Officer;
		$Officers = $Officer->paginate($pageSize);

        $this->assign('admin', $admin);
		$this->assign('officers', $Officers);

    	return $this->fetch();
    }

    public function personcenter() {
    	$admin_id = Request::instance()->param('admin_id');
        $Admin = new Admin;
        $admin = $Admin->where('admin_id', $admin_id)->find();
        $this->assign('admin', $admin);
    	return $this->fetch();
    }

    public function updatepersondata() {
    	$param = Request::instance()->post();
    	$admin_id = Request::instance()->param('admin_id');
        $Admin = new Admin;
        $admin = $Admin->where('admin_id', $admin_id)->find();
    	$admin->account = $param['account'];
    	$admin->password = $param['password'];
    	if($admin->save()) {
    		return $this->success('修改成功', url('index', ['admin_id' => $admin->getData('admin_id')]));
    	} else {
    		return $this->success('修改成功', url('index', ['admin_id' => $admin->getData('admin_id')]));
    	}
    }

    public function officeradd() {
        return $this->fetch();
    }

    public function officersave() {
        $param = Request::instance()->post();
        $officer = new Officer;
        $officer->name = $param['name'];
        $officer->account = $param['account'];
        $officer->password = $param['password'];

        if($officer->save()) {
            return $this->success('新增成功', url('index'));
        }
    }

    public function officerdelete() {
        $officer_id = Request::instance()->param('officer_id');
        $officer = new Officer;
        $off = $officer->where('officer_id', $officer_id)->find();
        if($off->delete()) {
            return $this->success('更改成功', url('index'));
        } else{
            return $this->error('无法删除，因为改管理员还有管理考试科目', url('index'));
        }
    }

    public function officerupdata() {
        $param = Request::instance()->post();
        $officer_id = Request::instance()->param('officer_id');
        $officer = new Officer;
        $off = $officer->where('officer_id', $officer_id)->find();
        $off->name = $param['name'];
        $off->account = $param['account'];
        $off->password = $param['password'];

        if($off->save()) {
            return $this->success('更改成功', url('index'));
        }
    }   

    public function officerEdit() {
        $officer_id = Request::instance()->param('officer_id');
        $officer = new Officer;
        $off = $officer->where('officer_id', $officer_id)->find();
        $this->assign('officer', $off);
        return $this->fetch();
    } 

    public function baokaoMassage() {
        return $this->fetch();
    }

    public function stuScore() {
        return $this->fetch();
    }

    public function testNotice() {
        return $this->fetch();
    }
}