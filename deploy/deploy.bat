cls
echo off
rem 部署路径
set WEB_PATH="F:/Repositories/Norma_Code"
set WEB_USER='everyone'
set WEB_USERGROUP='everyone'

echo 开始部署web应用
cd %WEB_PATH%

echo 拉取仓库代码中
git reset --hard origin/master
git clean -f
git pull
git checkout master
echo 更新文件权限中
echo Y|cacls %WEB_PATH% /c /p %WEB_USER%:c
rem echo y|icacls %WEB_PATH% /grant %WEB_USER%:RX
echo 结束部署.