<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Student;
use app\index\model\Admin;
use app\index\model\Officer;
use app\index\model\Test_style;
use think\Request;

class OfficerController extends Controller
{
	public function index() {
        $officer_id = Request::instance()->param('officer_id');
        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();
        $this->assign('officer', $Officer);
    	return $this->fetch();
    }

    public function personcenter() {
        $officer_id = Request::instance()->param('officer_id');
        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();
        $this->assign('officer', $Officer);
    	return $this->fetch();
    }

    public function updateperson() {
        $officer_id = Request::instance()->param('officer_id');
        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();
        $param = Request::instance()->post();
        $Officer->password = $param['newPassword'];
        if($Officer->save()){
            return $this->success('密码更改成功', url('index', ['officer_id' => $Officer->officer_id]));
        }
    }

    public function subject() {
        $officer_id = Request::instance()->param('officer_id');
        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();
        
        $Test_style = new Test_style;
        $subject = $Test_style->where('officer_id', $officer_id)->select();

        $this->assign('subject', $subject);
        $this->assign('officer', $Officer);
    	return $this->fetch();
    }

    public function saveAndShowSubject() {
        $param = Request::instance()->post();
        $officer_id = Request::instance()->param('officer_id');

        $Test_style = new Test_style;
        $Test_style->name = $param['name'];
        $Test_style->start_date = $param['start_date'];
        $Test_style->end_date = $param['end_date'];
        $Test_style->introduce = $param['introduce'];
        $Test_style->officer_id = $officer_id;

        if($Test_style->save()) {
            return $this->success('科目添加成功', url('subject', ['officer_id' => $officer_id]));
        }
    }

    public function editSubject() {
        $officer_id = Request::instance()->param('officer_id');
        $test_style_id = Request::instance()->param('test_style_id');
        $Test_style = new Test_style;
        $subject = $Test_style->where('officer_id', $officer_id)->where('test_style_id', $test_style_id)->find();
        $this->assign('test_style', $subject);
        return $this->fetch();
    }

    public function deleteSubject() {
        $officer_id = Request::instance()->param('officer_id');
        $test_style_id = Request::instance()->param('test_style_id');
        $Test_style = new Test_style;
        $subject = $Test_style->where('officer_id', $officer_id)->where('test_style_id', $test_style_id)->find();
        if($subject->delete()) {
            return $this->success('科目添加成功', url('subject', ['officer_id' => $officer_id]));
        }
    }

    public function stumassage() {
    	return $this->fetch();
    }

    public function stuPassword() {
        $password = Request::instance()->param('password');
        $officer_id = Request::instance()->param('officer_id');
        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();

        $this->assign('password', $password);
        $this->assign('officer', $Officer);
        return $this->fetch();
    }

    public function searchPassword() {
        $param = Request::instance()->post();
        $stu_idcard = $param['idcard'];
        $officer_id = $param['officer_id'];
        $Student = new Student;
        $student = $Student->where('idcard' , $stu_idcard)->find();
        return $this->success('查找成功', url('stuPassword', ['password' => $student['password'],'officer_id' => $officer_id]));
    }
}