<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21
 * Time: 15:00
 */
class UserFilesController extends ControllerBase
{

    public function indexAction($id=null){
       if(empty($id))
       {
           $this->flash->notice("无效用户");

           $this->dispatcher->forward([
               "controller" => "user",
               "action" => "search"
           ]);
           return;
       }
        $user = User::findFirstByid($id);
       if(empty($user))
       {
           $this->flash->notice("无效用户");

           $this->dispatcher->forward([
               "controller" => "user",
               "action" => "search"
           ]);
           return;
       }

        $this->tag->setDefault("user_id", $user->id);
        $this->tag->setDefault("user_name", $user->name);
        return ;
    }

    public function saveFileByUserAction(){
        $user_id= $this->request->getPost("user_id","int");
        if(empty($user_id))
        {
            $this->flash->notice("无效用户");
            return $this->dispatcher->forward([
                "controller" => "user",
                "action" => "search"
            ]);

        }
        // 检测是否有上传文件
        if ($this->request->hasFiles())
        {
            foreach ($this->request->getUploadedFiles() as $file) {
                // Print file details
                if(empty($file->getSize())){
                    $this->flash->notice("上传文件为空");
                    return $this->dispatcher->forward([
                        "controller" => "userFiles",
                        "action" => "index",
                        "params"=>array(0=>$user_id)
                    ]);
                }

                $userFile = new UserFile();
                checkDir("userfiles");
                if(is_file('userfiles/' .iconv("UTF-8","gb2312", $file->getName())))
                {
                    $params =['user_id'=>$user_id,"fileName"=>$file->getName(),"fileDir"=>'userfiles/' . $file->getName()];
                    $userFile->save($params);
                }else{
                    // Move the file into the application
                    $result=$file->moveTo('userfiles/' .iconv("UTF-8","gb2312", $file->getName()) );
                    if($result)
                    {
                        $params =['user_id'=>$user_id,"fileName"=>$file->getName(),"fileDir"=>'userfiles/' . $file->getName()];
                        $userFile->save($params);
                    }else{
                        Log::getInstance()->error(json_encode($result));
                    }
                }
            }

            // 上传文件信息
            $this->view->id = $user_id;
            $this->tag->setDefault("Name", $file->getName());
            $this->tag->setDefault("TempName", $file->getTempName());
            $this->tag->setDefault("filSize", $file->getSize());
            $this->tag->setDefault("fileType", $file->getType());
            $this->tag->setDefault("fileError", $file->getError());
            $this->tag->setDefault("fileKey", $file->getKey());
            $this->tag->setDefault("fileExtension", $file->getExtension());
        }
    }


}