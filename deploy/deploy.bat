cls
echo off
rem ����·��
set WEB_PATH="F:/Repositories/Norma_Code"
set WEB_USER='everyone'
set WEB_USERGROUP='everyone'

echo ��ʼ����webӦ��
cd %WEB_PATH%

echo ��ȡ�ֿ������
git reset --hard origin/master
git clean -f
git pull
git checkout master
echo �����ļ�Ȩ����
echo Y|cacls %WEB_PATH% /c /p %WEB_USER%:c
rem echo y|icacls %WEB_PATH% /grant %WEB_USER%:RX
echo ��������.