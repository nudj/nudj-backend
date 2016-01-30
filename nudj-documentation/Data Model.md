## Nudj Data Model

This contains three sections: 

The first contains the primary objects (nodes of the graph). The second contains the (labelled) links between them, and the third contains the list of events we currently record. This is knowledge from the database (the backend code itself is irrelevant). 

**Object**:

- Admin User (Person who can login to the Desk)
- Chat (The abstract fact that a group of people participated in a conversation about a job) [group: 2 people it seems]
- Country
- Device Token (Only relevant for app notifications as far as I can see).
- Job
- Skill
- App User

**Links**: 

- Chat <-> User
- User <-> Contact (User)  ( Link stands for the relation of being an address book contact of another user )
- User <-> Device
- User <-> Job ( Link stands for "User likes Job" )
- User <-> Job ( Link stands for "User has favourited Job" )
- User <-> Skill ( I guess it means User has Skill, but I am not sure )
- Job <-> Skill ( Link stands for "Job requires Skill" )

**Events**:

- Referrals: The fact that a job poster ask somebody to find a potential candidate for a job. Dated
- Nudge: The fact that a person (referral) is forwarding a job to a potential candidate. Dated.
- Application: The fact that a person { is applying to } / { is interested in } a job. Dated.

- Notification: I don't really understand what this is. Dated.

