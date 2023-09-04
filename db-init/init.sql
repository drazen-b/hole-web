USE web;

CREATE TABLE UserAccounts (
    UserID INT NOT NULL AUTO_INCREMENT,
    Username VARCHAR(50) UNIQUE,
    Email VARCHAR(100) UNIQUE,
    PasswordHash VARCHAR(255),
    CreateDateTime DATETIME NOT NULL,
    IsAdmin BOOLEAN,
    PRIMARY KEY (UserID)
);

INSERT INTO UserAccounts (Username, Email, PasswordHash, CreateDateTime, IsAdmin) -- password is "password"
VALUES ('admin', 'admin@example.com', '$2y$10$dHZoN7jL.Za1fqCKZXrSROqMEWGkr1TDAewOlQ1EIKX.lQp1FvvYa', '2023-09-03 12:58:32', TRUE);

CREATE TABLE UserCryptoPurchases (
    PurchaseID INT NOT NULL AUTO_INCREMENT,
    UserID INT NOT NULL,
    CoinID VARCHAR(50) NOT NULL,
    Amount DECIMAL(18, 8) NOT NULL,
    Price DECIMAL(18, 2) NOT NULL,
    PRIMARY KEY (PurchaseID),
    FOREIGN KEY (UserID) REFERENCES UserAccounts(UserID)
);

