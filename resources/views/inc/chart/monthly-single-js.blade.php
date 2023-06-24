<script>
    $(function() {
        // Get Chart Canvas
        var commodity = <?php echo $commodity; ?>;
        let commodityName = "\"<?php echo $commodityName; ?>\"";
        var year = <?php echo $year; ?>;
        var month = <?php echo $month; ?>;
        var cData = JSON.parse('<?php echo $data; ?>');
        var ctx = $("#monthlyBarChart");
        // Chart Data
        var data = {
            labels: cData.label,
            datasets: [
                {
                    label: "Harga",
                    data: cData.data,
                    backgroundColor: "rgba(0, 97, 242, 1)",
                    hoverBackgroundColor: "rgba(0, 97, 242, 0.9)",
                    borderColor: "#4e73df",
                    maxBarThickness: 25
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
                        unit: "day"
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
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
                text: "Harga Komoditas "+commodityName+" Bulanan - Tahun "+year+" Bulan "+month,
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
                titleMarginBottom: 10,
                titleFontColor: "#6e707e",
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: "#dddfeb",
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel =
                            chart.datasets[tooltipItem.datasetIndex].label || "";
                        return datasetLabel + ": Rp. " + number_format(tooltipItem.yLabel, 0, ",", ".");
                    }
                }
            }
        };
        // Create Chart Class Object
        var myBarChart = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options
        });
    });
</script>