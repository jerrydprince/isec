param (
    [string]$commitMessage = "Auto-sync update"
)

# Set the paths
$SourceDir = "C:\xampp\htdocs\isec"
$DestDir = "C:\Users\jerry\Documents\softwares\isec"

Write-Host "Syncing files from XAMPP directory..." -ForegroundColor Cyan

# Use robocopy to mirror the files. 
# /MIR mirrors a directory tree (equivalent to /E plus /PURGE).
# /XD excludes directories (we don't want to sync the .git folder or vendor folder from XAMPP if they exist).
# /R:1 /W:1 makes it retry once on failure and wait 1 second.
# /NFL /NDL /NJH /NJS suppresses some of the extra output.
robocopy $SourceDir $DestDir /MIR /XD .git vendor /XF .env /R:1 /W:1

# Robocopy exit codes: 0-7 are successful operations. 8 and higher are failures.
if ($LASTEXITCODE -ge 8) {
    Write-Host "Error syncing files. Robocopy exit code: $LASTEXITCODE" -ForegroundColor Red
    pause
    exit
}

Write-Host "Files synced successfully!" -ForegroundColor Green

# Ensure we are in the correct directory for git commands
Set-Location $DestDir

# Check if git is initialized
if (-not (Test-Path ".git")) {
    Write-Host "Git is not initialized in this directory. Initializing now..." -ForegroundColor Yellow
    git init
}

Write-Host "Staging files..." -ForegroundColor Cyan
git add .

# Check if there are actually changes to commit
$gitStatus = git status --porcelain
if ([string]::IsNullOrWhiteSpace($gitStatus)) {
    Write-Host "No changes detected to commit." -ForegroundColor Yellow
    pause
    exit
}

# Ask for a commit message
$userMessage = Read-Host "Enter a commit message (or press enter to use default: '$commitMessage')"
if (-not [string]::IsNullOrWhiteSpace($userMessage)) {
    $commitMessage = $userMessage
}

Write-Host "Committing changes..." -ForegroundColor Cyan
git commit -m $commitMessage

Write-Host "Pushing to GitHub..." -ForegroundColor Cyan
git push

Write-Host "Done!" -ForegroundColor Green
pause
