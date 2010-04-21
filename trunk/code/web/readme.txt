Land web端的说明

1. 要求apache，并且开启mod_rewrite (尤其注意配置文件中的
   AllowOverride None 需要修改，比如修改为AllowOverride All）

2. 默认应该是通过SymLink或者Alias将到/land的请求定位到index目录
   这样可以避免将其他文件暴露在用户可请求的范围内

3. 需要修改conf下的几个配置文件

4. 推荐建立一个新的目录比如 ~/land/upload ，然后将 index/upload
   软链到该目录（用于存放fckeditor上传的文件，尤其是图片）

---------------------------------------------------------------

目录结构如下:

cache       用于存放cache文件以及对应的生成代码

conf        用于存放配置文件，主要包括三个：
    db.cfg.php          存放数据库主机地址、用户名、密码、库名
    land.cfg.php        存放Land的配置和一些常量
    wrapper.cfg.php     存放judge_wrapper的配置和常量

index       Land的入口，可以通过alias或者是SymLink来访问
    .htaccess   用于存放rewrite的规则，如果web_root不是/land，则需要对应修改
    upload      用于存放fckeditor上传的文件，可以是个目录，也可以是Symlink

lib         用于存放库函数、类

module      用于存放分发后的模块

readme.txt  就是我了

sql         数据库结构，包含文件land.sql

tpl         存放通用模板

wrapper     存放judge_wrapper
