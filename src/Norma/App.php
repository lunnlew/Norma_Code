<?php
// +----------------------------------------------------------------------
// | Norma
// +----------------------------------------------------------------------
// | Copyright (c) 2015  All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:  LunnLew <lunnlew@gmail.com>
// +----------------------------------------------------------------------
namespace Norma;
/**
 * App执行实现类
 */
class App {
	//核心类加载器
	static $loader = '';
	//环境对象类
	static $evn = '';

	/**
	 * @var string 当前模块路径
	 */
	public static $modulePath;

	/**
	 * @var string 应用类库命名空间
	 */
	public static $namespace = 'App';

	/**
	 * @var bool 应用类库后缀
	 */
	public static $suffix = false;

	/**
	 * @var bool 严格路由检测
	 */
	protected static $routeMust;

	public static $debug = false;

	//异常模板文件
	protected static $EXCEPTION_TMPL = FRAME_PATH . '/Tpl/norma_exception.tpl';

	protected static $dispatch = '';
	/**
	 * 执行应用
	 * @static
	 * @access public
	 */
	public static function listen(Request $request = null, $type = 'web') {
		is_null($request) && $request = Request::instance();
		//请求筛选
		\Norma\PluginManager::trigger('request_action', [$request]);
		//加载应用独立文件
		if (\Norma\Config::has('extra_config_list')) {
			$extra_config_list = \Norma\Config::get('extra_config_list');
			if (is_string($extra_config_list)) {
				$extra_config_list = explode(',', $extra_config_list);
			}
			foreach ($extra_config_list as $key => $file) {
				\Norma\Config::load(APP_PATH . '/Config/' . $file . '.php');
			}
		}
		// 设置系统时区
		date_default_timezone_set(\Norma\Config::get('default_timezone'));

		// 应用调试模式
		self::$debug = Config::get('app_debug');
		if (!self::$debug) {
			ini_set('display_errors', 'Off');
		} else {
			//重新申请一块比较大的buffer
			if (ob_get_level() > 0) {
				$output = ob_get_clean();
			}
			ob_start();
			if (!empty($output)) {
				echo $output;
			}
		}

		// 注册应用实现类名称空间
		\Norma\App::$loader->addNamespace(\Norma\Config::get('app_namespace') ?: "App", APP_PATH);

		// 加载插件
		\Norma\PluginManager::loadPlugin(APP_PATH . '/Plugin', \Norma\Config::get('app_namespace'));

		// 开启多语言机制
		if (\Norma\Config::get('lang_switch_on')) {
			// 获取当前语言
			$request->langset(Lang::detect());
			// 加载系统语言包
			Lang::load(FRAME_PATH . '/Ability/Lang' . DIRECTORY_SEPARATOR . $request->langset() . '.php');
			if (!\Norma\Config::get('app_multi_module')) {
				Lang::load(APP_PATH . '/Lang' . DIRECTORY_SEPARATOR . $request->langset() . '.php');
			}
		}

		// 获取应用调度信息
		$dispatch = self::$dispatch;
		if (empty($dispatch)) {
			// 进行URL路由检测
			$dispatch = self::routeCheck($request, \Norma\Config::get());
		}
		// 记录当前调度信息
		$request->dispatch($dispatch);
		// 记录路由信息
		//self::$debug && Log::record('[ ROUTE ] ' . var_export($dispatch, true), 'info');
		// 监听app_begin
		//Hook::listen('app_begin', $dispatch);

		switch ($dispatch['type']) {
		case 'redirect':
			// 执行重定向跳转
			$data = Response::create($dispatch['url'], 'redirect')->code($dispatch['status']);
			break;
		case 'module':
			// 模块/控制器/操作
			$data = self::module($dispatch['module'], \Norma\Config::get(), isset($dispatch['convert']) ? $dispatch['convert'] : null);
			break;
		case 'controller':
			// 执行控制器操作
			$data = Loader::action($dispatch['controller'], $dispatch['params']);
			break;
		case 'method':
			// 执行回调方法
			$data = self::invokeMethod($dispatch['method'], $dispatch['params']);
			break;
		case 'function':
			// 执行闭包
			$data = self::invokeFunction($dispatch['function'], $dispatch['params']);
			break;
		case 'response':
			$data = $dispatch['response'];
			break;
		default:
			throw new \InvalidArgumentException('dispatch type not support');
		}

		// 输出数据到客户端
		if ($data instanceof Response) {
			$response = $data;
		} elseif (!is_null($data)) {
			// 默认自动识别响应输出类型
			$isAjax = $request->isAjax();
			$type = $isAjax ? Config::get('default_ajax_return') : Config::get('default_return_type');
			\Norma\PluginManager::trigger('output', [$data, $type]);
		} else {
			\Norma\PluginManager::trigger('output');
		}

		//
		//return $response;
	}

