Let me clarify exactly how the system currently works and then I will explain what the problem is with the change (and then maybe I will propose a solution).

### How the current system works. 

Alice posts a job on the system. Later on Bob nudge Charles (as a referral or a candidate, it doesn't matter). The a nudge object is created in the database and it contains the following information.

- Alice's user identifier.
- Bob's user identifier.
- Charles's identifier as a person in the address book of Bob (and not its identifier as a user of the system -- which Bob may not be).
- The job identifier.
- The hash, a unique string attached to this particular nudge.

When the sms is sent and Charles opens the job preview page ( url: http://localhost:8000/jobpreview/36/4gaQVDUgN9 ), the system can access all the attributes of the nudge given the nudge hash. 

![screen shot 2016-05-22 at 10 48 10](https://cloud.githubusercontent.com/assets/6035518/15453362/c66671cc-200a-11e6-8ec3-3e650374f625.png)

I have checked that the using a fake hash (a hash that doesn't exist as in http://localhost:8000/jobpreview/36/12345 ) doesn't prevent the page to be displayed. All the job preview page actually needs is a correct job identifier. 

The problem starts if Charles clicks on either [Apply] or [Refer]. In either case Charles is redirected to the registration page

![screen shot 2016-05-22 at 09 36 58](https://cloud.githubusercontent.com/assets/6035518/15453131/d4dff34a-2000-11e6-8a6b-37052f50602f.png)

(The screenshot I pasted shows "Sasha", but it should say "Charles").

At this point Charles is supposed to put his phone number and a sms is sent to him with a 4 digits code and upon entering that code he access the job page (and if a candidate can apply to it).

Note that during that entire process the hash was carried over from one page to another and therefore the system always knew which user was targeted and which job was concerned and which user initiated the job.

### More details about the registration process. 

If a user, Charles, looking at the job preview page decides to click on [Apply], he is redirected to the registration page. At this point the system treats him as Bob's contact (despite the code confusingly referring to him as "user"). Also Charles need to enter his phone number manually (despite the system already knowing it). Displaying the registration page without knowing who is looking at it would not be too difficult. The page will just stop showing "Hi Charles". 

If Charles then enter his phone number the next page is the validation page. 

![screen shot 2016-05-22 at 10 11 22](https://cloud.githubusercontent.com/assets/6035518/15453222/a137dbe8-2005-11e6-83aa-88a5f6f6e1f3.png)

One property of the validation page is that it actually creates Charles as a user of the system. It does so using the phone number given by Charles on the registration page and the country code. As part of creating the user, the 4 digit code is created and an sms with the 4 digit code is sent to the phone number given by Charles.

If Charles receives that pin and use it (this is an Ajax call), Charles as a user of the system is confirmed, and a session cookie is created for him and he is then sent to the job page.

The job page then does what you expect, validate the session cookie and show the job, and if Charles clicked on [Apply] few steps ago, he can apply to the job.

### Last but not least

The system treats "referral requests" and "candidate requests" (nudges actually are candidate requests) differently. So everything I said above and that I presented for candidate requests should be duplicated for referral requests.






