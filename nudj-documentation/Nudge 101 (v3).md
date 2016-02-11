- Starting point

```
Robyn McGirl has messaged you via Nudj: 
Testing1633 
Take a look: https://mobileweb.nudj.co/jobpreview/1/Ezfldg4VLZ
```

- Running: the mobileweb app with `php artisan serve`.

- Visiting: `http://localhost:8000/jobpreview/3/qMrOQlqBHI`. And see the job description. We ended up there because of an SMS that was sent to me [previous point]. Note that at this point the hash in the URL doesn't matter for the actual display, but matters as the hash is written in the HTML (JavaScript) source.

- Click on [Apply]

- We are redirected to `http://localhost:8000/register/nudge/qMrOQlqBHI`, where I have to enter my phone number so that a SMS is sent to me. This step basically forces the recipient of the nudge to give us their phone number. 

- I enter my phone number clicked [send] and have been redirected to the validate page `http://localhost:8000/validate`, where I have to enter my 4 letter digit, which I received on the phone. 

- Entering the code leads you to the job page. `http://localhost:8000/job/3/qMrOQlqBHI`. Upon clicking [Apply] you are given a notification that you have applied to the job.


 