	static $routeCheck = '';
	/**
	 * URL路由检测（根据PATH_INFO)
	 * @access public
	 * @param  \think\Request $request
	 * @param  array          $config
	 * @return array
	 * @throws \think\Exception
	 */
	public static function routeCheck($request, array $config) {
		$path = $request->path();
		$depr = $config['pathinfo_depr'];
		$result = false;
		// 路由检测
		$check = !is_null(self::$routeCheck) ? self::$routeCheck : $config['url_route_on'];
		if ($check) {
			// 开启路由
			if (!empty($config['route'])) {
				// 导入路由配置
				\Norma\Route::import($config['route']);
			}
			// 路由检测（根据路由定义返回不同的URL调度）
			$result = \Norma\Route::check($request, $path, $depr, $config['url_domain_deploy']);
			$must = !is_null(self::$routeMust) ? self::$routeMust : $config['url_route_must'];
			if ($must && false === $result) {
				// 路由无效
				throw new \Norma\Exception\HttpException(404, 'Route Not Found');
			}
		}
		if (false === $result) {
			// 路由无效 解析模块/控制器/操作/参数... 支持控制器自动搜索
			$result = \Norma\Route::parseUrl($path, $depr, $config['controller_auto_search']);
		}
		return $result;
	}

	/**
	 * 执行模块
	 * @access public
	 * @param array $result 模块/控制器/操作
	 * @param array $config 配置参数
	 * @param bool  $convert 是否自动转换控制器和操作名
	 * @return mixed
	 */
	public static function module($result, $config, $convert = null) {
		if (is_string($result)) {
			$result = explode('/', $result);
		}
		$request = Request::instance();
		if ($config['app_multi_module']) {
			// 多模块部署
			$module = ucfirst(strip_tags(strtolower($result[0] ?: $config['default_module'])));
			$bind = Route::getBind('module');

			$available = false;
			if ($bind) {
				// 绑定模块
				list($bindModule) = explode('/', $bind);
				if ($module == $bindModule) {
					$available = true;
				}
			} elseif (!in_array($module, $config['deny_module_list']) && is_dir(APP_PATH . '/' . $module)) {
				$available = true;
			}
			// 模块初始化
			if ($module && $available) {
				// 初始化模块
				$request->module($module);
				$config = self::init($module);
			} else {
				throw new \Norma\Exception\HttpException(404, 'module not exists:' . $module);
			}
		} else {
			// 单一模块部署
			$module = '';
			$request->module($module);
		}
		// 当前模块路径
		App::$modulePath = APP_PATH . '/' . ($module ? $module . DIRECTORY_SEPARATOR : '');

		// 是否自动转换控制器和操作名
		$convert = is_bool($convert) ? $convert : $config['url_convert'];
		// 获取控制器名
		$controller = strip_tags($result[1] ?: $config['default_controller']);
		$controller = ucfirst($convert ? strtolower($controller) : $controller);

		// 获取操作名
		$actionName = strip_tags($result[2] ?: $config['default_action']);
		$actionName = $convert ? strtolower($actionName) : $actionName;

		// 设置当前请求的控制器、操作
		$request->controller($controller)->action($actionName);

		// 监听module_init
		//Hook::listen('module_init', $request);

		try {
			$instance = Loader::controller($controller, $config['url_controller_layer'], $config['controller_suffix'], $config['empty_controller']);
			if (is_null($instance)) {
				throw new \Norma\Exception\HttpException(404, 'controller not exists:' . $controller);
			}
			// 获取当前操作名
			$action = $actionName . $config['action_suffix'];
			if (!preg_match('/^[A-Za-z](\w)*$/', $action)) {
				// 非法操作
				throw new \ReflectionException('illegal action name:' . $actionName);
			}

			// 执行操作方法
			$call = [$instance, $action];
			//Hook::listen('action_begin', $call);

			$data = self::invokeMethod($call);
		} catch (\ReflectionException $e) {
			// 操作不存在
			if (method_exists($instance, '_empty')) {
				$method = new \ReflectionMethod($instance, '_empty');
				$data = $method->invokeArgs($instance, [$action, '']);
				self::$debug && Log::record('[ RUN ] ' . $method->__toString(), 'info');
			} else {
				throw new \Norma\Exception\HttpException(404, 'method not exists:' . (new \ReflectionClass($instance))->getName() . '->' . $action);
			}
		}
		return $data;
	}

