import Chart from "chart.js";
import "./roundedCornersExtension";

function randomScalingFactor() {
    return Math.round(Math.random() * 100);
}

export const lineChart = {
    createChart(chartId, data, labels) {
        const ctx = document.getElementById(chartId).getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Eventos",
                        tension: 0.4,
                        borderWidth: 4,
                        borderColor: "#5e72e4",
                        pointRadius: 0,
                        backgroundColor: "transparent",
                        data: data,
                        barPercentage: 1.6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: true,
                    mode: "index",
                    intersect: false,
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: "transparent",
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                padding: 0,
                                fontColor: "#8898aa",
                                fontSize: 13,
                                fontFamily: "Open Sans",
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: "rgba(29,140,248,0.0)",
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                padding: 10,
                                fontColor: "#8898aa",
                                fontSize: 13,
                                fontFamily: "Open Sans",
                            },
                        },
                    ],
                },
                layout: {
                    padding: 0,
                },
            },
        });
    },
};

export const barChart = {
    createChart(chartId, labels, data, tagLabel, barColor = "#fb6340") {
        const ctx = document.getElementById(chartId).getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: tagLabel,
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        backgroundColor: barColor,
                        data: data,
                        maxBarThickness: 30,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: true,
                    mode: "index",
                    intersect: false,
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                borderDash: [2],
                                borderDashOffset: [2],
                                zeroLineColor: "#dee2e6",
                                drawBorder: false,
                                drawTicks: true,
                                lineWidth: 1,
                                zeroLineWidth: 1,
                                zeroLineBorderDash: [2],
                                zeroLineBorderDashOffset: [2],
                            },
                            ticks: {
                                beginAtZero: true,
                                padding: 10,
                                fontSize: 13,
                                fontColor: "#8898aa",
                                fontFamily: "Open Sans",
                                callback: function (value) {
                                    if (!(value % 1)) {
                                        return value;
                                    }
                                },
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                            },
                            ticks: {
                                padding: 20,
                                fontSize: 13,
                                fontColor: "#8898aa",
                                fontFamily: "Open Sans",
                            },
                        },
                    ],
                },
            },
        });
    },
};

export const dotsChart = {
    createChart(chartId) {
        const ctx = document.getElementById(chartId).getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: ["May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    {
                        label: "Performance",
                        tension: 0.4,
                        data: [10, 18, 28, 23, 28, 40, 36, 46, 52],
                        pointRadius: 10,
                        pointBackgroundColor: "#5e72e4",
                        pointBorderColor: "#5e72e4",
                        pointHoverRadius: 15,
                        showLine: false,
                        barPercentage: 1.6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: true,
                    mode: "index",
                    intersect: false,
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                borderDash: [2],
                                borderDashOffset: [2],
                                color: "#e9ecef",
                                zeroLineColor: "#e9ecef",
                            },
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 60,
                                padding: 20,
                                fontColor: "#8898aa",
                                fontSize: 13,
                                fontFamily: "Open Sans",
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: "rgba(29,140,248,0.0)",
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                padding: 10,
                                fontColor: "#8898aa",
                                fontSize: 13,
                                fontFamily: "Open Sans",
                            },
                        },
                    ],
                },
                layout: {
                    padding: 0,
                },
            },
        });
    },
};

export const doughnutChart = {
    createChart(chartId, data, labels) {
        const ctx = document.getElementById(chartId).getContext("2d");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Dataset 1",
                        tension: 0.4,
                        data: data,
                        backgroundColor: [
                            "#2dce89",
                            "#fb6340",
                            "#f5365c",
                        ],
                        showLine: false,
                        barPercentage: 1.6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 83,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: true,
                    mode: "index",
                    intersect: false,
                },
                scales: {
                    display: false,
                    yAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: "transparent",
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: "transparent",
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    ],
                },
                layout: {
                    padding: 0,
                },
            },
        });
    },
};

export const pieChart = {
    createChart(chartId) {
        const ctx = document.getElementById(chartId).getContext("2d");

        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Danger", "Warning", "Success", "Primary", "Info"],
                datasets: [
                    {
                        label: "Dataset 1",
                        tension: 0.4,
                        data: [
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                            randomScalingFactor(),
                        ],
                        backgroundColor: [
                            "#f5365c",
                            "#fb6340",
                            "#2dce89",
                            "#5e72e4",
                            "#11cdef",
                        ],
                        showLine: false,
                        barPercentage: 1.6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 0,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: true,
                    mode: "index",
                    intersect: false,
                },
                scales: {
                    display: false,
                    yAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: "transparent",
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: "transparent",
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                display: false,
                            },
                        },
                    ],
                },
                layout: {
                    padding: 0,
                },
            },
        });
    },
};

export const barChartStacked = {
    createChart(chartId, dataset, labels) {
        const ctx = document.getElementById(chartId).getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: dataset
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 0,
                barPercentage: 1.6,
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: true,
                    mode: "index",
                    intersect: false,
                },
                scales: {
                    display: false,
                    yAxes: [
                        {
                            stacked: true,
                            gridLines: {
                                borderDash: [2],
                                borderDashOffset: [2],
                                zeroLineColor: "#dee2e6",
                                drawBorder: false,
                                drawTicks: false,
                                lineWidth: 1,
                                zeroLineWidth: 1,
                                zeroLineBorderDash: [2],
                                zeroLineBorderDashOffset: [2],
                            },
                            ticks: {
                                beginAtZero: true,
                                padding: 10,
                                fontSize: 13,
                                fontColor: "#8898aa",
                                fontFamily: "Open Sans",
                            },
                        },
                    ],
                    xAxes: [
                        {
                            stacked: true,
                            gridLines: {
                                drawBorder: false,
                                color: "transparent",
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                fontSize: 13,
                                fontColor: "#8898aa",
                                fontFamily: "Open Sans",
                            },
                        },
                    ],
                },
                layout: {
                    padding: 0,
                },
            },
        });
    },
};

const funcs = {
    lineChart() {},
    barChart() {},
    dotsChart() {},
    doughnutChart() {},
    pieChart() {},
    barChartStacked() {},
};

export default funcs;
