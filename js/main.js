/* Global Window */
var city;
var country;
var APIKey = '6f206707a93aceba';

var thisSecond;
var thisMinute;
var thisHour = moment().format('HH');
var thisTime;
var thisDate = moment().format('ddd, MMM DD, YYYY');

/**
 * LAST UPDATE REFRESH
 *
 * Refresh the update time while users return or click refresh button
 *
 */
function lastUpdateRefresh() {
    var lastUpdateText = moment().format('lll');
    $('#lastUpdateText').text('Last updated: ' + lastUpdateText);
}

/**
 * DISPLAY DATE
 *
 * Show the text of Date on page
 *
 * @param Integer boxIndex is the index of weather box which is assigned in setup() by
 *        submitting forms.
 */
function displayDate(boxIndex) {
    var dateIndex = "#d" + boxIndex;
    thisDate = thisDate;
    $(dateIndex).text(thisDate);
};

/**
 * UPDATE TIME
 *
 * Keep the time updating on page.
 *
 * TODO: The time will not updating after other form is submitted.
 *
 * @param Integer boxIndex is the index of weather box which is assigned in setup() by
 *        submitting forms.
 */
function updateTime(boxIndex) {
    var timeIndex = "#t" + boxIndex;

    thisSecond  = Number(moment().format('ss'));
    thisMinute  = Number(moment().format('mm'));
    thisHour    = Number(thisHour);

    if (thisSecond == 60) {
        thisSecond = 0;
        thisMinute = thisMinute + 1;
    };
    if (thisMinute == 60) {
        thisMinute = 0;
        thisHour = thisHour + 1;
    };

    if (thisSecond < 10) {
        thisSecond = "0" + thisSecond;
    };
    if (thisMinute < 10) {
        thisMinute = "0" + thisMinute;
    };
    if (thisHour < 10) {
        thisHour = "0" + thisHour;
    };

    thisTime = thisHour + ':' + thisMinute + ':' + thisSecond;

    $(timeIndex).text(thisTime);

    setTimeout(updateTime, 1000);
};

/**
 * LOAD TIME
 *
 * Use the UTC data from API response to set up timezone.
 *
 * @param Variable response is the response results from API.
 * @param Integer boxIndex is the index of weather box which is assigned in setup()
 *        by submitting forms.
 */
function loadTime(response, boxIndex) {
    if (response.response.error) {
        // alert(response.response.error);
        alert('Please check your input!');
        return;
    };

    var globalTimeUTC = response.current_observation.local_tz_offset;
    thisHour = moment().utcOffset(globalTimeUTC).format('HH');
    thisDate = moment().utcOffset(globalTimeUTC).format('ddd, MMM DD, YYYY');

    updateTime(boxIndex);
    displayDate(boxIndex);
};

/**
 * LOAD WEATHER
 *
 * Use the forecast data from API response to get forecast info and display on page.
 *
 * @param Variable response is the response results from API.
 * @param Integer boxIndex is the index of weather box which is assigned in setup()
 *        by submitting forms.
 */
function loadWeather(response, boxIndex) {
    if (response.response.error) {
        // alert(response.response.error);
        alert('Please check your input!');
        return;
    };
    // console.log("response=" +JSON.stringify(response));  // Show JSON.response in Console.

    for (var i = 1; i <= 5; i++) {
        var forecastClass = '#forecast' + boxIndex +'_' + i;
        $(forecastClass).empty();

        var forecastDate = response.forecast.simpleforecast.forecastday[i]['date']['weekday'];

        var fahrenheitHigh = response.forecast.simpleforecast.forecastday[i]['high']['fahrenheit'];
        var fahrenheitLow  = response.forecast.simpleforecast.forecastday[i]['low']['fahrenheit'];
        var fahrenheit     = fahrenheitLow + '&deg;F' + '–' + fahrenheitHigh + '&deg;F';
        var fahrenheitDate = "<br/>" + fahrenheit + "<br/>" + forecastDate;

        // var celciusHigh = response.forecast.simpleforecast.forecastday[i]['high']['celsius'];
        // var celciusLow  = response.forecast.simpleforecast.forecastday[i]['low']['celsius'];
        // var celsius     = celciusLow + '&deg;C' + '–' + celciusHigh + '&deg;C';
        // var celsiusDate = "<br/>" + celsius + "<br/>" + forecastDate;

        var iconURL = "http://icons.wxug.com/i/c/i/";
        var forecastIcon = response.forecast.simpleforecast.forecastday[i]['icon'];
        iconURL = iconURL + forecastIcon + '.gif';

        $('<img src="' + iconURL + '" />').appendTo(forecastClass);
        $(forecastClass).append(fahrenheitDate);
    };
};

