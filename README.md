This service loads the day's moonphase with PHP + a lil htaccess file thanks to the [SunCalc](https://github.com/gregseth/suncalc-php) PHP project. 
![Moon Phase](https://dark.properties/moonphase/moonphase/01-25-2024.png)
I made a quick lil service to show an emoji of the Moon based on the current date for the fantastic [Dark Properties](https://dark.properties) newsletter and thought I'd share more widely.

The format for this service is: `https://dark.properties/moonphase/moonphase/01-25-2024.png` so it works well with any platform where you can programmatically set MMDDYYY, or in our case: Sendy on a PHP server. It will essentially give you the day's phase. An example of using this in a sendy template: `https://dark.properties/moonphase/moonphase/[currentmonthnumber]-[currentdaynumber]-[currentyear].png`

You can also load: `https://dark.properties/moonphase/moonphase/today.png`
 
You can test this using the Dark Properties server, which has a moonphase directory with the files in it, simply use: 

`<img src="https://dark.properties/moonphase/moonphase/[currentmonthnumber]-[currentdaynumber]-[currentyear].png" width="20" height="20">`

... In your Sendy email. Here's a [gist](https://gist.github.com/themorgantown/1f01fc2bc90c01a64c73dcc9f0b6c259) to set this up yourself. (Don't rely on the dark.properties service, it may go down)

Place this within a /moonphase/ directory on your php7+ server and you're good to go!