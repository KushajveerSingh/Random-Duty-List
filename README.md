# Random Duty List
Suppose you have a list of 200 people and you want to assign 120 people of these 200 people daily. What RDL does is assign those 120 people randomley from the list of 200 people and after those 200 people are completed the list is shuffled and then duties are assigned.

This software is made for Chndigarh police (India). So, they had like 20 stations in Chandigarh and they had to assign people to these stations. They had three different ranks of officials to be allocated to each of the station. Here we take those different ranks of officers to be CategoryA, CategoryB, CategoryC and we have to allocate say 2 poeple from CategoryA, 4 from CategoryB and 2 poeple from CategoryC at each station. So we would have 8 poeple at each station. Now we have a list of the police officials and we want to allocate the duties randomely of the officials to each station with the same pattern not being repeated again.

## Installation
1. Use `git clone https://github.com/KushajveerSingh/Traffic` to clone the repository to yout local machine.
2. Store the above folder in your server folder. For example if you are using Apache server with phpmyadmin on Ubuntu store the above folder in `/var/www/html`.
3. Change the server congfiguration in server_init.php.
4. Change the date format to your need. For my case I have put the date to only reflect chnanges in days.

## General WorkFlow
- 'index.php' is the main login page that would open as the home page.
- Then you would be redirected to 'main_page.php'
- From there on every button that is available would have a seperate page of it's own by the same name
- Also refer to the Database folder and view the README to get familiar with the database schema used for this Project.

## License
MIT License
