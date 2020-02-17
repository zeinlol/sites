



fits2bitmap --help
IF %ERRORLEVEL% NEQ 0 exit /B 1
fitscheck --help
IF %ERRORLEVEL% NEQ 0 exit /B 1
fitsdiff --help
IF %ERRORLEVEL% NEQ 0 exit /B 1
fitsheader --help
IF %ERRORLEVEL% NEQ 0 exit /B 1
fitsinfo --help
IF %ERRORLEVEL% NEQ 0 exit /B 1
samp_hub --help
IF %ERRORLEVEL% NEQ 0 exit /B 1
volint --help
IF %ERRORLEVEL% NEQ 0 exit /B 1
wcslint --help
IF %ERRORLEVEL% NEQ 0 exit /B 1
exit /B 0
