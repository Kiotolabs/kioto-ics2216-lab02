-- seed.sql : optional sample data for testing (run AFTER setup.php).
-- Replace these rows with your own information. Safe to run on a fresh database.

INSERT OR IGNORE INTO profile (profile_id, full_name, programme, bio)
VALUES (1, 'Sample Student', 'BSc. Fisheries and Aquaculture', 'Sample bio for testing.');

INSERT INTO skill (profile_id, skill_name, level) VALUES
  (1, 'Microsoft Word', 'Advanced'),
  (1, 'HTML and CSS', 'Beginner'),
  (1, 'SQL', 'Beginner'),
  (1, 'Networking (Packet Tracer)', 'Intermediate'),
  (1, 'Scientific writing', 'Intermediate');

INSERT INTO hobby (profile_id, hobby_name, description) VALUES
  (1, 'Football', 'Weekend matches with friends'),
  (1, 'Cooking', 'Tilapia and ugali'),
  (1, 'Music', 'Study playlists');

INSERT INTO movie (profile_id, title, release_year, my_rank, why_i_love_it) VALUES
  (1, 'Sample Movie 1', 2010, 1, 'Because it is great.'),
  (1, 'Sample Movie 2', 2015, 2, 'Because of the story.'),
  (1, 'Sample Movie 3', 2019, 3, 'Because of the visuals.'),
  (1, 'Sample Movie 4', 2021, 4, 'Because of the music.'),
  (1, 'Sample Movie 5', 2023, 5, 'Because it inspires me.');