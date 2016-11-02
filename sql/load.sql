load data local infile '~/data/movie.del' into table Movie fields terminated by ',' OPTIONALLY ENCLOSED BY '"';

load data local infile '~/data/actor1.del' into table Actor fields terminated by ',' OPTIONALLY ENCLOSED BY '"';
load data local infile '~/data/actor2.del' into table Actor fields terminated by ',' OPTIONALLY ENCLOSED BY '"';
load data local infile '~/data/actor3.del' into table Actor fields terminated by ',' OPTIONALLY ENCLOSED BY '"';

load data local infile '~/data/director.del' into table Director fields terminated by ',' OPTIONALLY ENCLOSED BY '"';

load data local infile '~/data/moviegenre.del' into table MovieGenre fields terminated by ',' OPTIONALLY ENCLOSED BY '"';

load data local infile '~/data/moviedirector.del' into table MovieDirector fields terminated by ',';

load data local infile '~/data/movieactor1.del' into table MovieActor fields terminated by ',' OPTIONALLY ENCLOSED BY '"';
load data local infile '~/data/movieactor2.del' into table MovieActor fields terminated by ',' OPTIONALLY ENCLOSED BY '"';

insert into MaxPersonID values(69000);

insert into MaxMovieID values (4750);

