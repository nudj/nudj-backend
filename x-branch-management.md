Rule 1: The `production` branch, in all circumstances should reflect exactly what is in production.

Rule 2: The test servers usually show what the `master` branch shows, but at occasions they can show what the `pascal` branch (or feature specific branches) shows. 

Rule 3: In normal circumstances development is done on the `pascal` branch (and/or other experimental branches) and then commited to `master` when ready, and then commited to `production` at production releases. The last commit to `master` before a production release should be a version update.

Rule 4: If an emergency production change needs to be made, it can be made on the `production` branch (with an increase in version number) and then the change to needs to be commited to `master` and then to `pascal`.

