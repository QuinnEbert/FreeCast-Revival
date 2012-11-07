# Create a database called 'freecast' (or whatever) and import this SQL into it, then create a user and password to access the database fully,
# and then edit the info in ./includes/db.php

CREATE TABLE `user` (`name` TEXT NOT NULL , `nick` TEXT NOT NULL , `pass` TEXT NOT NULL , `email` TEXT NOT NULL , `show` TEXT NOT NULL , `showdesc` TEXT NOT NULL , `slots` TEXT NOT NULL, `allowemail` TEXT NOT NULL, `profilename` TEXT NOT NULL, `location` TEXT NOT NULL, `age` TEXT NOT NULL, `description` TEXT NOT NULL, `musicgenre` TEXT NOT NULL);
