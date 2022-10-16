# About the project

This is a project that reads a csv file with data of dollar rate and the date but i am required to read the csv file and convert it to a virtual presentation in php

## Approaches

- I will use [chart.js](https://www.chartjs.org) for a chart representaton
- I used [php-router library](https://github.com/aosasona/php-router) for easy routing
- for showing the chart i built a mini api to be consumed by the frontend while other datas are been echoed out directly

### Running it

##### Clone the project

 ```bash
  git clone https://github.com/codad5/php-csv-to-chart
 ```

##### Install all dependecies

```bash
composer install
```

##### Serve Your Project

```shell
php -S localhost:2000
```

![Screenshot](/public/Sample1.png)

![Screenshot](/public/Sample2.png)
### Routes

- Index route `/` - This Shows the list of all avaliable rates and dates and also show then in a chart form
- `/rates/:date` - This is to show the rate of a particular date given
- `/api/rates` - This is to get all rate data
- `/api/rates/:date` - This is to get a particular rate based on the given date
