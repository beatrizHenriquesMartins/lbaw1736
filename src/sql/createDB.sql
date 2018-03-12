DROP TABLE IF EXISTS user;

CREATE TABLE user {
  id SERIAL NOT NULL,
  firstName TEXT,
  lastName TEXT,
  username TEXT NOT NULL,
  email TEXT NOT NULL,
  password TEXT NOT NULL,
  imageURL TEXT NOT NULL,
  dateCreated TIMESTAMP DEFAULT now() NOT NULL,
  dateModified TIMESTAMP NOT NULL
  active INTEGER NOT NULL
};

CREATE TABLE chatSupport {
  id INTEGER NOT NULL
};

CREATE TABLE user {
  id SERIAL NOT NULL,
  nif INTEGER NOT NULL,
  cellphone TEXT,
  id_chat INTEGER NOT NULL
};

CREATE TABLE message {
  id SERIAL NOT NULL,
  message TEXT NOT NULL,
  dateSent TIMESTAMP DEFAULT now() NOT NULL,
  id_chat INTEGER NOT NULL,
  sender TEXT NOT NULL
};

CREATE TABLE chat {
  id SERIAL NOT NULL,
  id_chatSupport INTEGER NOT NULL,
};
