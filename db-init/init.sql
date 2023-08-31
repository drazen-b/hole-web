USE web;

CREATE TABLE UserAccounts (
    UserID INT NOT NULL AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL,
    Email VARCHAR(100) UNIQUE,
    PasswordHash VARCHAR(255),
    CreateDateTime DATETIME NOT NULL,
    IsAdmin BOOLEAN,
    PRIMARY KEY (UserID)
);

-- INSERT INTO UserAccounts (FirstName, LastName, Email, PasswordHash, IsAdmin)
-- VALUES ('John', 'Doe', 'john.doe@example.com', '$2y$10$hbbpi0/MV04nMb2A5NMj.unoeBf4Mvz1c9rk.FoQ/cl4lwRDXAmZC', TRUE);

CREATE TABLE Coins (
    CoinID INT AUTO_INCREMENT,
    Name VARCHAR(50),
    Symbol VARCHAR(10),
    PRIMARY KEY (CoinID)
);

CREATE TABLE UserCoins (
    UserCoinID INT AUTO_INCREMENT,
    UserID INT,
    CoinID INT,
    Amount DECIMAL(18, 8),
    PriceWhenBought DECIMAL(18, 8),
    PRIMARY KEY (UserCoinID),
    FOREIGN KEY (UserID) REFERENCES UserAccounts(UserID),
    FOREIGN KEY (CoinID) REFERENCES Coins(CoinID)
);
