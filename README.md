# Maisie's WhatsApp Messenger 💕

A simple Laravel API that sends "I love you mummy" messages via WhatsApp Cloud API.

## Requirements

- PHP 8.1+ (or Docker)
- Composer (or Docker)
- A Meta Developer Account with WhatsApp Business API access

## Installation (Docker - Recommended)

1. **Copy the environment file and configure it:**
   ```bash
   copy env.example .env
   ```

2. **Edit `.env` with your credentials** (see Configuration section below)

3. **Generate an app key:**
   ```bash
   docker run --rm -v ${PWD}:/app -w /app php:8.2-cli php -r "echo 'APP_KEY=base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
   ```
   Add this to your `.env` file.

4. **Build and run with Docker Compose:**
   ```bash
   docker-compose up -d
   ```

The API will be available at `http://localhost:8000`

## Installation (Without Docker)

1. **Install dependencies:**
   ```bash
   composer install
   ```

2. **Set up environment:**
   ```bash
   copy env.example .env
   php artisan key:generate
   ```

3. **Configure your `.env` file with WhatsApp credentials:**
   ```env
   # Your API key for securing the endpoint (generate a random string)
   API_KEY=your-secure-random-api-key

   # WhatsApp Cloud API credentials from Meta Developer Portal
   WHATSAPP_ACCESS_TOKEN=your-access-token-from-meta
   WHATSAPP_PHONE_NUMBER_ID=your-phone-number-id
   WHATSAPP_RECIPIENT_NUMBER=447XXXXXXXXX
   WHATSAPP_SENDER_NAME=Maisie
   ```

## Getting WhatsApp Cloud API Credentials

1. Go to [Meta Developer Portal](https://developers.facebook.com/)
2. Create a new app or use an existing one
3. Add the WhatsApp product to your app
4. In WhatsApp > Getting Started, you'll find:
   - **Phone Number ID**: The ID of your WhatsApp Business phone number
   - **Access Token**: Your permanent or temporary access token
5. Add your mummy's phone number to the test numbers (or go live for production)

## Running the Server

**With Docker:**
```bash
docker-compose up -d
```

**Without Docker:**
```bash
php artisan serve
```

The server will start at `http://localhost:8000`

**Stop Docker container:**
```bash
docker-compose down
```

## Usage

### Send Love Message

**Endpoint:** `POST /api/send-love`

**Headers:**
- `X-API-Key: your-api-key`

**Example with cURL:**
```bash
curl -X POST http://localhost:8000/api/send-love \
  -H "X-API-Key: your-secure-api-key" \
  -H "Content-Type: application/json"
```

**Example with PowerShell:**
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/send-love" `
  -Method POST `
  -Headers @{"X-API-Key" = "your-secure-api-key"}
```

### Success Response
```json
{
  "success": true,
  "message": "Message sent successfully!",
  "message_id": "wamid.xxx..."
}
```

### Error Response
```json
{
  "success": false,
  "message": "Invalid or missing API key"
}
```

## Message Content

The message sent will be:
```
I love you mummy 💕

- Maisie
```

## Security

- The endpoint is protected by an API key that must be sent in the `X-API-Key` header
- Store your API key securely and never commit it to version control
- The `.env` file should never be committed to git

## Generating a Secure API Key

You can generate a secure API key using PHP:
```bash
php -r "echo bin2hex(random_bytes(32));"
```

Or using PowerShell:
```powershell
-join ((1..64) | ForEach-Object { '{0:x}' -f (Get-Random -Maximum 16) })
```

## License

Made with love for Mummy 💕

