#!/bin/bash
# ISEC cPanel Automated Deployment Script
# This script is executed automatically by cPanel when changes are pushed from GitHub.

# Define deployment paths
# $HOME automatically resolves to your cPanel root directory (e.g., /home/username/)
CORE_DIR="$HOME/isec_app"
PUBLIC_DIR="$HOME/public_html"

echo "Starting ISEC automated deployment..."

# 1. Create the secure core directory if it doesn't exist
/bin/mkdir -p "$CORE_DIR"

# 2. Sync all application files (app, vendor, database, etc.) to the secure directory
# Using rsync if available for cleaner syncing, otherwise fallback to cp
if command -v rsync &> /dev/null; then
    rsync -avP --exclude='.git' --exclude='public' ./ "$CORE_DIR/"
    rsync -avP ./public/ "$PUBLIC_DIR/"
else
    /bin/cp -R * "$CORE_DIR/"
    /bin/cp -R public/* "$PUBLIC_DIR/"
fi

echo "Deployment finished successfully."
