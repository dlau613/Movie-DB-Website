-- create Movie Actor and Director first because they are referenced by the other tables 

-- primary key is id because every Movie has a unique id and should only appear once
-- check that id is positive
create table Movie(
	id int primary key, 
	title varchar(100), 
	year int, 
	rating varchar(10), 
	company varchar(50),
	check (id >=0)
) engine=InnoDB;
-- primary key id because all people (acotrs and directors have a unique id)
-- check that id is positive
-- check that sex is either Male or Female and not some random string or spelled wrong. could be controversial...
create table Actor(
	id int primary key, 
	last varchar(20), 
	first varchar(20), 
	sex varchar(6), 
	dob date, 
	dod date,
	check (id>=0),
	check(sex="Male" or sex="Female") 
) engine=InnoDB;

-- primary key id because all people (acotrs and directors have a unique id)
-- check that id is positive
create table Director(
	id int primary key, 
	last varchar(20), 
	first varchar(20), 
	dob date, 
	dod date,
	check (id>=0)
) engine=InnoDB;

-- primary key (mid,genre) because a movie can have multiple genres
-- mid references Movie(id) because the movie must exist
create table MovieGenre(
	mid int, 
	genre varchar(20),
	foreign key(mid) references Movie(id)
		on delete cascade
		on update cascade,
	primary key(mid,genre)
) engine=InnoDB;

-- primary key mid assuming movies can have multiple directors
-- mid references Movie(id) because the movie must exist
-- did references Director(id) because the director must exist
-- set all forgein keys (based on movie, director, or actor id) to on delete cascade
create table MovieDirector(
	mid int,
	did int,
	foreign key(mid) references Movie(id)
		on delete cascade
		on update cascade,
	foreign key(did) references Director(id)
		on delete cascade
		on update cascade,
	primary key(mid,did)
) engine=InnoDB;

-- primary key (mid,aid,role) because a movie will have many actors and actors can play multiple rows
-- mid references Movie(id) because the movie must exist
-- aid references Actor(id) because the actor must exist
create table MovieActor(
	mid int, 
	aid int, 
	role varchar(50),
	foreign key(mid) references Movie(id)
		on delete cascade
		on update cascade,
	foreign key(aid) references Actor(id)
		on delete cascade
		on update cascade,
	primary key(mid,aid,role)
) engine=InnoDB;

-- mid references Movie(id) because the movie must exist
-- check that rating is between 0 and 5 inclusive
create table Review(
	name varchar(20), 
	time timestamp, 
	mid int, 
	rating int, 
	comment varchar(500),
	foreign key(mid) references Movie(id)
		on delete cascade
		on update cascade,
	primary key(name,mid),
	check (0 <= rating and rating <=5)
) engine=InnoDB;

create table MaxPersonID(
	id int primary key
) engine=InnoDB;

create table MaxMovieID(
	id int primary key
) engine=InnoDB;



