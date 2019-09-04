*Tombras Code Challenge*
WordPress site has been set up on Pantheon and shared with Ndmaynard42@gmail.com
http://dev-bigfoot.pantheonsite.io
 
1.  Incorporate “Bigfoot Locator” into Wordpress –
    + Added stipped down Theme to remove css conflicts and added a Plugin to control functionality. 	

2.  Add functionality to allow anonymous users to submit new sightings.
3.  Add functionality to allow authenticated users to submit UFO sightings
    + Added an HTML form and wp insert script to load data into the custom table
	- Question: Database connection best practice?
	
4.  For both sighting types, allow photographic evidence to be uploaded. If a photo is uploaded, clicking the map point should show the photo
    + Added wp file upload functionality

5.  On the map, Bigfoot sightings should be red (as-is), UFO sightings should be green (#39ff14) 
    + Added type to the db and map parcing

6.  Allow users to expand the radius of the draggable map circle 
    + Added new event listener and function. Calls probability function when radius updates. Didn't update math.
 
Nice to haves:

7.  Force HTTPS 
    + Edit htaccess file
	
8.  Add event schema for sightings
    + Manually added WebApplication schema to template header
	
9.  Search by zip code
    + Implemented Google geocoder 
	
10. Search by sighting type
    + Added filters and a filter function
 
11. All code must be committed via git to Pantheon
  
 
*** Overall thoughts: ***
Proof of concept staging. I would have built the map differently had I known it would be deployed via WordPress. 
I simply used the code I had already written and implemented it without making huge rewrites to the original code.

Changes if for production:
	+ Made pathing universal
	+ Fix database connection
	+ Added side panel widgets
	+ More integratable
	+ Etc.

TO DO
Add Zipcode

Add https
Upload to Dev Server via git (have questions)

