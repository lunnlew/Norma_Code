#Norma框架
    Norma框架是立足于应用引擎环境的框架,支持简单应用的快速实现，支持REST应用，默认使用MVC.
###开始使用

[环境要求](Norma/Docs/start/environment.md)

获取Norma框架源码
 
解压源码到某个目录，例如:D:\www\project
    
    目录结构类似
        /project/
            Norma/
                Core/
                //其他目录
            index.php

浏览访问该目录，例如[http://localhost/project](http:://localhost/project),框架将自动建立完整的目录结构,详细参考[目录结构说明](Norma/Docs/start/directory.md)
    
    目录结构类似
        /project/
            App/
               //子目录
            Norma/
                //子目录
            index.php

此时,应该会在浏览器中输出类似的内容:

        Norma成功运行!
        欢饮使用.
        
这时，框架应用成功建立，之后就可以进行开发了.