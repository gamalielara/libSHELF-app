const xThisYear = new Set(genresArrayThisYear);
const xyThisYearValues = [];
const thisYear = new Date().getFullYear();
let thisYearMaxValue = 0;

const xAllYears = new Set(genresArrayAllYears);
const xyAllYearsValues = [];
let allYearMaxValue = 0;

xThisYear.forEach(g => {
    let count = 0;
    const xy = {};
    genresArrayThisYear.forEach(genre => {
      if(g === genre){
        count++;
      }

      if(thisYearMaxValue === 0){
        thisYearMaxValue = count;
      } else {
        if(count > thisYearMaxValue){
          thisYearMaxValue = count;
        }
      }

    });
    xy['x'] = g;
    xy['y'] = count;
    xyThisYearValues.push(xy);
});

const bookChart = new Chart(document.getElementById('bookChart'), {
    type: 'line',
    data: {
        labels: xyThisYearValues.map((xy) => xy.x.toString()),
        datasets: [{
            label: thisYear,
            pointRadius: 4,
            pointBackgroundColor: "rgba(0,0,255,1)",
            data: xyThisYearValues.map((xy) => xy.y),
        }]
    },
    options: {
        responsive: true,
        scales: {
          x: {
            title: {
                display: true,
                text: 'Genres'
            }
          },
          y: {
            type: 'linear',
            title: {
              display: true,
              text: 'Value'
            },
            min: 0,
            max: thisYearMaxValue + 2,
            ticks: {
              // forces step size to be 50 units
              stepSize: 1,
            }
          }
        }
    },
});

xAllYears.forEach(g => {
    let count = 0;
    const xy = {};
    genresArrayThisYear.forEach(genre => {
        if(g === genre){
          count++;
        }

        if(allYearMaxValue === 0){
          allYearMaxValue = count;
        } else {
          if(count > allYearMaxValue){
            allYearMaxValue = count;
          }
        }
    });
    xy['x'] = g;
    xy['y'] = count;
    xyAllYearsValues.push(xy);
});

const bookChartAllYears = new Chart(document.getElementById('bookChartAllYears'), {
    type: 'line',
    data: {
        labels: xyAllYearsValues.map((xy) => xy.x.toString()),
        datasets: [{
            label: "All Years",
            pointRadius: 4,
            pointBackgroundColor: "rgba(0,0,255,1)",
            data: xyAllYearsValues.map((xy) => xy.y),
        }]
    },
    options: {
        responsive: true,
        scales: {
          x: {
            title: {
                display: true,
                text: 'Genres'
            }
          },
          y: {
            type: 'linear',
            title: {
              display: true,
              text: 'Value'
            },
            min: 0,
            max: allYearMaxValue + 2,
            ticks: {
              stepSize: 1,
            }
          }
        }
    },
});