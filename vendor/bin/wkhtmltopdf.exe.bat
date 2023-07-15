@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../wemersonjanuario/wkhtmltopdf-windows/bin/32bit/wkhtmltopdf.exe
SET COMPOSER_RUNTIME_BIN_DIR=%~dp0
call "%BIN_TARGET%" %*
