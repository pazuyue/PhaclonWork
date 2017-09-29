<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/18
 * Time: 17:50
 */

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Tag;
use Phalcon\Crypt;
use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

class DemoController extends ControllerBase
{
    //日记类测试
    public function logTestAction()
    {
        $users = [
            [
                'name' => 'Kenny Katzgrau',
                'username' => 'katzgrau',
            ],
            [
                'name' => 'Dan Horrigan',
                'username' => 'dhrrgn',
            ],
        ];
        Log::debug($users);
    }

    //Cookies保存和获取
    public function getCookiesAction(){
        $this->cookies->set('name', 'yueguang', time() + 7 * 86400);
        $name=trim($this->cookies->get('name')->getValue());
        return $name;
    }

    //输出信息
    public function showFlashAction(){
        // 使用直接闪存
        $this->flash->success("Your information was stored correctly!");

        // 转发到index动作
        return $this->dispatcher->forward(
            array(
                "controller" => "user",
                "action" => "index"
            )
        );
    }

    //初始化验证,使用验证类
    public function presistentAction(){

        $validation = new UserValidation();

        $messages = $validation->validate($this->request->getPost());
        if (count($messages)) {
            foreach ($messages as $message) {
                echo $message, '<br>';
            }
        }
    }

    //start 直接缓存前端输出信息
    public  function testCacheBySartAction(){
        $CacheOutServer = new CacheOutServer();
        $content=$CacheOutServer->start("my-cache.html");
        if ($content === null) {
            echo date("r");
            // Generate a link to the sign-up action
            echo Tag::linkTo(
                array(
                    "user/signup",
                    "Sign Up",
                    "class" => "signup-button"
                )
            );
            $CacheOutServer->save();
        }else{
            echo $content;
        }
    }

    //文件后端存储器例子
    public function testCacheByFileAction(){
        $this->cookies->set('name', 'yueguang', time() + 7 * 86400);
        $CacheOutServer = new CacheOutServer();
        $cacheKey = $CacheOutServer->getKey(array("name"=>'yueguang'));
        $name=$CacheOutServer->get($cacheKey);
        if (empty($name))
        {
            $name=trim($this->cookies->get('name')->getValue());
            $CacheOutServer->save($cacheKey,$name);
            return $name;
        }else{
            return $name;
        }
    }

    //加密解密
    public function cryptAction(){
        // 创建实例
        $crypt = new Crypt();
        $texts = [
            "my-key"    => "This is a secret text",
            "other-key" => "This is a very secret",
        ];

        foreach ($texts as $key => $text) {
            // 加密
            $encrypted = $crypt->encryptBase64($text, $key);
            // 解密
            echo $crypt->decryptBase64($encrypted, $key);
        }
    }

    public function sqltestAction(){
        /*$sql = "SELECT * FROM `user` ORDER BY id ";
        // 发送SQL语句到数据库
        $result = $this->db->query($sql);
        // 打印每个robot名称
        while ($robot = $result->fetch()) {
            echo $robot["name"];
        }*/

        $rows = User::find(
            [
                "conditions" => "Jurisdiction = :Jurisdiction:",
                "bind"       => [
                    "Jurisdiction"=> "2",
                ],
                "cache" => [
                    "key" => "my-cache",
                ],
            ]
        );
        foreach ($rows as $row) {
            echo $row->name, "<br>";
            foreach ($row->UserFile as $userFile)
            {
                echo "---->".$userFile->fileDir, "<br>";
            }
        }

        /*
        //记录快照，判断修改字段和修改状态
        $user = User::findFirst();
        $user->name="月神";
        var_dump($user->getChangedFields()); // ["name"]
        var_dump($user->hasChanged("name")); // true
        $user->name="Tom";
        var_dump($user->hasChanged("name")); // true*/

        //$manager=$this->modelsManager;
        //$phql ="SELECT * FROM `user` AS u LEFT JOIN  userfile AS uf ON u.id=uf.user_id";
       /* $query = $this->modelsManager->createQuery("SELECT User.name,UserFile.fileName FROM User  LEFT  JOIN UserFile ON User.id = UserFile.user_id");
        $user  = $query->execute();
        foreach ($user as $car) {
            echo "Name: ", $car->name, "<br>";
            echo "FileName: ", $car->fileName, "<br>";
        }*/

    }

    public function indexAction()
    {
        $user = new User();
        pre_var(serialize($user));
        // Get Phalcon\Mvc\Model\Metadata instance
        $metadata = $user->getModelsMetaData();

        //获取模型元数据
        $attributes = $metadata->getAttributes($user);
        print_r($attributes);
        echo "<br>";
        // Get robots fields data types
        $dataTypes = $metadata->getDataTypes($user);
        print_r($dataTypes);
    }

    public function notFoundAction()
    {
        // 发送一个HTTP 404 响应的header
        $this->response->setStatusCode(404, "Not Found");
    }

    public function cacheAction(){
        $row = time();
        Cache::save("a",$row);
        $data=Cache::get("a");
        var_dump($data);
    }

}