	/**
	 * 执行函数或者闭包方法 支持参数调用
	 * @access public
	 * @param string|array|\Closure $function 函数或者闭包
	 * @param array                 $vars     变量
	 * @return mixed
	 */
	public static function invokeFunction($function, $vars = []) {
		$reflect = new \ReflectionFunction($function);
		$args = self::bindParams($reflect, $vars);
		// 记录执行信息
		//self::$debug && Log::record('[ RUN ] ' . $reflect->__toString(), 'info');
		return $reflect->invokeArgs($args);
	}

	/**
	 * 调用反射执行类的方法 支持参数绑定
	 * @access public
	 * @param string|array $method 方法
	 * @param array        $vars   变量
	 * @return mixed
	 */
	public static function invokeMethod($method, $vars = []) {
		if (empty($vars)) {
			// 自动获取请求变量
			$vars = \Norma\Request::instance()->param();
		}
		if (is_array($method)) {
			$class = is_object($method[0]) ? $method[0] : new $method[0];
			$reflect = new \ReflectionMethod($class, $method[1]);
		} else {
			// 静态方法
			$reflect = new \ReflectionMethod($method);
		}
		$args = self::bindParams($reflect, $vars);
		// 记录执行信息
		//self::$debug && Log::record('[ RUN ] ' . $reflect->__toString(), 'info');
		return $reflect->invokeArgs(isset($class) ? $class : null, $args);
	}

	/**
	 * 绑定参数
	 * @access public
	 * @param \ReflectionMethod|\ReflectionFunction $reflect 反射类
	 * @param array             $vars    变量
	 * @return array
	 */
	private static function bindParams($reflect, $vars) {
		$args = [];
		// 判断数组类型 数字数组时按顺序绑定参数
		$type = key($vars) === 0 ? 1 : 0;
		if ($reflect->getNumberOfParameters() > 0) {
			$params = $reflect->getParameters();
			foreach ($params as $param) {
				$name = $param->getName();
				$class = $param->getClass();
				if ($class && 'think\Request' == $class->getName()) {
					$args[] = \Norma\Request::instance();
				} elseif (1 == $type && !empty($vars)) {
					$args[] = array_shift($vars);
				} elseif (0 == $type && isset($vars[$name])) {
					$args[] = $vars[$name];
				} elseif ($param->isDefaultValueAvailable()) {
					$args[] = $param->getDefaultValue();
				} else {
					throw new \InvalidArgumentException('method param miss:' . $name);
				}
			}
			// 全局过滤
			array_walk_recursive($args, [\Norma\Request::instance(), 'filterExp']);
		}
		return $args;
	}

	/**
	 * 初始化应用或模块
	 * @access public
	 * @param string $module 模块名
	 * @return array
	 */
	private static function init($module = '') {
		// 定位模块目录
		$module = $module ? $module . DIRECTORY_SEPARATOR : '';

		// 加载初始化文件
		if (is_file(APP_PATH . '/' . $module . 'init' . '.php')) {
			include APP_PATH . '/' . $module . 'init' . '.php';
		} else {
			$path = APP_PATH . '/' . $module;
			// 加载模块配置
			$config = Config::load(APP_PATH . '/Config/' . $module . 'config' . '.php');

			// 加载应用状态配置
			if ($config['app_status']) {
				$config = Config::load(APP_PATH . '/Config/' . $module . $config['app_status'] . '.php');
			}

			// 读取扩展配置文件
			if ($config['extra_config_list']) {
				foreach ($config['extra_config_list'] as $name => $file) {
					$filename = APP_PATH . '/Config/' . $module . $file . '.php';
					Config::load($filename, is_string($name) ? $name : pathinfo($filename, PATHINFO_FILENAME));
				}
			}

			// 加载别名文件
			if (is_file(APP_PATH . '/Config/' . $module . 'alias' . '.php')) {
				Loader::addClassMap(include APP_PATH . '/Config/' . $module . 'alias' . '.php');
			}

			// 加载行为扩展文件
			if (is_file(APP_PATH . '/Config/' . $module . 'tags' . '.php')) {
				Hook::import(include APP_PATH . '/Config/' . $module . 'tags' . '.php');
			}

			// 加载公共文件
			if (is_file($path . 'common' . '.php')) {
				include $path . 'common' . '.php';
			}

			// 加载插件
			\Norma\PluginManager::loadPlugin($path . '/Plugin', ($config['app_namespace'] ?: 'App') . '\\' . trim($module, DIRECTORY_SEPARATOR));

			// 加载当前模块语言包
			if ($config['lang_switch_on'] && $module) {
				Lang::load($path . 'lang' . DIRECTORY_SEPARATOR . Request::instance()->langset() . '.php');
			}
		}
		return Config::get();
	}
}
