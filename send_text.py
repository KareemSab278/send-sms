# # Download the helper library from https://www.twilio.com/docs/python/install
# import os
# from twilio.rest import Client

# # Find your Account SID and Auth Token at twilio.com/console
# # and set the environment variables. See http://twil.io/secure
import os
# If you use python-dotenv, uncomment the next line:
# from dotenv import load_dotenv; load_dotenv()
from twilio.rest import Client

# Load secrets from environment variables
account_sid = os.environ.get('TWILIO_ACCOUNT_SID')
auth_token = os.environ.get('TWILIO_AUTH_TOKEN')
twilio_from = os.environ.get('TWILIO_FROM_NUMBER')

if account_sid and auth_token and twilio_from:
    client = Client(account_sid, auth_token)
    message = client.messages.create(
        body='Hi there',
        from_=twilio_from,
        to='+447793515995'
    )
    print(message.sid)
else:
    print('Twilio credentials not set in environment.')



# Prerequisite: install the requests module e.g. using pip or easy_install
# twilio
#================================================================================
# firetext

import requests

api_key = os.environ.get('FIRETEXT_API_KEY')
end_point = "sendsms"
url_args = {
    "apiKey": api_key,
    "to": "4400000000000",
    "from": "kareem",
    "message" : "I found firetext: https://app.firetext.co.uk/ and twilio: https://www.twilio.com/ - twilio is a little more expensive from what i saw"
}

def send_api_message(end_point, url_args):

    url = "https://www.firetext.co.uk/api/" + end_point
    response = requests.post(url, params = url_args)
    return response.text

resp = send_api_message(end_point, url_args)
print (resp)