/**
 * GET WEATHER FROM API
 *
 * Request the data from wunderground.com.
 *
 * @param variable boxIndex is the index of weather box which is assigned in setup()
 *        by submitting forms.
 */
function getWeatherFromAPI(boxIndex) {
    var weatherAPI = 'http://api.wunderground.com/api/'
                        + APIKey
                        + '/conditions/forecast10day/q/'
                        + country + '/' + city + '.json';

    $.ajax({
        url         : weatherAPI,
        dataType    : 'jsonp',
        success     : function(response) {
                        loadWeather(response, boxIndex);
                        loadTime(response, boxIndex); }
    });
};

/**
 * SEND LOCATION TO DATABASE
 *
 * Pass box index, city name and country name to updatedata.php, which will send
 * these data into Table location in Database weather_box.
 *
 * @param Integer boxIndex is the index of weather box which is assigned in setup()
 *        by submitting forms.
 * @param String city is the city name from setLocation().
 * @param String country is the country name from setLocation().
 */
function sendLocationToDatabase(boxIndex, city, country) {
    $.ajax({
        type        : 'POST',
        url         : 'updatedata.php',
        dataType    : 'text',
        data        : { boxid       : boxIndex,
                        cityname    : city,
                        countryname : country},
        success     : function(response){/*console.log(response);*/}
    });
};

/**
 * GET LOCATION FROM DATABASE
 *
 * Request city name and country name from retrievedata.php, which will retrieve
 * these data from Table location in Database weather_box.
 */
function getLocationFromDatabase() {
        $.ajax({
            type        : 'GET',
            url         : 'retrievedata.php',
            dataType    : 'JSON',
            success     : function(response){/*console.log(response);*/}
        });
};

/**
 * SET LOCATION
 *
 * Segment the string, which is from form submitting, into city name and country
 * name.
 *
 * @param  Integer boxIndex is the index of weather box which is assigned in
 *         setup() by submitting forms.
 */
function setLocation(boxIndex) {
    var locationArray = [];
    var curCtIndex = "#curCt" + boxIndex;

    locationArray = $(curCtIndex).val().split(", ");

    city = locationArray[0];
    country = locationArray[1];

    if(city == null || city == ''){
        alert('Please type in a City, State/Country.');
    };

    $(curCtIndex).val(city + ', ' + country);

    getWeatherFromAPI(boxIndex);
    sendLocationToDatabase(boxIndex, city, country);
};

/**
 * SET UP
 *
 * Set up all buttons. When a button is clicked, it will assign boxIndex and pass it
 * to setLocation();
 *
 */
function setup() {
    var boxIndex;

    //--- Button 01 ---//
    $('#submit1').on('click', function(e){
        boxIndex = 1;
        e.preventDefault(e);
        setLocation(boxIndex);
        lastUpdateRefresh();
    });

    //--- Button 02 ---//
    $('#submit2').on('click', function(e){
        boxIndex = 2;
        e.preventDefault(e);
        setLocation(boxIndex);
        lastUpdateRefresh();
    });

    //--- Button 03 ---//
    $('#submit3').on('click', function(e){
        boxIndex = 3;
        e.preventDefault(e);
        setLocation(boxIndex);
        lastUpdateRefresh();
    });

    //--- Button 04 ---//
    $('#submit4').on('click', function(e){
        boxIndex = 4;
        e.preventDefault(e);
        setLocation(boxIndex);
        lastUpdateRefresh();
    });

    //--- Button 05 ---//
    $('#submit5').on('click', function(e){
        boxIndex = 5;
        e.preventDefault(e);
        setLocation(boxIndex);
        lastUpdateRefresh();
    });

    //--- Button 06 ---//
    $('#submit6').on('click', function(e){
        boxIndex = 6;
        e.preventDefault(e);
        setLocation(boxIndex);
        lastUpdateRefresh();
    });

    //--- Button 07 ---//
    $('#submit7').on('click', function(e){
        boxIndex = 7;
        e.preventDefault(e);
        setLocation(boxIndex);
        lastUpdateRefresh();
    });

    //--- Button 08 ---//
    $('#submit8').on('click', function(e){
        boxIndex = 8;
        e.preventDefault(e);
        setLocation(boxIndex);
        lastUpdateRefresh();
    });

    $('#refreshButton').on('click', function(e){
        refreshAllBoxes();
        lastUpdateRefresh();
    });
};

