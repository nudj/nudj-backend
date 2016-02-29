UUID: 030030ce-d51b-4355-b50f-e021fb3b37b2

### Part 1

When a user downloads the app, they provide (manually) their phone number. A record is created in the database for that phone number, a four digit pin is generated that is saved against the phone number, and the four digit pin is sent by sms to the phone number. 

Then if/when a `verify` call is made that contains both the phone number and the correct pin, the user record is set to "verified".

See API call description for more details.   

The outcome of this step is that a token is going to be sent to the user's phone, and this token is used as means of authentication. 

Robyn: JD7duPsAC1qgea4UD4otZpBG2wLKBxFIIhz32zFk1RdwWR4bsiCjeFwofWSz





