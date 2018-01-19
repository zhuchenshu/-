<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Student;
use app\index\model\Admin;
use app\index\model\Officer;
use app\index\model\Test_style;
use app\index\model\Student_test;
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
        $Test_style->test_time = $param['test_time'];
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

    public function viewStudent() {
        $officer_id = Request::instance()->param('officer_id');
        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();

        $test_style = new Test_style;
        $stu = array();
        $tests = $test_style->where('officer_id', $officer_id)->select();
        for($s=0;$s<sizeof($tests);$s++) {
            $student_test = new Student_test;
            $student = $student_test->where('test_id',$tests[$s]->test_style_id)->select();
            for($c=0;$c<sizeof($student);$c++) {
                $Student = new Student;
                $Students = $Student->where('stu_id',$student[$c]->stu_id)->find();

                $stu[$c] = $Students;
            } 
        }

        $this->assign('student', $stu);
        $this->assign('officer', $Officer);
        return $this->fetch();
    }

    public function showScore() {
        $officer_id = Request::instance()->param('officer_id');
        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();
        $this->assign('officer', $Officer);
        return $this->fetch();
    }

    public function studentTestPlace() {
        $officer_id = Request::instance()->param('officer_id');
        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();
        $this->assign('officer', $Officer);
        return $this->fetch();
    }

    public function studentdetil() {
        $officer_id = Request::instance()->param('officer_id');
        $stu_id = Request::instance()->param('stu_id');

        $Student = new Student;
        $student = $Student->where('stu_id',$stu_id)->find();

        $Officer = new Officer;
        $Officer = $Officer->where('officer_id', $officer_id)->find();

        $this->assign('officer', $Officer);
        $this->assign('student', $student);
        return $this->fetch();
    }
}