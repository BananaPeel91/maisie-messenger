# Maisie's Messenger 💕

A simple Laravel API that sends "I love you mummy" emails from Maisie.

## Requirements

- Docker (recommended) or PHP 8.1+
- A Gmail account with App Password

## Quick Start with Docker

1. **Clone the repo and configure:**
   ```bash
   git clone https://github.com/bananapeel91/maisie-messenger.git
   cd maisie-messenger
   copy env.example .env
   ```

2. **Edit `.env` with your credentials:**
   - `API_KEY` - A secure random string for authentication
   - `MAIL_USERNAME` - Your Gmail address
   - `MAIL_PASSWORD` - Your Gmail App Password (see below)
   - `MAIL_FROM_ADDRESS` - Same as MAIL_USERNAME
   - `RECIPIENT_EMAIL` - Your mum's email address

3. **Generate an APP_KEY:**
   ```bash
   docker run --rm php:8.4-cli php -r "echo 'base64:' . base64_encode(random_bytes(32));"
   ```
   Add this to your `.env` file.

4. **Build and run:**
   ```bash
   docker-compose up -d --build
   ```

## Getting a Gmail App Password

1. Go to [myaccount.google.com/security](https://myaccount.google.com/security)
2. Enable **2-Step Verification** if not already enabled
3. Go to [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
4. Create an app password for "Mail"
5. Copy the 16-character password (remove spaces when adding to `.env`)

## Usage

### Send Love Message

**Endpoint:** `POST /api/send-love`

**Headers:**
- `X-API-Key: your-api-key`

**Example with cURL:**
```bash
curl -X POST http://localhost:8001/api/send-love \
  -H "X-API-Key: your-api-key"
```

**Example with PowerShell:**
```powershell
Invoke-RestMethod -Uri "http://localhost:8001/api/send-love" `
  -Method POST `
  -Headers @{"X-API-Key" = "your-api-key"}
```

### Success Response
```json
{
  "success": true,
  "message": "Message sent successfully!"
}
```

## Message Content

Your mum will receive an email with:
- **Subject:** A message from Maisie 💕
- **Body:** I love you mummy 💕 - Maisie

## Security

- The endpoint is protected by an API key in the `X-API-Key` header
- Never commit your `.env` file to version control
- Keep your API key and Gmail app password secure

## Docker Commands

```bash
# Start
docker-compose up -d

# Stop
docker-compose down

# Rebuild after changes
docker-compose up -d --build

# View logs
docker logs maisie-messenger
```

## License

Made with love for Mummy 💕
