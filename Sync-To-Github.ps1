param (
    [string]$commitMessage = "Auto-sync update"
)

$SourceDir = "C:\xampp\htdocs\isec"
$DestDir = "C:\Users\jerry\Documents\softwares\isec"

Write-Host "Syncing files from XAMPP directory..." -ForegroundColor Cyan
robocopy $SourceDir $DestDir /MIR /XD .git vendor /XF .env /R:1 /W:1

if ($LASTEXITCODE -ge 8) {
    Write-Host "Error syncing files. Robocopy exit code: $LASTEXITCODE" -ForegroundColor Red
    pause
    exit
}

Write-Host "Files synced successfully!" -ForegroundColor Green

Set-Location $DestDir

Write-Host "Staging files..." -ForegroundColor Cyan
git add .

$gitStatus = git status --porcelain
if ([string]::IsNullOrWhiteSpace($gitStatus)) {
    Write-Host "No changes detected to commit." -ForegroundColor Yellow
    pause
    exit
}

$userMessage = Read-Host "Enter a commit message (or press enter to use default: '$commitMessage')"
if (-not [string]::IsNullOrWhiteSpace($userMessage)) {
    $commitMessage = $userMessage
}

Write-Host "Committing changes..." -ForegroundColor Cyan
git commit -m $commitMessage

Write-Host "Pushing to GitHub..." -ForegroundColor Cyan
git push

Write-Host "Done! The GitHub Action will now automatically deploy your files." -ForegroundColor Green
pause
