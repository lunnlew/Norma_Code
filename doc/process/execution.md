#执行流程
    框架将框架自身初始化过程与应用初始化过程进行了分离，应用按需在自己的初始化过程中加载所需的类库,配置等
    
###全局流程

    1、应用入口index.php
    
    2、定义框架目录和应用目录
    
    3、加载和执行框架引导程序 FRAME_PATH.'Initialise/bootstrap.php'
    
    4、加载框架核心类文件 NormaCore.php,并进行框架核心初始化
    
    5、判断是否存在应用自定义初始化文件APP_PATH.'Custom/Norma.php'
        a、存在则加载该文件APP_PATH.'Custom/Norma.php'进行应用初始化
        b、不存在则加载默认的空初始化文件FRAME_PATH.'Norma.php'
        
    6、应用初始化完成后开始进行请求处理，路由分发和执行相应控制器
    
###框架核心初始化流程(文件:FRAME_PATH.'Core/NormaCore.php')
    
    1、定义写数据目录与日志目录,版本信息
    
    2、加载classLoader类加载器
    
    3、使用classLoader注册类库,函数库的约定
    
    4、加载通用常量
    
    5、加载第三方类加载器以支持通过composer安装的第三方库
    
    6、初始化日志设置
    
    7、初始化配置设置
    
    8、框架初始化结束

###应用初始化流程(文件:APP_PATH.'Custom/Norma.php')
    
    1、使用类加载器注册应用自己的类库,函数库
    
    2、加载应用自定义配置(合并优先级高于框架惯例配置)
    
    3、进行视图初始化
    
    4、进行请求处理
    
    5、开始执行应用
    
    6、路由分发，执行控制器
    
    7、应用执行结束
    

