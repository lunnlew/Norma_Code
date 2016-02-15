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

namespace Norma\Traits;
use Norma\Exception\RuntimeException;

Trait  SingletonTrait
{
	 private static $instance;
    
    /**
     * Create the single instance of class
     *
     * @param none
     * @return Object self::$singleInstance Instance
     */
    public static function getInstance() {
        if(!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Keep the constructor private
     */
    private function __construct() { }
    
    /**
     * Stop serialization
     *
     * @throws Norma\Exception\RuntimeException
     */
    public function __sleep() {
        throw new RuntimeException('Serializing instances of this class is forbidden.');
    }
    
    /**
     * Stop serialization
     *
     * @throws Norma\Exception\RuntimeException
     */
    public function __wakeup() {
        throw new RuntimeException('Unserializing instances of this class is forbidden.');
    }
    
    /**
     * Override clone method to stop cloning of the object
     *
     * @throws Norma\Exception\RuntimeException
     */
    private function __clone() {
        throw new RuntimeException("Cloning is not supported in singleton class.");
    }
}