function drawScatterChart(chart_id, chart_data, shadow_color,
                    min_border_color, min_point_bg_color, min_point_border_color,
                    max_border_color, max_point_bg_color, max_point_border_color,
                    avg_border_color, avg_point_bg_color, avg_point_border_color,
                    x_axis_color, y_axis_color, y_axis_label , data_stream_name) {
    var ctx = document.getElementById(chart_id).getContext("2d");
    var crisis_desc = chart_data.crisis_stream_desc
    var scatterChart = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [
                {
                    label: "Crisis",
                    data: chart_data.crisis_stream,
                    borderColor: 'red',
                    borderWidth: 4,
                    pointBackgroundColor: 'red', //add to array if you want more colors
                    pointBorderColor: 'red',
                    pointRadius: 4,
                    pointHoverRadius: 4,
                    // fill:false,
                    fill: '-1',
                    backgroundColor : shadow_color,
                    showLine: false
                },
                {
                    label: "Avg",
                    data: chart_data.average_stream,
                    borderColor: avg_border_color,
                    borderWidth: 2,
                    pointBackgroundColor: avg_point_bg_color,
                    pointBorderColor: avg_point_border_color,
                    pointRadius: 2,
                    pointHoverRadius: 0,
                    fill:false,
                    tension: 0.5,
                    showLine: true,
                },
                {
                    label: "Min",
                    data: chart_data.minimum_stream,
                    borderColor: min_border_color,
                    borderWidth: 0.2,
                    pointBackgroundColor: min_point_bg_color, 
                    pointBorderColor: min_point_border_color,
                    pointRadius: 0.2,
                    pointHoverRadius: 0,
                    fill:false,
                    // fill: true,
                    // backgroundColor : "#ffffff",
                    tension: 0.5,
                    showLine: true
                },
                {
                    label: "Max",
                    data: chart_data.maximum_stream,
                    borderColor: max_border_color,
                    borderWidth: 0.2,
                    pointBackgroundColor: max_point_bg_color, //add to array if you want more colors
                    pointBorderColor: max_point_border_color,
                    pointRadius: 0.2,
                    pointHoverRadius: 0,
                    // fill:false,
                    fill: '-1',
                    backgroundColor : shadow_color,
                    tension: 0.5,
                    showLine: true
                },
                
                
            ]
        },
        options: {
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            legend: {
                display: false
            },
            tooltips: {
                filter: function (tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label;
                    if (label == "Crisis") {
                        tooltipItem.xLabel = crisis_desc[tooltipItem.index]["timestamp"]
                        tooltipItem.yLabel = crisis_desc[tooltipItem.index]["name"]
                        return true;
                    }else{
                        return false;
                    }
                    
                }
            },
            scales: {
                xAxes: [{
                    type: 'linear',
                    position: 'bottom',
                    gridLines: {
                        color: x_axis_color,
                        drawOnChartArea: false,
                        
                        

                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Samples'
                    },
                    ticks: {
                        display: false,
                        max: chart_data.average_stream[chart_data.average_stream.length - 1].x
                    },
                    
                }],
                yAxes: [{
                    type: 'linear',
                    gridLines: {
                        color: y_axis_color,
                        drawOnChartArea: false,
                        
                    },
                    scaleLabel: {
                        display: true,
                        labelString: y_axis_label,
                        fontColor: x_axis_color,
                    },
                    ticks: {
                        fontColor: x_axis_color
                    }
                },
            ]},
            animation: {
                duration: 1000,
                easing: 'linear'
            
            }
        }
    }); 
}


function drawDoughnutChart(chart_id,chart_data){
    var ctx = document.getElementById(chart_id).getContext("2d");
    var options = {
        legend: {
            display: false
        },
        animation: {
            duration: 1000,
            easing: 'linear'
        }
    }
    var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: chart_data,
        options: options
    });
}
