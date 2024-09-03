/* ------------------------------------------------------------------------------
 *
 *  # Dashboard JS
 *
 * ---------------------------------------------------------------------------- */

// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {

});

$(function () {
  $("#dashboard_stats_period").on('change', function() {
    var time_period = $(this).val();
    if (time_period === 'Today') {
      dateFilterType = 'Today';
    }
    if (time_period === 'Week') {
      dateFilterType = 'Week';
    }
    if (time_period === 'Month') {
      dateFilterType = 'Month';
    }
    callData();
  });
  callData();
});

function callData() {
  $.get(chartDataRoute, { dateFilterType: dateFilterType}, function (response) {
    firstGraph(response[0].user_status, response[0].label);
    secondGraph(response[1].user_visited, response[1].label);
    thirdGraph(response[2].user_opened_app, response[2].label);
    fourthGraph(response[3].guys_and_girls, response[3].label);
  });
}

function firstGraph(data, label) {
  let firstGraph = {
    type: 'line',
    data: {
      labels: label,
      datasets: [
        {
          label: data.new_users.title,
          data: data.new_users.count,
          fill: false,
          lineTension: 0.4,
          radius: 5,
          borderColor: [
            '#56B2FF',
          ],
          color: [
            '#56B2FF',
          ],
          backgroundColor: [
            '#56B2FF',
          ],
          borderWidth: 2
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      scales: {
        yAxes: [{
          ticks: {
            min: 0,
            stepSize: 1
          }
        }],
        xAxes: [{
          ticks: {
            display: true
          }
        }]
      }
    }
  };
  let graphs = [];
  let messageGraphOption = JSON.parse(JSON.stringify(firstGraph));
  messageGraphOption.data.datasets[0].label = 'Amount of users';
  let ctx1 = document.getElementById('first-graph').getContext('2d');
  $('.first-graph-new-data').html(data.user_count);
  graphs['first-graph'] = new Chart(ctx1, messageGraphOption);
};

function secondGraph(data, label) {
  let secondGraph = {
    type: 'line',
    data: {
      labels: label,
      datasets: [
        {
          label: data.visited.title,
          data: data.visited.count,
          fill: false,
          lineTension: 0.4,
          radius: 5,
          borderColor: [
            '#56B2FF',
          ],
          color: [
            '#56B2FF',
          ],
          backgroundColor: [
            '#56B2FF',
          ],
          borderWidth: 2
        },
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      scales: {
        yAxes: [{
          ticks: {
            min: 0,
            stepSize: 1
          }
        }],
        xAxes: [{
          ticks: {
            display: true
          }
        }]
      }
    }
  };
  let graphs = [];
  let messageGraphOption = JSON.parse(JSON.stringify(secondGraph));
  messageGraphOption.data.datasets[0].label = 'Number of app visited users';
  let ctx1 = document.getElementById('second-graph').getContext('2d');
  $('.second-graph-new-data').html(data.visited_count);
  graphs['second-graph'] = new Chart(ctx1, messageGraphOption);
};

function thirdGraph(data, label) {
  let thirdGraph = {
    type: 'line',
    data: {
      labels: label,
      datasets: [
        {
          label: data.opened.title,
          data: data.opened.count,
          fill: false,
          lineTension: 0.4,
          radius: 5,
          borderColor: [
            '#56B2FF',
          ],
          color: [
            '#56B2FF',
          ],
          backgroundColor: [
            '#56B2FF',
          ],
          borderWidth: 2
        },
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      scales: {
        yAxes: [{
          ticks: {
            min: 0,
            stepSize: 1
          }
        }],
        xAxes: [{
          ticks: {
            display: true
          }
        }]
      }
    }
  };
  let graphs = [];
  let messageGraphOption = JSON.parse(JSON.stringify(thirdGraph));
  messageGraphOption.data.datasets[0].label = 'App opened by number of users';
  let ctx1 = document.getElementById('third-graph').getContext('2d');
  $('.third-graph-new-data').html(data.app_opened_count);
  graphs['third-graph'] = new Chart(ctx1, messageGraphOption);
};

function fourthGraph(data, label) {
    let fourthGraph = {
      type: 'line',
      data: {
        labels: label,
        datasets: [
          {
            label: data.guys.title,
            data:  data.guys.count,
            fill: false,
            lineTension: 0.4,
            radius: 5,
            borderColor: [
              '#56B2FF',
            ],
            color: [
              '#56B2FF',
            ],
            backgroundColor: [
              '#56B2FF',
            ],
            borderWidth: 2
          },
          {
              label: data.girls.title,
              data: data.girls.count,
              fill: false,
              lineTension: 0.4,
              radius: 5,
              borderColor: [
                '#727272',
              ],
              color: [
                '#727272',
              ],
              backgroundColor: [
                '#727272',
              ],
              borderWidth: 2
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          yAxes: [{
            ticks: {
              min: 0,
              stepSize: 1
            }
          }],
          xAxes: [{
            ticks: {
              display: true
            }
          }]
        }
      }
    };
  let graphs = [];
  let messageGraphOption = JSON.parse(JSON.stringify(fourthGraph));
  messageGraphOption.data.datasets[0].label = 'Number of guys';
  messageGraphOption.data.datasets[1].label = 'Number of girls';
  let ctx1 = document.getElementById('fourth-graph').getContext('2d');
  $('.first-graph-guys-data').html(data.guys_count);
  $('.first-graph-girls-data').html(data.girls_count);
  graphs['fourth-graph'] = new Chart(ctx1, messageGraphOption);
};
