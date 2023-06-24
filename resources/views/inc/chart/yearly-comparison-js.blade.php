<script>
    $(function() {
        // Get Chart Canvas
        var commodity = <?php echo $commodity; ?>;
        let commodityName = "\"<?php echo $commodityName; ?>\"";
        var year = <?php echo $year; ?>;
        var yearCompare = <?php echo $yearCompare; ?>;
        var cData = JSON.parse('<?php echo $data; ?>');
        var cDataCompare = JSON.parse('<?php echo $dataCompare; ?>');
        var ctx = $("#yearlyAreaChart");
        // Chart Data
        var data = {
            labels: cData.label,
            datasets: [
                {
                    label: "Tahun "+year,
                    data: cData.data,
                    lineTension: 0.3,
                    backgroundColor: "rgba(0, 97, 242, 0.05)",
                    borderColor: "rgba(0, 97, 242, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(0, 97, 242, 1)",
                    pointBorderColor: "rgba(0, 97, 242, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(0, 97, 242, 1)",
                    pointHoverBorderColor: "rgba(0, 97, 242, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2
                }, {
                    label: "Tahun "+yearCompare,
                    data: cDataCompare.data,
                    lineTension: 0.3,
                    backgroundColor: "rgba(0, 0, 0, 0.05)",
                    borderColor: "rgba(0, 0, 0, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(0, 0, 0, 1)",
                    pointBorderColor: "rgba(0, 0, 0, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(0, 0, 0, 1)",
                    pointHoverBorderColor: "rgba(0, 0, 0, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2
                }
            ]
        };
        // Options
        var options = {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: "month"
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return "Rp. " + number_format(value, 0, ",", ".");
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }]
            },
            title: {
                display: true,
                position: "top",
                text: "Perbandingan Harga Komoditas "+commodityName+" Tahunan",
                fontSize: 15,
                fontColor: "#111"
            },
            legend: {
                display: true,
                position: "bottom",
                labels: {
                fontColor: "#333",
                fontSize: 13
                }
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: "#6e707e",
                titleFontSize: 14,
                borderColor: "#dddfeb",
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: "index",
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel =
                            chart.datasets[tooltipItem.datasetIndex].label || "";
                        return datasetLabel + ": Rp. " + number_format(tooltipItem.yLabel, 0, ',', '.');
                    }
                }
            }
        };
        // Create Chart Class Object
        var myLineChart = new Chart(ctx, {
            type: "line",
            data: data,
            options: options
        });
    });
</script>