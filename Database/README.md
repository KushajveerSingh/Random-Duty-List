# Database Schema
1. Admins Table -> Contains the list of all the admins and their passwords
2. AssignedA, AssignedB, AssignedC -> Contains the list of the poeple that were assigned duties on a particular day from their respective categories.
3. CategoryA, CategoryB, CategoryC -> Contains the main list of the people belonging to that category.
4. RandomListA, RandomListB, RandomListC -> The random shuffle order from where we would assign duties. We would traverse it sequentially from the top and make Free=0 for the person whom we have assigned duty. Now when the list would be traversed to the end, we would delete all the contents and insert the data basck to it but now in a new random order.
5. StartIndex -> Gives the location of the first free person in the RandomList tables. It is this person from where we would start assigning duties for the next day.
6. Stations -> List of all the stations where we want to assign duties.
