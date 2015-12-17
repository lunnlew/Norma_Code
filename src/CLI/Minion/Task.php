<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\CLI\Minion;

/**
 * 命令行基类
 *
 * @package  Norma\CLI\Minion
 * @author   LunnLew <lunnlew@gmail.com>
 */
abstract class Task
{
    /**
     * 用来分隔不同级别的任务
     * @var string
     */
    public static $task_separator = ':';

    /**
     * 转换Task名到类名 例如(help:test => Minion\Task\Help\Test)
     *
     * @param string  Task名
     * @return string 类名
     */
    public static function convertRaskRoCassName($task)
    {
        $task = trim($task);
        if (empty($task)) {
            return '';
        }
        //具体Task类名
        return 'Minion\Task\\'.implode('\\', array_map('ucfirst', explode(Task::$task_separator, $task)));
    }

    /**
     * 从类名或者实例中获取任务名
     *
     * @param  string|Task  类名或者实例
     * @return string Task名
     */
    public static function convertCassToTask($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        return strtolower(str_replace('\\', Task::$task_separator, substr($class, strlen('Minion\Task\\'))));
    }

    /**
     * 实例化Task
     *
     * @param  命令行为参数,应该包括task参数
     * @throws Minion_Exception_InvalidTask
     * @return Task实例
     */
    public static function factory($options)
    {
        if (($task = $options['task']) !== null) {
            unset($options['task']);
        } elseif (($task = $options[0]) !== null) {
            //第一个参数可能任务名
            unset($options[0]);
        } else {
            //没有提供Task是则设置默认Task
            $task = 'help';
        }
        $class = Task::convertRaskRoCassName($task);

        //判断是否存在Task
        if (! class_exists($class)) {
            throw new Minion_Exception_InvalidTask(
                "Task ':task' is not a valid minion task",
                array(':task' => $class)
            );
        }

        $class = new $class;
        //判断是否是\Norma\CLI\Task的一个子实例
        if (!$class instanceof \Norma\CLI\Task) {
            throw new Minion_Exception_InvalidTask(
                "Task ':task' is not a valid minion task",
                array(':task' => $class)
            );
        }
        $class->setOptions($options);

        //如果请求了help则显示帮助信息
        if (array_key_exists('help', $options)) {
            $class->_method = '_help';
        }

        return $class;
    }

    /**
     * 一个用于接受命令行为参数及其默认值的数组
     *
     *     protected $_options = array(
     *         'limit' => 4,
     *         'table' => NULL,
     *     );
     *
     * @var array
     */
    protected $_options = array();

    /**
     * 所有的接受的参数名,自动从_options中获得
     *
     * @var array
     */
    protected $_accepted_options = array();
    /**
     * Task子类默认入口方法
     */
    protected $_method = '_execute';
    /**
     * 实例化方法
     */
    protected function __construct()
    {
        //处理参数名
        $this->_accepted_options = array_keys($this->_options);
    }

    /**
     * The file that get's passes to Validation::errors() when validation fails
     * @var string|NULL
     */
    protected $_errors_file = 'validation';

    /**
     * 获得实例任务名
     *
     * @return string
     */
    public function __toString()
    {
        static $task_name = null;

        if ($task_name === null) {
            $task_name = Task::convertCassToTask($this);
        }

        return $task_name;
    }

    /**
     * 设置Task命令参数
     *
     * $param  array  用来设置的参数
     * @return this
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->_options[$key] = $value;
        }

        return $this;
    }

    /**
     * 获得已设置的命令参数值
     *
     * @return array
     */
    public function getOptions()
    {
        return (array) $this->_options;
    }

    /**
     * 获得已接收的命令参数名
     *
     * @return array
     */
    public function getAcceptedOptions()
    {
        return (array) $this->_accepted_options;
    }

