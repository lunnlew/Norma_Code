<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\OAPI\OAuth;

class AuthType
{
    //在 HTTP Authorization 头部传递 OAuth 参数。
    const AUTHORIZATION = 4;
    //将 OAuth 参数附加到 HTTP POST 请求主体中。
    const FORM = 3;
    //将 OAuth 参数附加到请求的 URI 后面 。
    const URI = 2;
    //无
    const NONE = 1;
}
