@echo off
setlocal EnableDelayedExpansion

echo Project Structure:
echo.

set /p "extension=Enter file extension (e.g., php) or type 'all' for all files: "

if "%extension%"=="all" (
    dir /s /b > project_structure.txt
) else (
    dir /s /b *.%extension% > project_structure.txt
)

echo.
echo Project structure has been saved to project_structure.txt
pause
