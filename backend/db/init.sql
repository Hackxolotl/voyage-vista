CREATE TABLE destinations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  description TEXT,
  price INT
);

INSERT INTO destinations (name, description, price)
VALUES
('Paris', 'Ville lumière', 120),
('Rome', 'Ville antique', 150),
('Tokyo', 'Ville futuriste', 900);
