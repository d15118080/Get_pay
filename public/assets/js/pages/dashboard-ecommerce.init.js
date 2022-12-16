function getChartColorsArray(e) {
    if (null !== document.getElementById(e)) {
        var o = document.getElementById(e).getAttribute("data-colors");
        if (o) return (o = JSON.parse(o)).map(function (e) {
            var o = e.replace(" ", "");
            return -1 === o.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(o) || o : 2 == (e = e.split(",")).length ? "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")" : o
        });
        console.warn("data-colors atributes not found on", e)
    }
}
 function chart_init(date,money_arr,wi_arr) {
    var options, chart, worldemapmarkers, overlay,
        linechartcustomerColors = getChartColorsArray("customer_impression_charts"),
        chartDonutBasicColors = (linechartcustomerColors && (options = {
            series: [{
                name: "출금",
                type: "area",
                data: wi_arr
            }, {
                name: "입금",
                type: "bar",
                data: money_arr
            }
            ],
            chart: {height: 370, type: "line", toolbar: {show: !1}},
            stroke: {curve: "straight", dashArray: [0, 0, 8], width: [2, 0, 2.2]},
            fill: {opacity: [.1, .9, 1]},
            markers: {size: [0, 0, 0], strokeWidth: 2, hover: {size: 4}},
            xaxis: {
                categories: date,
                axisTicks: {show: !1},
                axisBorder: {show: !1}
            },
            grid: {
                show: !0,
                xaxis: {lines: {show: !0}},
                yaxis: {lines: {show: !1}},
                padding: {top: 0, right: -2, bottom: 15, left: 10}
            },
            legend: {
                show: !0,
                horizontalAlign: "center",
                offsetX: 0,
                offsetY: -5,
                markers: {width: 9, height: 9, radius: 6},
                itemMargin: {horizontal: 10, vertical: 0}
            },
            plotOptions: {bar: {columnWidth: "30%", barHeight: "70%"}},
            colors: linechartcustomerColors,

        }, (chart = new ApexCharts(document.querySelector("#customer_impression_charts"), options)).render()), getChartColorsArray("store-visits-source")),
        vectorMapWorldMarkersColors = (chartDonutBasicColors && (options = {
            series: [44, 55, 41, 17, 15],
            labels: ["Direct", "Social", "Email", "Other", "Referrals"],
            chart: {height: 333, type: "donut"},
            legend: {position: "bottom"},
            stroke: {show: !1},
            dataLabels: {dropShadow: {enabled: !1}},
            colors: chartDonutBasicColors
        }))
}
export {
    chart_init,
};
