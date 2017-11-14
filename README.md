# secure_loginPage_from_rateLimit

![Rate Limit](https://raw.githubusercontent.com/ihrifat2/secure_loginPage_from_rateLimit/gh-pages/rate_limit.gif)

## Install

[XAMPP](https://www.apachefriends.org/index.html)

1. Add rate_limit.sql in phpmyadmin.
2. Paste all files in htdocs folder.


## Feature

1. It'll take first 5 fail login attempt and response 200 ok
2. Next 10 fail login attempt will be response as 429 too many request
3. After 15 fail login attempt user IP Address will be black listed(user can't even access login page) and response will be 401 Unauthorized
4. Finally from 16 fail attempt user need to wait 5 minutes for login
5. 5 minutes later user can access login page as his/her IP Address is removed or deleted from black list.
