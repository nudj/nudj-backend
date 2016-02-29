When Alice blocks Bob: Bob no longer appears in the list of people Alice can chat to (and vice and versa).

When Alice reports Bob: as blocking, but the Nudj admins need to assess the situation.

When Alice blocks a Job, that job no longer appers in Alice's listings and Nudj admins need to assess the situation.

### Informal Specifications

1. From the client (iOS)'s point of view, blocking and reporting are the same: the thing, user or job, that has been blocked or reported no longer appear in that client's listings. 

2. From the backend point of view, blocking is silent, but reporting will have to require a human's attention. 

3. In this moment the backend offers: 
	jobs/{id}/block  : blocking of job
	users/{id}/block : blocking of user (including hirers)
	users/{id}/report : reporting of user (including hirers)

4. For an indefinite amount of time, the backend might treat job blocking as job reporting, at its discretion.  

5. This has nothing to do this the button labels that the iOS use in the user interface ("report", "block", "avoid", "hate" etc....).

6. If the operation of blocking a job is done by the job owner himself (in essence the hirer), return a 400.

7. If a user is attempting to block/report themseves. return a 400.

