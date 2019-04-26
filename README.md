# Platform Dashboard

Platform Dashboard for Business-to-business Marketplace.

## Deployment
### Prepare 
- Clone from git
- run `composer install`
- Copy `.env-example` to `.env`
- then run `> php artisan key:generate`
### Setup keys for Google Cloud Storage and Firebase
Get file from folder `Grosera - Shared/Developer/Env` in Google Drive
- Copy `assets-cred.json` to folder `keys`
- Copy `firebase-cred.json` to folder `keys`
### Access Database using SSH Tunnel
Get script tunnel from folder `Grosera - Shared/Developer/Tunnel` in Google Drive

### Environment Variables

| Key | Description | Values |
| --- | ---------- | ----- |
|APP_NAME| Application Name | `Grosera` |
| APP_ENV | Application Environment | `local` or `development` or `production` |
| APP_KEY | Application Key (base64) | `base64:qKaF6HMWb/7zpMhF1eQ8xp3tT4GDlpQ3QnCZIWReV6E=` |
| APP_DEBUG| Retrieving Environment Configuration | `true` or `false` |
| DB_CONNECTION | - | `pgsql` |
| DB_HOST |- | `localhost` |
| DB_PORT | - | `5433` |
| DB_DATABASE | - | `dev_v2_grosera_db` |
| DB_USERNAME | - | `*****` |
| DB_PASSWORD | - | `*****` |
| FIREBASE_SDK_PROD | Firebase SDK for Production | `firebase-cred.json` | 
| FIREBASE_SDK_DEV | Firebase SDK for Development | `firebase-cred.json` |
| LOG_SLACK_WEBHOOK_URL | Slack WebHook Url for development | https://hooks.slack.com/services/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 |  
| FILESYSTEM_DRIVER | - | `gcs` |
| GOOGLE_CLOUD_PROJECT_ID| - | `bromo-b2b-marketplace` |
| GOOGLE_CLOUD_KEY_FILE | - | `/keys/assets-cred.json` |
| GOOGLE_CLOUD_STORAGE_BUCKET| - | `bromo-assets-dev` |
## Contributors
- Dinan Riqal <dinan@nusantarabetastudio.com>
- Diar Ichrom <diar@nusantarabetastudio.com>