/**
 * REFRESH ALL BOXES
 *
 * Re-submit every form if the input value is not empty, or do nothing. The function
 * runs when the page is loaded or click refresh button.
 */
function refreshAllBoxes() {
    for (var i = 1; i <= 8; i++) {
        var curCtIndex = '#curCt' + i;

        if ($(curCtIndex).val() != '') {
            var submitIndex = '#submit' + i;
            $(submitIndex).trigger('click');
        }
    }
};

/**
 * AUTP FILL TAGS
 *
 * Set up auto fill tags manually and set it into input field.
 */
function autoFillTags() {
    var availableTags = [
        "Amsterdam, Netherlands",
        "Athens, Greece",
        "Atlanta, Georgia",
        "Bangkok, Thailand",
        "Barcelona, Spain",
        "Beijing, Beijing",
        "Berlin, Germany",
        "Boston, Massachusetts",
        "Brisbane, Australia",
        "Budapest, Hungary",
        "Buenos Aires, Argentina",
        "Cairo, Egypt",
        "Cape Town, South Africa",
        "Chicago, Illinois",
        "Delhi, India",
        "Dubai, United Arab Emirates",
        "Dublin, Ireland",
        "Florence, Italy",
        "Frankfurt, Germany",
        "Hong Kong, Hong Kong",
        "Istanbul, Turkey",
        "Jerusalem, Israel",
        "KualaLumpur, Malaysia",
        "Las Vegas, Nevada",
        "London, England",
        "Los Angeles, California",
        "Madrid, Spain",
        "Mexico, Mexico",
        "Miami, Florida",
        "Montreal, Canada",
        "Moscow, Russia",
        "Mumbai, India",
        "Munich, Germany",
        "New York, New York",
        "Rio de Janeiro, Brazil",
        "Prague, Czech Republic",
        "Rome, Italy",
        "San Francisco, California",
        "Seattle, Washington",
        "Seoul, Korea",
        "Singapore, Singapore",
        "St. Petersburg, Russia",
        "Sydney, Australia",
        "Taipei, Taiwan",
        "Tokyo, Japan",
        "Toronto, Canada",
        "Paris, France",
        "Vancouver, Canada",
        "Venice, Italy",
        "Vienna, Austria",
        "Washington, D.C."
    ];
    $( ".currentCity" ).autocomplete({
        source: availableTags,
        position: {my: "left bottom", at: "left top", collision: "flip"}
    });
};

/**
 * WINDOW.ONLOAD
 *
 * Window.onload() happens right after $(document).ready. That is, window.onload()
 * runs secondly.
 */
window.onload = function(){
    refreshAllBoxes();
    lastUpdateRefresh();
};

/**
 * DOCUMENT.READY
 *
 * $(document).ready runs before everything. It is the first function runs while
 * the page is loaded.
 */
$(document).ready(function(){
    autoFillTags();
    getLocationFromDatabase();
    setup();
});

/*
window.onload = function () {
    'use strict';

    var body = document.querySelector('body'),
        firstChildOfBody = body.firstElementChild,
        gridLayer = document.createElement('div'),
        styleSheet = document.styleSheets[0],
        gridChoice = 1;

    gridLayer.setAttribute('id', 'column-baseline-grid');

    styleSheet.insertRule('#column-baseline-grid { height: '
            + document.body.scrollHeight
            + 'px; }', 1);

    if (null !== firstChildOfBody) {
        body.insertBefore(gridLayer, firstChildOfBody);
    } else {
        body.textContent = 'The body element does not have a child element.';
    }

    gridLayer.setAttribute('class', 'all-grids');

    document.onkeydown = function (evnt) {
        if (27 === evnt.keyCode) {
            switch (gridChoice) {
            case 0:
                gridLayer.classList.add('all-grids');

                break;
            case 1:
                gridLayer.classList.remove('all-grids');
                gridLayer.classList.add('modular-grid');

                break;
            case 2:
                gridLayer.classList.remove('modular-grid');
                gridLayer.classList.add('column-grid');

                break;
            case 3:
                gridLayer.classList.remove('column-grid');
                gridLayer.classList.add('baseline-grid');

                break;
            case 4:
                gridLayer.classList.remove('baseline-grid');

                break;
            }

            if (gridChoice++ === 4) {
                gridChoice = 0;
            }
        }
    };
};
*/
