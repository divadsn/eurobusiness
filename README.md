# eurobusiness
A Monopoly-like HTML5 online game using PHP with Redis as Backend.

## Let's start with some basics
Users should be able to create basic accounts (username, email, password and nocaptcha) and login to their accounts using the game panel before starting or joining a new game.

After logging in the user should see a list of available public rooms and the button to create a new room. When creating a new room the user should be able to decide whether he wants a public room or private room which can be only accessed using a generated invite link. Also some game specific options like max. amount of players or start money should the user be able to change, this can be extended later during the development of the game backend. The owner can click on the start button when everyone has joined the room and everyone should be then redirected to the game page.

## What's then?
The game page will require to have some sort of game backend already done, but to answer the question, the game window will be written in JavaScript with the help of jQuery probably and will use timestamps to get updates, so the game will be checking every second for new moves. By using Redis for the game backend it shouldn't slow down the webserver with the amount of update requests, while giving fast response times.
