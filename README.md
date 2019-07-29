# Bigfoot Sighting Analysis
This application computes the probability that you will encounter a bigfoot at a particular lat / lng. The 
sighting data used to generate the map and charts are real, however the probability calculation is up for debate.
It is calculated by doing some arbitrary math with random chance (chances of winning the lottery), proximity, and 
area sightings. Charts and tables are provided to help aid your search and determine optimal season, moon phase, 
and so forth. If you encounter a bigfoot by using this application. I cannot accept responsibility for potential
injury. Please use at your own risk.


This code can easily be adapted to a real world scenario. By adding real estate data, you could create
a heat map for "No Vacancy" properties in a particular area. Thus discovering the optimal locations to
purchase a vacation rental.




* **Demo:** [https://kitacranfill.com/bigfoot/](https://kitacranfill.com/bigfoot/)
* **Visualized Tests:** [https://kitacranfill.com/bigfoot/spec/specrunner.html](https://kitacranfill.com/bigfoot/spec/specrunner.html)
* **Visualized Documentation:** [https://kitacranfill.com/bigfoot/docs](https://kitacranfill.com/bigfoot/docs)


This sample demonstrates:

* Use of Ajax and PHP for server communication
* API implementation
* Use of Flex/Responsvie Css
* Use of JavaScript functions
* Input and output operations
* Use of Jasmine for Unit testing
* Use of Git for version control
* Use of JSDoc for documentation



### Prerequisites

#### Google API Key
Instructions to obtain your own API key visit this 
[tutorial](https://developers.google.com/maps/documentation/javascript/tutorial).

```
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"async defer></script>
```

#### Docker
In order to run this container you'll need docker installed.

* [Windows](https://docs.docker.com/windows/started)
* [Linux](https://docs.docker.com/linux/started/)

## Installing

Build the container
```
docker-compose build
```

Start the container in the background
```
docker-compose up -d
```

#### Import the database
In your browser, navigate to `localhost:8080`

Login to phpMyAdmin

* demo user: root
* demo pass: P@55w0rd

> **NOTE:** Login credentials can be changed in inc/conn.php and docker/docker-compose.yml


Import sql file at `localhost:8080/db_import.php?db=bigfoot`

* Click "Choose File"
* Choose *Docker/bfro_reports_geocoded.sql*
* Click "Go"



#### Linux
Site now available at `localhost:8080/bigfoot-sighting analysis`

#### Windows
Find Windows www port by using
```
docker ps
```

![Find Windows Port](https://kitacranfill.com/bigfoot/images/port.png)

Site now available at `localhost:[winport]/bigfoot-sighting analysis`



### Troubleshooting:
Map not working? Make sure to include your Google Map API key in index.html


## Testing
Tests can be executed by browsing to /spec/specrunner.html

```
project
│   README.md
│   ...    
│
└──spec
   │   index.spec.js			//unit tests
   │   specrunner.html			//page displaying tests
   │
   └───fixtures
   │   │   index.html			//fixed enviroment in which test are run
   │
   │
   └───jasmine
   │   │   jasmine-ajax.js
   │   │   jasmine.jquery.js
   │   │   ...
   │
   │
   └───support
       │   jasmine.json

```



## Documentation
Documentation can be generated using

```
npm run jsdoc
```

## Built With

* [Google Maps JavaScript API](https://developers.google.com/maps/documentation/javascript/tutorial) - Map API
* [Chartjs](https://www.chartjs.org/) - Chart visualizations
* [jQuery](https://jquery.com/) - The web framework used
* [Bigfoot Sighting Data](https://data.world/timothyrenner/bfro-sightings-data) - Data being analyzed


## Authors

* **Kita Cranfill** - *Development* - [GitHub](https://github.com/kita86)


## Acknowledgments

* Thanks Timothy Renner for providing the Bigfoot Sighting data.
