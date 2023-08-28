USE web;

CREATE TABLE UserAccounts (
    UserID INT AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    Email VARCHAR(100) UNIQUE,
    PasswordHash VARCHAR(255),
    IsAdmin BOOLEAN,
    PRIMARY KEY (UserID)
);

INSERT INTO UserAccounts (FirstName, LastName, Email, PasswordHash, IsAdmin)
VALUES ('John', 'Doe', 'john.doe@example.com', 'password', TRUE);
