#常量

##框架常量
###FRAME_PATH--框架目录
    为框架核心的所在路径，如/var/www/Norma/Norma
    Norma目录结构:
        Core/*
        Helper/*
        Server/*
        Addons/*
        ...
###ENTRANCE_PATH--入口目录
    入口文件所在目录
###APP_PATH--应用目录
    应用所在目录
注意:之所以区分入口目录和应用目录，是为了允许目录可不在web目录下
###DS--目录分隔符
###FRAME_VERSION--框架版本号
###FRAME_RELEASE--框架发布号
###START_TIME--请求时间
###RUN_ENGINE--应用引擎类型
    框架自动检测,支持BAE,SAE等
    可能值:SAE,BAE
##应用常量
###APP_UUID--应用标识码
###RUNTIME_PATH--运行时写数据目录
###DATA_PATH--读数据路径
###CONTRLLER_PATH--控制器目录
###MODEL_PATH--模型目录
###LANG_PATH--语言包目录
###COMPILE_PATH--编译路径
###CACHE_PATH--缓存路径
###STOR_PATH--存储路径
###STOR_URL--存储访问URL
###WIDGET_PATH--widget路径
###WIDGET_URL--widget访问URL
###VIEW_PATH--视图目录
###THEME_NAME--视图风格名
###ASSETS_URL--静态资源URL
###CSS_URL--CSS资源URL
###JS_URL--JS资源URL
###IMG_URL--image资源URL