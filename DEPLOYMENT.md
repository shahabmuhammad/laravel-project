InfinityFree Deployment Guide

Overview
- This app deploys to InfinityFree using GitHub Actions and FTP.
- Your public site is served from `htdocs` on InfinityFree.

Prerequisites
- Create an InfinityFree account and FTP credentials.
- Ensure your domain `laravel-project.gt.tc` points to your InfinityFree hosting account.
- Generate an app key locally: `php artisan key:generate` and copy to repo secret `APP_KEY`.

Required GitHub Secrets
- `FTP_SERVER`: FTP host (e.g., `ftpupload.net`).
- `FTP_USERNAME`: FTP username.
- `FTP_PASSWORD`: FTP password.
- `FTP_PORT`: FTP port (usually `21`).
- `FTP_PATH`: Remote folder, usually `/htdocs/`.
- Optional DB secrets: `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.

Notes
- InfinityFree document root is `htdocs`. The workflow assembles a `deploy` folder placing Laravel core (`vendor`, `bootstrap`, etc.) alongside `index.php` so paths resolve correctly.
- Assets are built via Vite during CI (`npm run build`).
- Environment variables are written to `deploy/.env` from the workflow `env` and secrets.

Manual Checks
- If you see a 500 error, verify `.env` exists on server and `APP_KEY` is set.
- Confirm `storage` is writable. InfinityFree typically allows writes under `htdocs`. If not, disable caching features.

Trigger Deploy
- Push to `main` or trigger manually from the Actions tab: "Deploy to InfinityFree (FTP)".
