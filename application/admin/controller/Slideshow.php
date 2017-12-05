<?php
namespace app\admin\Controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Db;

/**
*快易贷后台轮播图
*/

class Slideshow extends Controller
{
	public function _initialize(){
		$key1 = Session::get('joinname');
		$key2 = Session::get('joind');
		if(empty($key1)||empty($key2)){
			$this->error('请先登录!','Login/index');
		}
	}

	//添加页面
	public function Index(){
		return $this->fetch('slideshowAdd');
	}

	//添加
	public function actionAdd(){
		// 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        $fileData = Request::instance()->post();
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            //获取$info对象的下标使用get+下标
            $fileData['file'] = $info->getSaveName();
            $fileData['createtime'] = time();
            $res = Db::name('slideshow')->insert($fileData);
            if($res){
            	$this->redirect('slideshow/slideShow');
            }else{
            	$this->error('上传失败！');
            }
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
	}
	
	//展示页面
	public function slideShow(){
		$result = Db::name('slideshow')
        ->select();
		return $this->fetch('slideshow',[
			'data' => $result,
		]);
	}
}