    /**
     * 执行Task任务
     *
     * @return null
     */
    public function execute()
    {
        $options = $this->getOptions();
        // 行为验证//TODO
        //$validation = Validation::factory($options);
        //$validation = $this->buildValidation($validation);

        if ($this->_method != '_help' and 0/* AND ! $validation->check()*/) {
            echo \FrontData::factory('minion/error/validation')
                ->set('task', Task::convertCassToTask($this))
                ->set('errors', $validation->errors($this->getErrorsFile()));
        } else {
            //运行任务
            $method = $this->_method;
            echo $this->{$method}($options);
        }
    }
    /**
     * task子类必须实现的方法
     */
    abstract protected function _execute(array $params);

    /**
     * 输出帮助信息
     *
     * @return null
     */
    protected function _help(array $params)
    {
        $tasks = $this->_compileTaskList(listFiles('Plugin/Minion/Task'));

        $inspector = new \ReflectionClass($this);

        list($description, $tags) = $this->_parseDoccomment($inspector->getDocComment());

        \FrontData::assign('tpl', 'minion/help/task');
        \FrontData::assign('description', $description);
        \FrontData::assign('tags', (array) $tags);
        \FrontData::assign('task', Task::convertCassToTask($this));
        exit('View Render!!!');
        //echo $view;
    }
    /**
     * 分析Phpdoc注释用来提供命令帮助信息
     *
     * @param string 需要被分析的注释
     * @return array 第一项是注释本身，其余是phpdoc标签值
     */
    protected function _parseDoccomment($comment)
    {
        // Normalize all new lines to \n
        $comment = str_replace(array("\r\n", "\n"), "\n", $comment);

        // Remove the phpdoc open/close tags and split
        $comment = array_slice(explode("\n", $comment), 1, -1);

        // Tag content
        $tags        = array();

        foreach ($comment as $i => $line) {
            // Remove all leading whitespace
            $line = preg_replace('/^\s*\* ?/m', '', $line);

            // Search this line for a tag
            if (preg_match('/^@(\S+)(?:\s*(.+))?$/', $line, $matches)) {
                // This is a tag line
                unset($comment[$i]);

                $name = $matches[1];
                $text = isset($matches[2]) ? $matches[2] : '';

                $tags[$name] = $text;
            } else {
                $comment[$i] = (string) $line;
            }
        }

        $comment = trim(implode("\n", $comment));

        return array($comment, $tags);
    }

    /**
     * 从目录结构体中编译处理以获取所有可用Task列表
     *
     * @param  array Directory structure of tasks
     * @param  string prefix
     * @return array Compiled tasks
     */
    protected function _compileTaskList(array $files, $prefix = '')
    {
        $output = array();

        foreach ($files as $file => $path) {
            $file = substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1);

            if (is_array($path) and count($path)) {
                $task = $this->_compileTaskList($path, $prefix.$file.Task::$task_separator);

                if ($task) {
                    $output = array_merge($output, $task);
                }
            } else {
                $output[] = strtolower($prefix.substr($file, 0, -strlen(EXT)-1));
            }
        }

        return $output;
    }
    /**
     * Adds any validation rules/labels for validating _options
     *
     *     public function buildValidation(Validation $validation)
     *     {
     *         return parent::buildValidation($validation)
     *             ->rule('paramname', 'not_empty'); // Require this param
     *     }
     *
     * @param  Validation   the validation object to add rules to
     *
     * @return Validation
     */
    public function buildValidation(Validation $validation)
    {
        // Add a rule to each key making sure it's in the task
        foreach ($validation->as_array() as $key => $value) {
            $validation->rule($key, array($this, 'validOption'), array(':validation', ':field'));
        }

        return $validation;
    }

    /**
     * Returns $_errors_file
     *
     * @return string
     */
    public function getErrorsFile()
    {
        return $this->_errors_file;
    }

    public function validOption(Validation $validation, $option)
    {
        if (! in_array($option, $this->_accepted_options)) {
            $validation->error($option, 'minion_option');
        }
    }
}
