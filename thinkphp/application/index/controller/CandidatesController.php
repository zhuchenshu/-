<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Student;
use app\index\model\Award;
use app\index\model\Test_style;
use app\index\model\Student_test;
use think\Request;

class CandidatesController extends Controller
{
	public function index() {
        $stu_id = Request::instance()->param('stu_Id');
        $Student = new Student;
        $student = $Student->where('stu_id', $stu_id)->find();
        $test_style = new Test_style;

        $test_styles = $test_style->select();
        //删除已删除的科目
        $Student_test = new Student_test;
        $tests = $Student_test->where('stu_id', $stu_id)->select();
        for( $i = 0;$i < sizeof($test_styles); $i++) {
            for( $j = 0; $j < sizeof($tests); $j++) {
                if($test_styles[$i]->test_style_id == $tests[$j]->test_id) {
                    unset($test_styles[$i]);
                }
            }
        }

        $this->assign('test_style', $test_styles);
        $this->assign('student', $student);

    	return $this->fetch();
    }

    public function person() {
        $stu_id = Request::instance()->param('stu_id');
        $Student = new Student;
        $student = $Student->where('stu_id', $stu_id)->find();
        $this->assign('student', $student);
    	return $this->fetch();
    }


    public function revisePassword() {
        $param = Request::instance()->post();
        $Student = new Student;
        $student = $Student->where('stu_id', $param['stu_id'])->find();

        $student->password = $param['newPassword'];
        if($student->save()) {
            return $this->success('更改成功', url('index', ['stu_Id' => $student->stu_id]));
        }
    }

    public function permasage() {
        $stu_id = Request::instance()->param('stu_id');
        $Student = new Student;
        $student = $Student->where('stu_id', $stu_id)->find();
        $this->assign('student', $student);
    	return $this->fetch();
    }

    public function basemasage() {
        $stu_id = Request::instance()->param('stu_id');
        $Student = new Student;
        $student = $Student->where('stu_id', $stu_id)->find();
        $this->assign('student', $student);
    	return $this->fetch();
    }

    public function wanshan() {
        $param = Request::instance()->post();
        $stu_id = Request::instance()->param('stu_id');
        $Student = new Student;
        $student = $Student->where('stu_id', $stu_id)->find();
        $student->graduate_time = $param['graduate_time'];
        $student->language_style = $param['language_style'];
        $student->sex = $param['sex'];
        $student->phone = $param['phone'];
        $student->address = $param['address'];
        $student->email = $param['email'];

        if($student->save()) {
            return $this->success('保存成功', url('index', ['stu_Id' => $student->stu_id]));
        }
    }

    public function winer() {
        $stu_id = Request::instance()->param('stu_id');

        $Student = new Student;
        $student = $Student->where('stu_id', $stu_id)->find();
        $winer = new Award;
        $award = $winer->where('student_id', $stu_id)->find();
        if(empty($award)) {
            $award = new Award;
            $award->student_id = $stu_id;
            $award->save();
            $award = $winer->where('student_id', $stu_id)->find();
        }
        $this->assign('student', $student);
        $this->assign('award', $award);
    	return $this->fetch();
    }

    public function saveaward() {
        $param = Request::instance()->post();

        $winer = new Award;
        $award = $winer->where('student_id', $param['stu_id'])->find();
        if(empty($award)) {
            $Award = new Award;
        } else {
            $Award = $award;
        }

        $Award->name1 = $param['name1'];
        $Award->date1 = $param['date1'];
        $Award->name2 = $param['name2'];
        $Award->date2 = $param['date2'];
        $Award->name3 = $param['name3'];
        $Award->date3 = $param['date3'];
        $Award->name4 = $param['name4'];
        $Award->date4 = $param['date4'];
        $Award->name5 = $param['name5'];
        $Award->date5 = $param['date5'];
        
        $Award->student_id = $param['stu_id'];
        $Award->save();
                
        return $this->success('保存成功', url('index', ['stu_Id' => $param['stu_id']]));
    }

    public function judgeaward() {

    }

    public function study() {
        return $this->fetch();
    }

    public function family() {
        return $this->fetch();
    }

    public function social() {
        return $this->fetch();
    }

    public function techang() {
        return $this->fetch();
    }

    public function baoming() {
        $stu_id = Request::instance()->param('stu_id');
        $test_style_id = Request::instance()->param('test_style_id');
        $Student = new Student;
        $student = $Student->where('stu_id', $stu_id)->find();
        $this->assign('student', $student);
        $this->assign('test_style_id', $test_style_id);
        return $this->fetch();
    }

    public function quedingbaoming() {
        $stu_id = Request::instance()->param('stu_id');
        $test_style_id = Request::instance()->param('test_style_id');
        $Student = new Student;

        $Student_test = new Student_test;
        $Student_test->stu_id = $stu_id;
        $Student_test->test_id = $test_style_id;
        $Student_test->save();

        $student = $Student->where('stu_id', $stu_id)->find();
        $student->test_style_id = $test_style_id;
        $student->save();
        return $this->success('报名成功', url('index', ['stu_Id' => $stu_id]));
    }

    public function baominginfo() {
        $stu_id = Request::instance()->param('stu_id');
        $Student = new Student;
        $student = $Student->where('stu_id', $stu_id)->find();

        $Student_test  = new Student_test;
        $student_test = $Student_test->where('stu_id', $stu_id)->select();
        $i = 0;
        for($i ; $i < sizeof($student_test); $i=$i+1) {
            $test_id = $student_test[$i]->test_id;
            $test_style = new Test_style;
            $test = $test_style->where('test_style_id', $test_id)->find();
            $student_test[$i]['test_time'] = $test->test_time;
            $student_test[$i]['name'] = $test->name;
        }

        $this->assign('test', $student_test);
        $this->assign('student', $student);
        return $this->fetch();
    }
}