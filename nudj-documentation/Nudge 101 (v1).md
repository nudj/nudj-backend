UUID: 2c4e861f-be97-49a2-ad53-2d9c2f6a7f74

## Step 1

From a User point of view the nudge starts when one receives a sms, with a link: https://api.nudj.co/register/nudge/v747uur2Ym (current url).

http://localhost:8000/register/nudge/v747uur2Ym (current url).

The page asks me for my phone number.

In the database a nudj is
 
- an employer_id (user id)
- a referrer_id  (user id)
- a candidate_id (???)
- a job_id (job id)
- a hash

The hash is the last component of the URL and is used as a reference to the other information. 


## Step 2

Arrived at: http://localhost:8000/validate

This page says that a verification code has been sent to the phone; and asks to input the code.

When trying on local host I did not receive the code, but I read it from the database. 


## Step 3

Arrived at: http://localhost:8000/job/98/v747uur2Ym
 
Where I can see the job description


