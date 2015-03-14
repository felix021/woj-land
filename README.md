# woj-land
Automatically exported from code.google.com/p/woj-land

WOJ名字进化: noah(v1.0) -> oak(ark?)(v1.1) -> flood(v2.0) -> land(v3.0)

==搭建说明==

参见 [http://code.google.com/p/woj-land/source/browse/trunk/docs/INSTALL.txt 安装说明]

都搞定以后打开浏览器访问 http://localhost/land, 可以以默认管理员root:123456登录,或者自行注册吧~

==使用Land的OJ==

武汉大学：http://acm.whu.edu.cn/land

西安电子科技大学：http://acm.xidian.edu.cn/land

(请其他使用Land的OJ与我联系，我会维护一份列表，一旦有重要更新可以通知到）

==安全更新==

2012-03-31 [非常重要] 修正普通用户可以启用/禁用题目的问题。

2012-03-10 [非常重要] 修正Judge，限制spj程序的运行权限（root->nobody），否则OJ的root就等同于OS的root了。

2012-03-21 限制session_id的冒用（通过IP和UA来识别），主要是限制针对管理员用户的盗用。

==进展==

@ 2012-04-03 Beta 1，多个BUG修复，包括重要安全更新（spj权限、普通用户权限、session冒用）、Judge升级（修正realloc的rf问题、增加spj程序的参数和spj模板程序）、增加python版的daemon（可以在小内存vps上运行～）、diligent模块、多项界面修复（更易用啦）

@ 2010-09-24 Alpha 2，增加了x86_64的支持, 试用了一段时间，修复了多个BUG，能正确处理qsort的调用。不会将SIGSEGV的情况误判为RF了。

@ 2010-04-21 Alpha 1，各个功能都已经实现，包括比赛。可以开始投入使用了。附了一个安装说明 docs/INSTALL.txt 比较杂，慢慢看....

@ 2010-04-10 Milestone 3，可以加/修改题目和数据，C/CPP/Java/Pascal都已经可用。

@ 2010-03-31 Milestone 2，用户端的基本功能已经就位，Judge的C/CPP/Pascal都已经可以支持了。

@ 2010-03-25 Milestone 1, 已经有了能用daemon和judge_wrapper, 虽然不完善, 但是已经能够提供一个oj最基础的提交代码并自动judge的功能了。

@ 2010-03-23 web代码框架已经成型,编码一小部分

@ 2010-03-21 c/c++的judge已经基本可用，开始进入web开发

@ 2010-03-15 C/C++的judge基本成型，正在编写Restricted Functions检查功能；然后将加入setuid/chroot等功能进一步限制用户进程的权限
