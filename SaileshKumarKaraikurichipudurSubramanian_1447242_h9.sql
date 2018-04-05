-- (1) (a) The titles of films with an id of 5 or less.
-- COUNT = 5

SELECT A.TITLE
FROM FILM A
WHERE A.FILM_ID <= 5;

-- (b) The names of actors who appeared in more than 35 films.
-- COUNT = 6

SELECT CONCAT(A.FIRST_NAME, ' ', A.LAST_NAME)
FROM FILM_ACTOR B, ACTOR A
WHERE A.ACTOR_ID = B.ACTOR_ID
GROUP BY B.ACTOR_ID
HAVING COUNT(B.ACTOR_ID) > 35;

-- (c) All film title elements the actor with id 10 appears in.
-- COUNT = 22

SELECT A.TITLE
FROM FILM A, FILM_ACTOR B, ACTOR C
WHERE A.FILM_ID = B.FILM_ID
AND B.ACTOR_ID = C.ACTOR_ID
AND C.ACTOR_ID = 10;

-- (d) All title elements of films that contain both 'Delete Scenes' and 'Trailers' as special features.
-- COUNT = 240

SELECT A.TITLE
FROM FILM A
WHERE A.SPECIAL_FEATURES LIKE '%Deleted Scenes%'
AND A.SPECIAL_FEATURES LIKE '%Trailers%';