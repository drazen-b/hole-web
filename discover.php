<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HoleV2</title>
    <link rel="stylesheet" type="text/css" href="../styles/style.css" />
    <link rel="stylesheet" type="text/css" href="../styles/discover.css" />
</head>
<body>

    <div id="navigation">
        <a href="../index.html">
            <div id="logo-container">
                <img id="page-logo" src="../images/logo/holeiconwhite.png" alt="Page logo">
                <p id="page-name">hole</h1>
            </div>
        </a>
    
        <div id="middle-links">
            <a href="#" id="discover-link">discover</a>
            <a href="#" id="profile-link">profile</a>
        </div>
    
        <div id="login-container">
            <a href="#" id="login-link">log In</a>
        </div>
    </div>
    
    <div id="search-container">
        <div id="search-about">
            <p>Search for wanted cryptocurrencies bellow. </p>
            <p>Data is collected from CoinGecko API</p>
        </div>
        
        <div class="search-box-container">
            <input type="text" placeholder="Search..." class="round-search-box">
            <button class="search-button"><img src="../images/search-icon-white.png" alt="Search icon"></button>
        </div>
         <div id="search-results"></div>

    </div>

    <div id="top-list-container">
        <p>Top 100 currencies</p>

        <div id="coins-info">
            <p>#</p>
            <p>coin</p>
            <p>price</p>
            <p>1h</p>
            <p>24h</p>
            <p>7d</p>
            <p>24h volume</p>
            <p>Mkt Cap</p>
        </div>


        <div class="coin">
            <p class="rank">1</p>
            <div>
                <!-- <img src="../images/bitcoin.webp" alt="Bitcoin image"> -->
                <p>Bitcoin</p>
            </div>
            <div>$26,068.43</div>
            <p>-0.1%</p>
            <p>-0.0%</p>
            <p>-11.4%</p>
            <p>$11,422,902,539</p>
            <p>$507,210,274,025</p>
        </div>

    </div>

</body>
</html>