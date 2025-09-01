# SMS API Service Documentation

## 📦 Overview

This API service provides a PHP class and endpoint for sending SMS messages via the FireText API.  
It is designed for easy integration with other scripts, web pages, or systems.

---

## 🚀 How It Works

### 1. Class Structure

- **Class:** `send_sms` (located in `apweb2020/api/actions/service/send_sms.php`)
- **Main Method:** `callSendTextApi($to, $message, $from)`
  - Sends an SMS using FireText via HTTP POST.
- **API Endpoint:** Handles POST requests with parameters (`to`, `message`, etc.) and returns JSON.

---

### 2. Sending an SMS (Direct Call)

You can send an SMS by creating an instance of the class and calling the method:

```php
require_once '/path/to/apweb2020/api/actions/service/send_sms.php';
use CadAPI\Actions\service\send_sms;

$sms = new send_sms();
$result = $sms->callSendTextApi('07123456789', 'Hello from PHP!', 'Coinadrink HQ');
echo $result; // FireText API response
```

---

### 3. API Endpoint Usage

You can POST to the API endpoint (e.g., from another PHP script, curl, Postman, etc.):

**POST URL:**  
`/apweb2020/api/actions/service/send_sms.php`

**POST Parameters:**
- `api` (any value, just triggers API mode)
- `to` (required): recipient phone number(s)
- `message` (required): SMS text (max 250 chars)
- `from` (optional): sender name (default: "Coinadrink HQ")
- `schedule` (optional): schedule time
- `reference` (optional): reference string


**Response:**
```json
{
  "status": "success",
  "result": "{...FireText API response...}"
}
```

---

## 🛡️ Validation & Security

- Checks for valid phone number format (regex).
- Requires user authentication (`$_SESSION['user-id']`).
- Limits message length to 250 characters.
- Returns clear error messages and HTTP status codes.

---

## 🧩 How to Understand the Code

- **Class-based:** Encapsulates SMS logic for reuse and clarity.
- **API method:** `callSendTextApi` builds and sends the POST request to FireText.
- **API endpoint:** Handles POST requests, validates input, calls the SMS method, and returns JSON.
- **Extensible:** You can add more providers or features by adding new methods.

---

## 📝 How to Use in Other Scripts

1. **Include the class file:**
   ```php
   require_once '/path/to/apweb2020/api/actions/service/send_sms.php';
   use CadAPI\Actions\service\send_sms;
   ```

2. **Create an instance and send SMS:**
   ```php
   $sms = new send_sms();
   $result = $sms->callSendTextApi('07123456789', 'Your message here', 'Coinadrink HQ');
   ```

3. **Or, POST to the API endpoint from any language or tool.**

---

## 🏷️ Notes

- The API key is currently hardcoded for FireText. For production, move it to a `.env` file or environment variable.
- The class expects a valid session user for security.
- All responses are JSON for easy integration.

---
