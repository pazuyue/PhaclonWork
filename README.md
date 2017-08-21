# phaclcon配置文件
路径：app/config

#Manager 组件触发事件
路径：app/config/eventsManager
作用：可以有很多存在的侦听者为这些产生的事件作出响应
实例：Pilgins/MyComponent类

#KLoger日记类
路径：katzgrau/klogger
此类为composer拉下来的日记模块

#cookies
默认为加密方式，如果不需要加密可以在services.php 里面的set('cookies')注释$cookies->useEncryption(false);
